<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'cep',
        'street',
        'number',
        'uf',
        'city',
        'district',
        'complement',
        'user_id'

    ];
    //onde existir cha estrageira, usa-se belongsTO. e o outro hjasOne
    //relationships
    public function user(){ //a partir do nome do metodo ira procurar um campo q tem o nome do metodo user_id 
        return $this->belongsTo(User::class); //estabelecer uma relacao entre endereco e user
        
    }
}


