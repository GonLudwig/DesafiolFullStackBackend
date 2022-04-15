<?php

namespace App\Http\Controllers;

use App\Http\Requests\CnpjRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Helper\CnpjHelper;

class ConsultaCnpj extends Controller
{
    public function index(CnpjRequest $request) {
        $cnpj = $request->cnpj;
        
        $validacao = CnpjHelper::validarCnpj($cnpj);

        if(!$validacao){
            return response()->json([
                "message" => "The given data was invalid.",
                "errors" => ["cnpj" => ["Este nao e um CNPJ valido!"]]
            ], 200);
        }

        $result = Http::get("https://brasilapi.com.br/api/cnpj/v1/$validacao");

        if(isset($result['type'])){
            if($result['type'] == 'not_found'){
                return response()->json([
                    "message" => "The given data was invalid.",
                    "errors" => ["cnpj" => ["CNPJ nao foi encontrado!"]]
                ], 200);
            }
    
            if($result['type'] == 'service_error'){
                return response()->json([
                    "message" => "The given data was invalid.",
                    "errors" => ["Servico esta indisponivel no momento"]
                ], 200);
            }
        }

        return response()->json($result->json(), 200);
    }
}
