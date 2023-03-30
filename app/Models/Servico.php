<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = ['tipo_servico_id', 'leva', 'traz', 'agendado', 'data_agendamento'];

    public function rules(){
        return [
            'tipo_servico_id' => 'required',
            'leva' =>'required',
            'traz' => 'required',
            'agendado' => 'required'
        ];
    }


}
