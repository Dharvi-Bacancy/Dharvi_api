<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounttype extends Model
{
    use HasFactory;
    protected $table = "accounttype";
    protected $fillable = [
        'register_model_id',
        'account_type',
        'date',
       
    ];
}
