<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class B2bInquiry extends Model
{
    protected $fillable = ['name', 'company', 'email', 'phone', 'message', 'status'];
}
