@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container" style="padding: 12rem 0 8rem; min-height: 70vh;">
    <div style="max-width: 800px; margin: 0 auto; text-align: center; background: var(--bg-card); padding: 4rem; border-radius: 8px; border: 1px solid var(--border-color); box-shadow: var(--shadow-soft);">
        <h1 style="font-family: var(--font-heading); font-size: 3rem; color: var(--text-primary); margin-bottom: 2rem;">{{ $title }}</h1>
        <p style="color: var(--text-secondary); font-size: 1.1rem; line-height: 1.8; margin-bottom: 2rem;">
            This page is currently being curated by our luxury editorial team. Please check back soon for our complete {{ strtolower($title) }} details.
        </p>
        <a href="{{ url('/') }}" class="btn-primary">Return to Showroom</a>
    </div>
</div>
@endsection
