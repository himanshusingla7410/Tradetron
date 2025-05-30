<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribers extends Model
{
    /** @use HasFactory<\Database\Factories\SubscribersFactory> */
    use HasFactory;

    protected $guarded = [];
}
