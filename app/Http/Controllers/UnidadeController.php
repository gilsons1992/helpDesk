<?php

namespace App\Http\Controllers;

use App\Models\UnidadeComercial;
use GuzzleHttp\Psr7\Query;
use PSpell\Config;
use Illuminate\Http\Request;


class UnidadeController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function index($msg='')
    {          
        
        return view('unidade.index')->with([
            'msg' => $msg,
        ]);
    }
    
    public function retrieveAll(Request $request) 
    {
        
        $registrosPorPagina = 10;

        $pagina             = $request['pagina'] ? $request['pagina'] : 1;
        $primeiraPagina     = $request['primeiraPaginaPaginador'] ? $request['primeiraPaginaPaginador'] : 1;

        $query = UnidadeComercial::query();
        $qtRegistros = $query->count();
        $qtPaginas = ceil($qtRegistros / $registrosPorPagina);
        $offset = ($pagina -1) * $registrosPorPagina;
        $lista = $query->skip($offset)->take($registrosPorPagina)->orderBy('codigo')->get();
        $primeiro = $offset + 1;
        $ultimo = min($pagina * $registrosPorPagina, $qtRegistros);

        return view('unidade.listview')->with([
            'lista' => $lista,
            'qtRegistros' => $qtRegistros,
            'qtPaginas' => $qtPaginas,
            'offset' => $offset,
            'registrosPorPagina' => $registrosPorPagina,
            'pagina' => $pagina,
            'primeiraPaginaPaginador' => $primeiraPagina,
            'primeiro' => $primeiro,
            'ultimo' => $ultimo,
            'entity' => 'unidadecomercial'
        ]);
    }

    public function load(Request $request) {
        $lista = UnidadeComercial::orderBy('codigo')->get();
        $unidades = [];
        foreach ($lista as $item) {
            $unidades[] = [
                "value" => $item->Id,
                "codigo" => $item->codigo,
            ];
        }

        // Retornar o resultado no formato JSON
        return response()->json($unidades);    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function create($msg = '')
    {

        return view('unidade.create')->with([
            'msg' => $msg,
        ]);
    }

    public function store(Request $request)
    {
        // inclusão
        $obj = new UnidadeComercial();        
        if ($request['Id']) {
            // alteração
            $obj = UnidadeComercial::find($request['Id']);
        }
        $obj->Codigo = $request['Codigo'];
        $obj->Descricao = $request['Descricao'];
        $obj->FatorConversao = $request['FatorConversao'];
        $obj->Pesagem = $request['Pesagem'];

        $msg = 'Unidade salva com sucesso';
        try {
            $obj->save();
        }catch(\Exception $e) {
            $msg = 'Não foi possível ' . ($request['Id'] ? 'alterar' : 'incluir') . ' a unidade. ';
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
        $obj = UnidadeComercial::find($id);
        return view('unidade.edit')->with([
            'msg' => $msg,
            'obj' => $obj,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $obj = UnidadeComercial::find($request['Id']);
        
        $msg = "{$obj->Descricao} excluída.";
        $success = true;
        try {
            $obj->delete();
        }catch(\Exception $e) {
            $msg = 'Não foi possível excluir a unidade. ';
            $success = false;
            session()->flashInput($request->input());
        }
        return response()->json([
            'success' => $success,
            'msg' => $msg,
        ]);
    }
}
