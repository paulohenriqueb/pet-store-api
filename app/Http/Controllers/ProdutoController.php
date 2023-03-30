<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function __construct(Produto $produto){
        $this->produto = $produto;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produto = $this->produto->get();
        return response()->json($produto, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->produto->rules());
        $produto = $this->produto;
        $produto->create($request->all());
        return response()->json($produto, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = $this->produto->find($id);
        if($produto === null){
            return response()->json(['error' => 'Recurso não encontrado!'], 404);
        }
        return response()->json($produto, 200);
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
        $produto = $this->produto->find($id);
        if($produto === null){
            return response()->json(['error'=> 'Falha ao atualizar. O produto não foi encontrado.'], 404);
        }
        if($request->method() === 'PATCH'){
            $dinamicRules = array();
            foreach($produto->rules() as $key => $rule){
                if(array_key_exists($key, $request->all())){
                    $dinamicRules[$key] = $rule;
                }
            }
            $request->validate($dinamicRules);
        }else{
            $request->validate($produto->rules());
        }
        $produto->fill($request->all());
        $produto->save();
        return response()->json($produto, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = $this->produto->find($id);
        if($produto === null){
            return response()->json(['error' => 'Falha ao tentar deletar o artigo. Produto não encontrado'], 404);
        }
        $produto->delete();
        return response()->json(['msg' => 'Produto deletado com sucesso!']);
    }
}
