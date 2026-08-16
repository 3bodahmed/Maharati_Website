<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

protected $table = 'post';
    protected $fillable = [
        'typeRequest',   // ✅ أضف هذا الحقل
        'title',
        'content',
        'location',
        'price',
        'image',
        'user_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'image' => 'array', // إذا كنت تخزن الصور كـ JSON
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
