<?php

namespace App\Http\Controllers;

use App\Models\ConfigBanco;
use GuzzleHttp\Psr7\Query;
use PSpell\Config;
use Illuminate\Http\Request;
use App\Models\DadosEmpresa;


class ConfigBancoController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function index($msg='')
    {          
        $listaDadosEmpresa = DadosEmpresa::has('configBanco')->orderBy('RazaoSocial')->get();
        
        return view('configBanco.index')->with([
            'msg' => $msg,
            'listaDadosEmpresa' => $listaDadosEmpresa
        ]);
    }
    
    public function retrieveAll(Request $request) 
    {
        
        $registrosPorPagina = 10;

        $pagina             = $request['pagina'] ? $request['pagina'] : 1;
        $primeiraPagina     = $request['primeiraPaginaPaginador'] ? $request['primeiraPaginaPaginador'] : 1;

        $query = ConfigBanco::query();
        $qtRegistros = $query->count();
        $qtPaginas = ceil($qtRegistros / $registrosPorPagina);
        $offset = ($pagina -1) * $registrosPorPagina;
        $lista = $query->skip($offset)->take($registrosPorPagina)->orderBy('servidor')->get();
        $primeiro = $offset + 1;
        $ultimo = min($pagina * $registrosPorPagina, $qtRegistros);

        return view('configBanco.listview')->with([
            'lista' => $lista,
            'qtRegistros' => $qtRegistros,
            'qtPaginas' => $qtPaginas,
            'offset' => $offset,
            'registrosPorPagina' => $registrosPorPagina,
            'pagina' => $pagina,
            'primeiraPaginaPaginador' => $primeiraPagina,
            'primeiro' => $primeiro,
            'ultimo' => $ultimo,
            'entity' => 'configbanco'
        ]);
    }

    public function load(Request $request) {
        $lista = ConfigBanco::orderBy('servidor')->get();
        $configs = [];
        foreach ($lista as $item) {
            $configs[] = [
                "value" => $item->Id,
                "servidor" => $item->servidor,
            ];
        }

        // Retornar o resultado no formato JSON
        return response()->json($configs);    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function create($msg = '')
    {
        $listaDadosEmpresa = DadosEmpresa::orderBy('RazaoSocial')->get();

        return view('configBanco.create')->with([
            'msg' => $msg,
            'listaDadosEmpresa' => $listaDadosEmpresa,
        ]);
    }

    public function store(Request $request)
    {
        // inclusão
        $obj = new ConfigBanco();        
        if ($request['Id']) {
            // alteração
            $obj = ConfigBanco::find($request['Id']);
        }
        $obj->Servidor = $request['Servidor'];
        $obj->Tipo = $request['Tipo'];
        $obj->Banco = $request['Banco'];
        $obj->Porta = $request['Porta'];
        $obj->Usuario = $request['Usuario'];
        $obj->Senha = $request['Senha'];
        $obj->DadosEmpresaId = $request['DadosEmpresaId'];
        $obj->TabelaItem = $request['TabelaItem'];
        $obj->CampoCodigoBarras = $request['CampoCodigoBarras'];
        $obj->CampoDescricao = $request['CampoDescricao'];
        $obj->CampoNCM = $request['CampoNCM'];
        $obj->CampoCEST = $request['CampoCEST'];
        $obj->CampoPreco = $request['CampoPreco'];
        $obj->CampoCusto = $request['CampoCusto'];
        $obj->CampoEstoque = $request['CampoEstoque'];
        $obj->CampoReservado = $request['CampoReservado'];
        $obj->Ordem = $request['Ordem'];

        $msg = 'Configuração salva com sucesso';
        try {
            $obj->save();
        }catch(\Exception $e) {
            $msg = 'Não foi possível ' . ($request['Id'] ? 'alterar' : 'incluir') . ' a configuração. ';
            session()->flashInput($request->input());
        }
        
        if ($request['Id']){
            return $this->edit($obj->Id, $msg);
        }
        return $this->create($msg);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, $msg = '')
    {
        $obj = ConfigBanco::find($id);
        $listaDadosEmpresa = DadosEmpresa::orderBy('RazaoSocial')->get();
        return view('configBanco.edit')->with([
            'msg' => $msg,
            'obj' => $obj,
            'listaDadosEmpresa' => $listaDadosEmpresa,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $obj = ConfigBanco::find($request['Id']);
        
        $msg = "Configuração {$obj->CampoDescricao} excluída.";
        $success = true;
        try {
            $obj->delete();
        }catch(\Exception $e) {
            $msg = 'Não foi possível excluir a configuração. ';
            $success = false;
            session()->flashInput($request->input());
        }
        return response()->json([
            'success' => $success,
            'msg' => $msg,
        ]);
    }
}
