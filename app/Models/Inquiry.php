<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $table = 'inquiries';

    protected $fillable = ['name', 'company', 'email', 'country', 'message', 'ip', 'user_agent', 'read_at'];

    protected $casts = ['read_at' => 'datetime'];
}
