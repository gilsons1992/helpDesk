<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use GuzzleHttp\Psr7\Query;
use PSpell\Config;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function index($msg='')
    {          
        
        return view('usuario.index')->with([
            'msg' => $msg,
        ]);
    }
    
    public function retrieveAll(Request $request) 
    {
        
        $registrosPorPagina = 10;

        $pagina             = $request['pagina'] ? $request['pagina'] : 1;
        $primeiraPagina     = $request['primeiraPaginaPaginador'] ? $request['primeiraPaginaPaginador'] : 1;

        $query = Usuario::query();
        $qtRegistros = $query->count();
        $qtPaginas = ceil($qtRegistros / $registrosPorPagina);
        $offset = ($pagina -1) * $registrosPorPagina;
        $lista = $query->skip($offset)->take($registrosPorPagina)->orderBy('Nome')->get();
        $primeiro = $offset + 1;
        $ultimo = min($pagina * $registrosPorPagina, $qtRegistros);
        return view('usuario.listview')->with([
            'lista' => $lista,
            'qtRegistros' => $qtRegistros,
            'qtPaginas' => $qtPaginas,
            'offset' => $offset,
            'registrosPorPagina' => $registrosPorPagina,
            'pagina' => $pagina,
            'primeiraPaginaPaginador' => $primeiraPagina,
            'primeiro' => $primeiro,
            'ultimo' => $ultimo,
            'entity' => 'usuario'
        ]);
    }

    public function load(Request $request) {
        $lista = Usuario::orderBy('Nome')->get();
        $usuarios = [];
        foreach ($lista as $item) {
            $usuarios[] = [
                "value" => $item->Id,
                "text" => $item->Nome,
            ];
        }

        // Retornar o resultado no formato JSON
        return response()->json($usuarios);    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function create($msg = '')
    {

        return view('usuario.create')->with([
            'msg' => $msg
        ]);
    }

    public function store(Request $request)
    {
        // inclusão
        $obj = new Usuario();        
        if ($request['Id']) {
            // alteração
            $obj = Usuario::find($request['Id']);
        }
        $obj->Login = $request['Login'];
        $obj->Senha = $request['Senha'];
        $obj->Nome = $request['Nome'];
        $obj->Email = $request['Email'];
        $obj->Telefone = $request['Telefone'];
        $obj->Ativo = isset($request['Ativo']);
        $obj->Adm = isset($request['Adm']);

        $msg = 'Usuário salvo com sucesso';
        try {
            $obj->save();
        }catch(\Exception $e) {
            $msg = 'Não foi possível ' . ($request['Id'] ? 'alterar' : 'incluir') . ' o usuário. ';
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
        $obj = Usuario::find($id);
        return view('usuario.edit')->with([
            'msg' => $msg,
            'obj' => $obj,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $obj = Usuario::find($request['Id']);
        
        $msg = "Usuario {$obj->Descricao} excluído.";
        $success = true;
        try {
            $obj->delete();
        }catch(\Exception $e) {
            $msg = 'Não foi possível excluir o usuário. ';
            $success = false;
            session()->flashInput($request->input());
        }
        return response()->json([
            'success' => $success,
            'msg' => $msg,
        ]);
    }
}
