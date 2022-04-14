<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConsultaCnpj extends Controller
{
    public function index(Request $request) {
        $dados = $request->cnpj;

        $response = Http::get("https://brasilapi.com.br/api/cnpj/v1/$dados");

        return response()->json($response->json(), 200);
    }
}
