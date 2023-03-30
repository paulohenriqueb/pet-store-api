<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{

    public function __construct(Pet $pet){
        $this->pet = $pet;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pet = $this->pet->get();
        return response()->json($pet, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->pet->rules());
        $pet = $this->pet;
        $pet->create($request->all());
        return response()->json($pet, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($Id)
    {
        $pet = $this->pet->find($id);
        if($pet === null){
            return response()->json(['error' => 'Não foi encontrado registros na base de dados.'], 404);
        }
        return response()->json($pet, 200);
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

        $pet = $this->pet->find($id);

        if($pet === null){
            return response()->json(
                ['error'=>'Não foi possível efetuar a atualização. O registro Solicitado não existe na base de dados.'],
                404);
        }
        if($request->method() === 'PATCH'){
            $dinamicRules = array();
            foreach($this->pet->rules() as $rulesKey => $rule){
                if(array_key_exists($rulesKey, $request->all())){
                    $dinamicRules[$rulesKey] = $rule;
                }
            }
            $request->validate($dinamicRules);
        }else{
            $request->validate($pet->rules());
        }
        $pet->fill($request->all());
        $pet->save();
        return response()->json($pet, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pet = $this->pet->find($id);
        if($pet === null){
            return response()->json(['error'=>'Impossível realizar a exclusão. O recurso solicitado não existe!']);
        }
        $pet->delete();
        return response()->json(['msg'=>'O dado foi excluído com sucesso!']);
    }
}
