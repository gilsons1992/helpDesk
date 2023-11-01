<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use GuzzleHttp\Psr7\Query;
use PSpell\Config;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function index($msg='')
    {          
        $filtroDescricao = Controller::getCookie($this, 'filtroDescricao');
        
        return view('categoria.index')->with([
            'msg' => $msg,
            'filtroDescricao' => $filtroDescricao
        ]);
    }
    
    public function retrieveAll(Request $request) 
    {
        
        $registrosPorPagina = 10;

        $pagina             = $request['pagina'] ? $request['pagina'] : 1;
        $primeiraPagina     = $request['primeiraPaginaPaginador'] ? $request['primeiraPaginaPaginador'] : 1;
        $descricao          = $request['descricao'];
        Controller::setCookie($this, 'filtroDescricao', $descricao);

        $query = Categoria::query();
        if ($descricao) {
            $query->where('Descricao', 'like', "%{$descricao}%");
        }
        $qtRegistros = $query->count();
        $qtPaginas = ceil($qtRegistros / $registrosPorPagina);
        $offset = ($pagina -1) * $registrosPorPagina;
        $lista = $query->skip($offset)->take($registrosPorPagina)->orderBy('Descricao')->get();
        $primeiro = $offset + 1;
        $ultimo = min($pagina * $registrosPorPagina, $qtRegistros);
        return view('categoria.listview')->with([
            'lista' => $lista,
            'qtRegistros' => $qtRegistros,
            'qtPaginas' => $qtPaginas,
            'offset' => $offset,
            'registrosPorPagina' => $registrosPorPagina,
            'pagina' => $pagina,
            'primeiraPaginaPaginador' => $primeiraPagina,
            'primeiro' => $primeiro,
            'ultimo' => $ultimo,
            'entity' => 'categoria'
        ]);
    }

    public function load(Request $request) {
        $lista = Categoria::orderBy('Descricao')->get();
        $categorias = [];
        foreach ($lista as $item) {
            $categorias[] = [
                "value" => $item->Id,
                "text" => $item->Descricao,
            ];
        }

        // Retornar o resultado no formato JSON
        return response()->json($categorias);    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function create($msg = '')
    {

        return view('categoria.create')->with([
            'msg' => $msg
        ]);
    }

    public function store(Request $request)
    {
        // inclusão
        $obj = new Categoria();        
        if ($request['Id']) {
            // alteração
            $obj = Categoria::find($request['Id']);
        }
        $obj->Descricao             = $request['Descricao'];

        $msg = 'Categoria salva com sucesso';
        try {
            $obj->save();
        }catch(\Exception $e) {
            $msg = 'Não foi possível ' . ($request['Id'] ? 'alterar' : 'incluir') . ' a categoria. ';
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
        $obj = Categoria::find($id);
        return view('categoria.edit')->with([
            'msg' => $msg,
            'obj' => $obj,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $obj = Categoria::find($request['Id']);
        
        $msg = "Categoria {$obj->Descricao} excluída.";
        $success = true;
        try {
            $obj->delete();
        }catch(\Exception $e) {
            $msg = 'Não foi possível excluir a categoria. ';
            $success = false;
            session()->flashInput($request->input());
        }
        return response()->json([
            'success' => $success,
            'msg' => $msg,
        ]);
    }
}
