<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'tipo', 'preco', 'descricao', 'tipo_pet'];

    public function rules(){
        return [
            'nome' => 'required|min:3',
            'tipo' => 'required|min:3',
            'preco' => 'required',
            'descricao' => 'required',
            'tipo_pet' => 'required'
        ];
    }
}
