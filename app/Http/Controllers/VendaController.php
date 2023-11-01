<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Query;
use PSpell\Config;
use Illuminate\Http\Request;
use App\Models\DadosEmpresa;
use App\Models\Venda;
use App\Models\VendaDetalhe;
use App\Models\VendaPagamento;
use App\Models\FormaPagamento;
use App\Models\Item;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;



class VendaController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function index($msg='')
    {          
        $dadosEmpresaId = 1; // enquanto não tem login, está fixo
        $dadosEmpresa = DadosEmpresa::find($dadosEmpresaId);
        return view('venda.index')->with([
            'msg' => $msg,
            'dadosEmpresa' => $dadosEmpresa
        ]);
    }
    
    public function carrega(Request $request) {
        // TODO - usuário logado
        $usuarioId = 1; // enquanto não tem login, está fixo
        $dadosEmpresaId = 1; // enquanto não tem login, está fixo

        $itemSelecionado = null;
        if (session('idItemSelecionado')) {
            $itemSelecionado = Item::find(session('idItemSelecionado'));
            session()->forget('idItemSelecionado');
        } 
        $listaCategorias = Categoria::has('itens')->orderBy('Descricao')->get();
        $venda = Venda::where('UsuarioId', $usuarioId)
                ->where('Status', 'A')
                ->first();

        if(!$venda) {
            // não existe venda em aberto
            $venda = new Venda;
            $venda->UsuarioId = $usuarioId;
            $venda->DadosEmpresaId = $dadosEmpresaId;
            $venda->DataHoraCancelamento = '0001-01-01 00:00:00';
            $venda->save();
        }

        $listaItensVenda = VendaDetalhe::where('VendaId', $venda->Id)
                ->orderBy('Ordem')->get();
        $dados = [
            'listaCategorias'=>$listaCategorias,
            'listaItensVenda'=>$listaItensVenda,
            'itemSelecionado'=>$itemSelecionado,
            'venda'=>$venda,
        ];

        return view('venda.principal')->with($dados);
    }

    public function adicionaItemAoCupom(Request $request) {
        $qtdItens = VendaDetalhe::where('VendaId', $request['vendaId'])->count();
        $vendaDetalhe = new VendaDetalhe();
        $vendaDetalhe->VendaId = $request['vendaId'];
        $vendaDetalhe->ItemId = $request['itemId'];
        $vendaDetalhe->PrecoUnitario = $request['unitario'];
        $vendaDetalhe->Quantidade = $request['quantidade'];
        $vendaDetalhe->Subtotal = $request['subtotal'];
        $vendaDetalhe->Ordem = $qtdItens + 1;
        $vendaDetalhe->save();
        return response()->json([
            'success' => true,
        ]);
    }

    public function retornaItens($vendaId) {
        $listaItensVenda = VendaDetalhe::where('VendaId', $vendaId)
                ->orderBy('Ordem')->get();

        $total = 0;
        $ultimoItem = null;
        $idUltimoItem = null;
        $ultimoPreco = 0;
        $ultimoSubtotal = 0;
        $ultimaQuantidade = 1;
        foreach($listaItensVenda as $itemVenda) {
            if (!$itemVenda->Cancelado) {
                $total += $itemVenda->Subtotal;
            }
            $idUltimoItem = $itemVenda->ItemId;
            $ultimoPreco = $itemVenda->PrecoUnitario;
            $ultimoSubtotal = $itemVenda->Subtotal;
            $ultimaQuantidade = $itemVenda->Quantidade;
        }
        if($idUltimoItem) {
            $ultimoItem = Item::find($idUltimoItem);
        }
        return view('venda.itens_listview')->with([
            'total'=>$total,
            'listaItensVenda' => $listaItensVenda,
            'ultimoItem' => $ultimoItem,
            'ultimoPreco' => $ultimoPreco,
            'ultimoSubtotal' => $ultimoSubtotal,
            'ultimaQuantidade' => $ultimaQuantidade,
            ]);
    }

    public function pesquisaItem() {
        $listaCategorias = Categoria::has('itens')
                ->where('Ativo', true)
                ->orderBy('Descricao')->get();
        return view('venda.pesquisaItem')->with([
            'listaCategorias' => $listaCategorias
            ]);
    }

    public function executaPesquisaItem(Request $request) {
        $descricao = $request['descricao'];
        $categoria = $request['categoria'];
        $pesquisa = false;
        $query = Item::query();
        $query->where('Descricao', 'like', "%{$descricao}%");

        $lista = $query->take(100)
                    ->where('Ativo', true)
                    ->orderBy('Descricao')->get();

        return view('venda.pesquisa_listview')->with([
            'lista' => $lista,
            ]);
    }

    public function selecionaItem($id) {
        session()->put('idItemSelecionado', $id);
        return $this->index('');
    }

    public function cancelaItem() {
        // TODO - usuário logado
        $usuarioId = 1; // enquanto não tem login, está fixo
        $venda = Venda::where('UsuarioId', $usuarioId)
                ->where('Status', 'A')
                ->first();
        $listaItensVenda = VendaDetalhe::where('VendaId', $venda->Id)
                ->where('Cancelado', false)
                ->orderBy('Ordem')->get();
        if (count($listaItensVenda) == 0) {
            return $this->index('Não tem item para cancelar...');            
        }
        return view('venda.exclui_itens_listview')->with([
            'listaItensVenda' => $listaItensVenda,
            ]);        
    }

    public function executaCancelaItem(Request $request) {
        // TODO - usuário logado
        $usuarioId = 1; // enquanto não tem login, está fixo
        $vars = $request->all();
        foreach($vars as $var) {
            if (is_numeric($var)) {
                DB::select("call CancelarDetalheVendaPDV({$var},{$usuarioId})");
            }
        }
        return $this->index('');
    }

}
