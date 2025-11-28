<?php
namespace App\Modelos;
use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $table = 'users';
    protected $fillable = 
    ['name',
    'email',
    'password',
    'role',
    'token'];
    public $timestamps = true;
}
