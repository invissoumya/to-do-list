<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Registration extends Model
{
    use HasApiTokens, HasFactory;
    protected $fillable = ['first_name','last_name','email','password','remember_token'];
    protected $hidden = [
        'password',
        'remember_token'
       
    ];
}
