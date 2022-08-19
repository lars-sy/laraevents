<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; //apelido, pois o nome User ja esta sendo usado na classe abaixo


class User extends Authenticatable 
{

    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'cpf',
        'password',
        'role'
    ];

    protected $hidden = [ 
        'password'
    ];


    //relationships
    public function address(){
        return $this->hasOne(Address::class); 
    }

    //1:n
    public function phones(){
        return $this->hasMAny(Phone::class);
    }

    public function events(){
        return $this->belongsToMany(Event::class);
    }

    //mutators
    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value); //quando setar o atributo password, insira o valor hash na senha
    }
}


