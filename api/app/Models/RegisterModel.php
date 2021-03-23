<?php

namespace App\Models;
use App\Models\RegisterModel;
use App\Models\Validate_email;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
//use Illuminate\Foundation\Auth\RegisterModel as Authenticatable;

class RegisterModel extends Model implements JWTSubject,AuthenticatableContract,CanResetPasswordContract
{
    use HasFactory;
    use Notifiable;
    use Authenticatable, CanResetPassword;
    protected $table = "register";
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'type',
    ];
    
 
    
    public function validate_email()
    {
       return $this->hasOne('App\Models\Validate_email');
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
