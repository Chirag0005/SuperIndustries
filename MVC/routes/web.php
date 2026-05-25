<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    $featuredProducts = \App\Models\Product::where('is_featured', true)->take(4)->get();
    return view('welcome', compact('featuredProducts'));
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Route (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $orders = auth()->user()->orders;
        return view('dashboard', compact('orders'));
    })->name('dashboard');

    // Admin Routes
    Route::get('/admin', function () {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }
        $ordersCount = \App\Models\Order::count();
        $productsCount = \App\Models\Product::count();
        $inquiries = \App\Models\B2bInquiry::all();
        
        return view('admin', compact('ordersCount', 'productsCount', 'inquiries'));
    })->name('admin');

    Route::get('/admin/orders/live', function () {
        if (!auth()->user()->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $orders = \App\Models\Order::with('user')->orderBy('created_at', 'desc')->get();
        return response()->json($orders);
    })->name('admin.orders.live');

    Route::post('/admin/orders/{order}/status', function (\App\Models\Order $order, \Illuminate\Http\Request $request) {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }
        
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered'
        ]);
        
        $order->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'Order status updated successfully!');
    })->name('admin.orders.status');
});

Route::get('/shop', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Product::query();
    
    if ($request->has('category') && $request->category != '') {
        $category = \App\Models\Category::where('slug', $request->category)->first();
        if ($category) {
            $query->where('category_id', $category->id);
        }
    }

    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
    
    $products = $query->paginate(12)->withQueryString();
    return view('shop', compact('products'));
});

Route::get('/product/{slug}', function ($slug) {
    $product = \App\Models\Product::where('slug', $slug)->firstOrFail();
    return view('product', compact('product'));
});

Route::get('/b2b', function () {
    return view('b2b');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/pages/{slug}', function ($slug) {
    $title = ucwords(str_replace('-', ' ', $slug));
    return view('page', compact('title'));
});

Route::post('/b2b', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'company' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'nullable|string',
        'message' => 'required|string',
    ]);
    
    \App\Models\B2bInquiry::create($validated);
    
    return redirect('/b2b')->with('success', 'Your inquiry has been submitted successfully.');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::post('/cart/add/{id}', function (\Illuminate\Http\Request $request, $id) {
    $product = \App\Models\Product::findOrFail($id);
    $cart = session()->get('cart', []);
    
    if(isset($cart[$id])) {
        $cart[$id]['quantity'] += $request->quantity;
    } else {
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => $request->quantity,
            "price" => $product->price,
            "image" => $product->image
        ];
    }
    
    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Product added to cart successfully!');
});

Route::post('/cart/remove/{id}', function ($id) {
    $cart = session()->get('cart');
    if(isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }
    return redirect()->back()->with('success', 'Product removed successfully');
});

Route::get('/checkout', function () {
    return view('checkout');
});

Route::post('/checkout', function (\Illuminate\Http\Request $request) {
    if (!auth()->check()) {
        return redirect('/login')->withErrors(['login' => 'Please login to complete your purchase.']);
    }

    $cart = session()->get('cart', []);
    if(empty($cart)) {
        return redirect('/cart')->withErrors(['cart' => 'Your cart is empty.']);
    }

    $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email',
        'address' => 'required',
    ]);

    $totalAmount = 0;
    foreach($cart as $item) {
        $totalAmount += $item['price'] * $item['quantity'];
    }

    // Create Order
    $order = \App\Models\Order::create([
        'user_id' => auth()->id(),
        'total_amount' => $totalAmount,
        'status' => 'pending',
        'shipping_address' => $request->address,
        'billing_address' => $request->address, // Simplified
        'payment_method' => 'card',
    ]);

    // Create Order Items
    foreach($cart as $id => $item) {
        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $id,
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);
    }

    return redirect('/payment/' . $order->id);
});

// Custom Payment Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/payment/{order}', function (\App\Models\Order $order) {
        if ($order->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }
        return view('payment', compact('order'));
    })->name('payment');

    Route::post('/payment/{order}/process', function (\App\Models\Order $order, \Illuminate\Http\Request $request) {
        if ($order->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }
        
        $method = $request->input('payment_method', 'card');
        
        $order->update([
            'status' => 'processing',
            'payment_method' => $method
        ]);
        
        session()->forget('cart');
        
        return redirect('/checkout/success')->with('success', 'Payment successful!');
    });
});

Route::get('/checkout/success', function () {
    return view('checkout-success');
});

Route::get('/checkout/cancel', function () {
    return redirect('/cart')->withErrors(['error' => 'Payment was cancelled.']);
});
