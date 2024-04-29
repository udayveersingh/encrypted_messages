<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'text',
        'recipient',
        'expiry',
    ];

    protected $dates = [
        'expiry',
        'deleted_at', // if using soft deletes
    ];
}
