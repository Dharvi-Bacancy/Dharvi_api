<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News_update extends Model
{
    use HasFactory;
    protected $table = "news_update";
    protected $fillable = [
        'news_update',
    ];
}
