<?php

namespace App\Http\Controllers;

use App\Models\OrdemServico;
use GuzzleHttp\Psr7\Query;
use PSpell\Config;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use App\Models\ClienteOs;

class OrdemServicoController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function index($msg='')
    {          
        
        $filtroNumeroControle = Controller::getCookie($this, 'filtroNumeroControle');
        return view('ordemServico.index')->with([
            'filtroNumeroControle' => $filtroNumeroControle,
            'msg' => $msg,
        ]);
    }
    
    public function retrieveAll(Request $request) 
    {
        
        $registrosPorPagina = 10;

        $pagina             = $request['pagina'] ? $request['pagina'] : 1;
        $primeiraPagina     = $request['primeiraPaginaPaginador'] ? $request['primeiraPaginaPaginador'] : 1;
        $numeroControle          = $request['id'];
        Controller::setCookie($this, 'filtroNumeroControle', $numeroControle);

        $query = OrdemServico::query();
        if ($numeroControle) {
            $query->where('Id', 'like', "%{$numeroControle}%");
        }

        $qtRegistros = $query->count();
        $qtPaginas = ceil($qtRegistros / $registrosPorPagina);
        $offset = ($pagina -1) * $registrosPorPagina;
        $lista = $query->skip($offset)->take($registrosPorPagina)->orderBy('Prioridade')->get();
        $primeiro = $offset + 1;
        $ultimo = min($pagina * $registrosPorPagina, $qtRegistros);
        return view('ordemServico.listview')->with([
            
            'lista' => $lista,
            'qtRegistros' => $qtRegistros,
            'qtPaginas' => $qtPaginas,
            'offset' => $offset,
            'registrosPorPagina' => $registrosPorPagina,
            'pagina' => $pagina,
            'primeiraPaginaPaginador' => $primeiraPagina,
            'primeiro' => $primeiro,
            'ultimo' => $ultimo,
            'entity' => 'OrdemServico'
        ]);
    }

    public function load(Request $request) {
        $lista = OrdemServico::orderBy('Prioridade')->get();
        $servicos = [];
        foreach ($lista as $item) {
            $servicos[] = [
                "value" => $item->Id,
                "text" => $item->Cliente,
            ];
        }

        // Retornar o resultado no formato JSON
        return response()->json($servicos);    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function create($msg = '')
    {
        $listaClienteOs = ClienteOs::orderBy('Nome')->get();
        return view('ordemServico.create')->with([
            'msg' => $msg,
            'listaClienteOs' => $listaClienteOs
        ]);
    }

    public function store(Request $request)
    {
        // inclusão
        $obj = new OrdemServico();        
        if ($request['Id']) {
            // alteração
            $obj = OrdemServico::find($request['Id']);
        }
        $obj->Cliente = $request['Cliente'];
        $obj->Status = $request['Status'];
        $obj->Telefone = $request['Telefone'];
        $obj->Prioridade = $request['Prioridade'];
        $obj->TaxaServico = Controller::zeroMoeda($request['TaxaServico']);
        $obj->Motivo = $request['Motivo'];
        $obj->Diagnostico = $request['Diagnostico'];
        $obj->Procedimento = $request['Procedimento'];
        $obj->Observacao = $request['Observacao'];
        $msg = 'OS salva com sucesso';
        try {
            $obj->save();
        }catch(\Exception $e) {
            $msg = 'Não foi possível ' . ($request['Id'] ? 'alterar' : 'incluir') . ' a OS. ';
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
        $obj = OrdemServico::find($id);
        return view('ordemServico.edit')->with([
            'msg' => $msg,
            'obj' => $obj,
        ]);
    }

    public function gerarPdf(string $id, $msg = '')
    {
        $path = base_path('public\img\Comtudologo.jpeg');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $pic = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $obj = OrdemServico::find($id);
        $data = [
            'obj'=> $obj,

        ];
        // Create an instance of DOMPDF
        $pdf = new DomPdf($obj);

        
        // Load HTML content that you want to convert to a PDF
        $html = view('ordemServico.pdf')->with([
            'obj'=>$obj,
            'pic'=>$pic,
        ])->render();
            
        // Load HTML content
        $pdf->loadHtml($html);

        // Render PDF (optional: save the PDF to a file)
        $pdf->render();

        // Display the PDF in the browser
        return $pdf->stream('ordemServico.pdf')->with([
            'obj'=> $obj,
        ]);
    }    
    
    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $obj = OrdemServico::find($request['Id']);
        
        $msg = "OS {$obj->Id} excluído.";
        $success = true;
        try {
            $obj->delete();
        }catch(\Exception $e) {
            $msg = 'Não foi possível excluir a OS. ';
            $success = false;
            session()->flashInput($request->input());
        }
        return response()->json([
            'success' => $success,
            'msg' => $msg,
        ]);
    }

    public function pesquisaCliente($clienteOsId) {
        $obj = ClienteOs::where('Id', $clienteOsId)->first();
        return response()->json([
            'success' => true,
            'msg' => 'Cliente localizado',
            'obj' => $obj,
        ]);        
    }

}
