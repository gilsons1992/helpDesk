<?php

namespace App\Http\Controllers;

use App\Models\ClienteOs;
use GuzzleHttp\Psr7\Query;
use PSpell\Config;
use Illuminate\Http\Request;
use PDF;

class ClienteOsController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function index($msg='')
    {          
            return view('clientesOs.index')->with([
            'msg' => $msg,
        ]);
    }
    
    public function retrieveAll(Request $request) 
    {
        $registrosPorPagina = 10;

        $pagina             = $request['pagina'] ? $request['pagina'] : 1;
        $primeiraPagina     = $request['primeiraPaginaPaginador'] ? $request['primeiraPaginaPaginador'] : 1;
//        $numeroControle          = $request['id'];

        $query = ClienteOs::query();
        $qtRegistros = $query->count();
        $qtPaginas = ceil($qtRegistros / $registrosPorPagina);
        $offset = ($pagina -1) * $registrosPorPagina;
        $lista = $query->skip($offset)->take($registrosPorPagina);
        $primeiro = $offset + 1;
        $ultimo = min($pagina * $registrosPorPagina, $qtRegistros);
        return view('clientesOs.listview')->with([
            'lista' => $lista,
            'qtRegistros' => $qtRegistros,
            'qtPaginas' => $qtPaginas,
            'offset' => $offset,
            'registrosPorPagina' => $registrosPorPagina,
            'pagina' => $pagina,
            'primeiraPaginaPaginador' => $primeiraPagina,
            'primeiro' => $primeiro,
            'ultimo' => $ultimo,
            'entity' => 'ClienteOs'
        ]);
    }

    public function load(Request $request) {
        $lista = ClienteOs::orderBy('Prioridade')->get();
        $servicos = [];
        foreach ($lista as $item) {
            $servicos[] = [
                "value" => $item->Id,
                "text" => $item->Nome,
            ];
        }

        // Retornar o resultado no formato JSON
        return response()->json($servicos);    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function create($msg = '')
    {

        return view('clientesOs.create')->with([
            'msg' => $msg
        ]);
    }

    public function store(Request $request)
    {
        // inclusão
        $obj = new clienteOs();        
        if ($request['Id']) {
            // alteração
            $obj = ClienteOs::find($request['Id']);
        }
        $obj->Nome = $request['Nome'];
        $obj->Endereco = $request['Endereco'];
        $obj->Telefone = $request['Telefone'];
        $obj->Prioridade = $request['Prioridade'];
        $obj->Empresa = $request['Empresa'];
        $msg = 'Cliente salvo com sucesso';
        try {

            $obj->save();
        }catch(\Exception $e) {
            $msg = 'Não foi possível ' . ($request['Id'] ? 'alterar' : 'incluir') . ' o cliente. ';
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
        $obj = ClienteOs::find($id);
        return view('clientesOs.edit')->with([
            'msg' => $msg,
            'obj' => $obj,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $obj = ClienteOs::find($request['Id']);
        
        $msg = "OS {$obj->Id} excluído.";
        $success = true;
        try {
            $obj->delete();
        }catch(\Exception $e) {
            $msg = 'Não foi possível excluir o cliente. ';
            $success = false;
            session()->flashInput($request->input());
        }
        return response()->json([
            'success' => $success,
            'msg' => $msg,
        ]);
    }
}
