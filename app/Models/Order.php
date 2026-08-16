<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'provider_id', 'post_id', 'title', 'description', 'location', 'price', 'status'];

public function user()
{
    return $this->belongsTo(User::class);
}

public function provider()
{
    return $this->belongsTo(User::class, 'provider_id');
}

public function post()
{
    return $this->belongsTo(Post::class);
}
}
