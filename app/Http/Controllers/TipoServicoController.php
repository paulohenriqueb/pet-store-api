<?php

namespace App\Http\Controllers;

use App\Models\TipoServico;
use Illuminate\Http\Request;

class TipoServicoController extends Controller
{
    public function __construct(TipoServico $tipoServico){
        $this->tipoServico = $tipoServico;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoServico = $this->tipoServico->get();
        return response()->json($tipoServico, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipoServico = $this->tipoServico;
        $request->validate($tipoServico->rules());
        $tipoServico->create($request->all());
        return response()->json($tipoServico, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoServico = $this->tipoServico->find($id);
        if($tipoServico === null){
            return response()->json(['error' => 'Não foi encontrado registros na base de dados.'], 404);
        }
        return response()->json($tipoServico, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tipoServico = $this->tipoServico->find($id);
        if($tipoServico === null){
            return response()->json(
                ['error'=>'Não foi possível efetuar a atualização. O registro Solicitado não existe na base de dados.'],
                 404);
        }
        if($request->method() === 'PATCH'){
            $dinamicRules = array();
            foreach($tipoServico->rules() as $key => $servico){
                if(array_key_exists($key, $request->all())){
                    $dinamicRules[$key] = $servico;
                }
            }
            $request->validate($dinamicRules);
        }else{
            $request->validate($tipoServico->rules());
        }
        $tipoServico->fill($request->all());
        $tipoServico->save();
        return response()->json($tipoServico, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipoServico = $this->tipoServico->find($id);
        if($tipoServico === null){
            return response()->json(['error' => 'Impossível realizar a exclusão. O recurso solicitado não existe.']);
        }
        $tipoServico->delete();
        return response()->json(['msg' => 'Informação excluida com sucesso!']);
    }
}
