<?php

namespace App\Http\Controllers;

use App\Models\Tributo;
use GuzzleHttp\Psr7\Query;
use PSpell\Config;
use Illuminate\Http\Request;


class TributoController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function index($msg='')
    {          
        
        return view('tributo.index')->with([
            'msg' => $msg,
        ]);
    }
    
    public function retrieveAll(Request $request) 
    {
        
        $registrosPorPagina = 10;

        $pagina             = $request['pagina'] ? $request['pagina'] : 1;
        $primeiraPagina     = $request['primeiraPaginaPaginador'] ? $request['primeiraPaginaPaginador'] : 1;

        $query = Tributo::query();
        $qtRegistros = $query->count();
        $qtPaginas = ceil($qtRegistros / $registrosPorPagina);
        $offset = ($pagina -1) * $registrosPorPagina;
        $lista = $query->skip($offset)->take($registrosPorPagina)->orderBy('descricao')->get();
        $primeiro = $offset + 1;
        $ultimo = min($pagina * $registrosPorPagina, $qtRegistros);

        return view('tributo.listview')->with([
            'lista' => $lista,
            'qtRegistros' => $qtRegistros,
            'qtPaginas' => $qtPaginas,
            'offset' => $offset,
            'registrosPorPagina' => $registrosPorPagina,
            'pagina' => $pagina,
            'primeiraPaginaPaginador' => $primeiraPagina,
            'primeiro' => $primeiro,
            'ultimo' => $ultimo,
            'entity' => 'tributo'
        ]);
    }

    public function load(Request $request) {
        $lista = Tributo::orderBy('codigo')->get();
        $tributos = [];
        foreach ($lista as $item) {
            $tributos[] = [
                "value" => $item->Id,
                "descricao" => $item->descricao,
            ];
        }

        // Retornar o resultado no formato JSON
        return response()->json($tributos);    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function create($msg = '')
    {

        return view('tributo.create')->with([
            'msg' => $msg,
        ]);
    }

    public function store(Request $request)
    {
        // inclusão
        $obj = new Tributo();        
        if ($request['Id']) {
            // alteração
            $obj = Tributo::find($request['Id']);
        }
        $obj->Descricao = $request['Descricao'];
        $obj->AliquotaICMSConsumidor = $request['AliquotaICMSConsumidor'];
        $obj->AliquotaICMSContribuinte = $request['AliquotaICMSContribuinte'];
        $obj->AliquotaICMSST = $request['AliquotaICMSST'];
        $obj->CSTContribuinte = $request['CSTContribuinte'];
        $obj->CSTConsumidor = $request['CSTConsumidor'];
        $obj->CSTSubstituicaoTributaria = $request['CSTSubstituicaoTributaria'];
        $obj->CSOSNConsumidor = $request['CSOSNConsumidor'];
        $obj->CSOSNContribuinte = $request['CSOSNContribuinte'];
        $obj->OrigemMercadoria = $request['OrigemMercadoria'];
        $obj->AliquotaPIS = $request['AliquotaPIS'];
        $obj->AliquotaCOFINS = $request['AliquotaCOFINS'];
        $obj->CSTPIS = $request['CSTPIS'];
        $obj->CSTCOFINS = $request['CSTCOFINS'];

        $msg = 'Tributo salvo com sucesso';
        try {
            $obj->save();
        }catch(\Exception $e) {
            //$msg = 'Não foi possível ' . ($request['Id'] ? 'alterar' : 'incluir') . ' o tributo. ';
            $msg = $obj;
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
        $obj = Tributo::find($id);
        return view('tributo.edit')->with([
            'msg' => $msg,
            'obj' => $obj,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $obj = Tributo::find($request['Id']);
        
        $msg = "{$obj->Descricao} excluído.";
        $success = true;
        try {
            $obj->delete();
        }catch(\Exception $e) {
            $msg = 'Não foi possível excluir o tributo. ';
            $success = false;
            session()->flashInput($request->input());
        }
        return response()->json([
            'success' => $success,
            'msg' => $msg,
        ]);
    }
}
