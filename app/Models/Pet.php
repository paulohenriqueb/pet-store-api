<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;
    protected $fillable = ['servico_id', 'nome', 'peso', 'raca', 'porte', 'idade'];
    public function rules(){
        return [
            'servico_id' => 'required',
            'nome' => 'required|min:3',
            'peso' => 'required',
            'raca' => 'required|min:4',
            'porte' => 'required|min:4',
            'idade' =>'required'
        ];
    }
}
