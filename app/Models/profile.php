<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    use HasFactory;

    protected $table = 'profile'; 

    protected $fillable = [
        'name',   
        'jobs',
        'experience',
        'bio',
        'price',
        'location',
        'description',
        'image',
        'works', 
        'user_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'image' => 'array',
        'works' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
