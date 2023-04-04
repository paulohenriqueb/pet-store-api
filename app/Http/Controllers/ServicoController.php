<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{

    public function __construct(Servico $servico){
        $this->servico = $servico;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servico = $this->servico;
        return response()->json($servico->get(), 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $servico = $this->servico;
        $request->validate($servico->rules());

        return response()->json($servico::create($request->all()), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servico = $this->servico->find($id);
        if($servico === null){
            return response()->json(['error' => 'Não foi localizado recursos para esse id.'], 404);
        }
        return response()->json($servico, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $servico = $this->servico->find($id);
        if($servico === null){
            return response()->json(
                ['error' =>
                'Não foi possível efetuar a alteração do elemento.
                Pois não foi encontrado o(s) recursos na base de dados']
                    , 404
                );
        }
        if($request->method() === 'PATCH'){
            $dinamicRules = array();
            foreach($servico->rules() as $key => $rule){
                if(array_key_exists($key, $request->all())){
                    $dinamicRules[$key] = $rule;
                }
            }
            $request->validate($dinamicRules);
        }else{
            $request->validate($servico->rules());
        }
        $servico->fill($request->all());
        $servico->save();
        return response()->json($servico, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $servico = $this->servico->find($id);
        if($servico === null){
            return response()->json(
                ['error' => 'Falha ao tentar deletar o registro. O recurso não foi encontrado.']
            , 404);
        }
        $servico->delete();
        return response()->json(['msg' => 'Registro eliminado com sucesso!'], 200);
    }
}
