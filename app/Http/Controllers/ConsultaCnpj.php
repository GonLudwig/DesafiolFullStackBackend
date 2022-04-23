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
        
        $result = $result->json();

        $datas = array(
            strtotime($result['data_opcao_pelo_mei']),
            'data_opcao_pelo_mei',
            strtotime($result['data_exclusao_do_mei']),
            'data_exclusao_do_mei',
            strtotime($result['data_situacao_especial']),
            'data_situacao_especial',
            strtotime($result['data_opcao_pelo_simples']),
            'data_opcao_pelo_simples',
            strtotime($result['data_situacao_cadastral']),
            'data_situacao_cadastral',
            strtotime($result['data_exclusao_do_simples']),
            'data_exclusao_do_simples'
        );
        
        for ($i=0; $i <= 10; $i++) {
            $max = 0;
            if ($datas[$i] > $datas[$max]) {
                $max = $i;
            }
            $dataAtualizda = $datas[$max+1];
        }

        $result["data_ultima_atualizacao"] = $result[$dataAtualizda];

        return response()->json($result, 200);
    }
}
