<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\UnidadeComercial;
use App\Models\Tributo;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Cidade;
use App\Models\Bairro;
use App\Models\Estado;
use App\Models\Entrada;
use App\Models\EntradaItem;
use App\Models\MovimentoItem;
use App\Models\ReajustePrecos;
use App\Models\Cep;
use App\Models\ConfigBanco;
use App\Models\DadosEmpresa;
use App\Models\Fornecedor;
use GuzzleHttp\Psr7\Query;
use PSpell\Config;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($msg = '')
    {        
        $filtroCategoria = Controller::getCookie($this, 'filtroCategoria');
        $filtroDescricao = Controller::getCookie($this, 'filtroDescricao');
        $filtroCodigoBarras = Controller::getCookie($this, 'filtroCodigoBarras');
        $filtroAtivo = Controller::getCookie($this, 'filtroAtivo');
        $filtroInativo = Controller::getCookie($this, 'filtroInativo');

        $listaCategorias = Categoria::has('itens')->orderBy('Descricao')->get();

        return view('item.index')->with([
            'msg' => $msg,
            'filtroAtivo' => $filtroAtivo,
            'filtroInativo' => $filtroInativo,
            'filtroCategoria' => $filtroCategoria,
            'filtroDescricao' => $filtroDescricao,
            'filtroCodigoBarras' => $filtroCodigoBarras,
            'listaCategorias' => $listaCategorias
        ]);
    }
    
    public function retrieveAll(Request $request) 
    {
        
        $registrosPorPagina = 10;

        $pagina             = $request['pagina'] ? $request['pagina'] : 1;
        $primeiraPagina     = $request['primeiraPaginaPaginador'] ? $request['primeiraPaginaPaginador'] : 1;
        $categoria          = $request['categoria'];
        $descricao          = $request['descricao'];
        $codigoBarras       = $request['codigoBarras'];
        $ativos             = $request['ativos'];
        $inativos           = $request['inativos'];
        Controller::setCookie($this, 'filtroDescricao', $descricao);
        Controller::setCookie($this, 'filtroCategoria', $categoria);
        Controller::setCookie($this, 'filtroCodigoBarras', $codigoBarras);
        Controller::setCookie($this, 'filtroAtivo', $ativos);
        Controller::setCookie($this, 'filtroInativo', $inativos);        

        $query = Item::query();
        if ($ativos != $inativos){
            if ($ativos == 'S') {
                $query->where('Ativo', 1);
            }else{
                $query->where('Ativo', 0);
            }
        }
        if ($categoria) {
            $query->where('CategoriaId', $categoria);
        }
        if ($descricao) {
            $query->where('Descricao', 'like', "%{$descricao}%");
        }
        if ($codigoBarras) {
            $query->where('CodigoBarras', 'like', "%{$codigoBarras}%");
        }
        $qtRegistros = $query->count();
        $qtPaginas = ceil($qtRegistros / $registrosPorPagina);
        $offset = ($pagina -1) * $registrosPorPagina;
        $lista = $query->skip($offset)->take($registrosPorPagina)->orderBy('Descricao')->get();
        $primeiro = $offset + 1;
        $ultimo = min($pagina * $registrosPorPagina, $qtRegistros);
        return view('item.listview')->with([
            'lista' => $lista,
            'qtRegistros' => $qtRegistros,
            'qtPaginas' => $qtPaginas,
            'offset' => $offset,
            'registrosPorPagina' => $registrosPorPagina,
            'pagina' => $pagina,
            'primeiraPaginaPaginador' => $primeiraPagina,
            'primeiro' => $primeiro,
            'ultimo' => $ultimo,
            'entity' => 'item'
        ]);
    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function create($msg = '')
    {
        $listaCategorias = Categoria::orderBy('Descricao')->get();
        $listaUnidades = UnidadeComercial::orderBy('Descricao')->get();
        $listaTributos = Tributo::orderBy('Descricao')->get();

        return view('item.create')->with([
            'msg' => $msg,
            'listaCategorias' => $listaCategorias,
            'listaUnidades' => $listaUnidades,
            'listaTributos' => $listaTributos,
        ]);
    }

    public function store(Request $request)
    {
        // inclusão
        $obj = new Item;        
        if ($request['Id']) {
            // alteração
            $obj = Item::find($request['Id']);
        }
        $obj->Descricao             = $request['Descricao'];
        $obj->CodigoBarras          = $request['CodigoBarras'];
        $obj->CodigoNCM             = $request['CodigoNCM'];
        $obj->Disponivel            = Controller::zero($request['Disponivel']);
        $obj->Imagem = '';
        if ($request['Imagem']) {
            $obj->Imagem            = substr($request['Imagem'],strpos($request['Imagem'],",")+1);
        }
        
        $obj->UnidadeComercialId    = $request['UnidadeComercialId'];
        $obj->CodigoCest            = $request['CodigoCest'];
        $obj->CategoriaId           = $request['CategoriaId'];
        $obj->PrecoCusto            = Controller::zeroMoeda($request['PrecoCusto']);
        $obj->PrecoVenda            = Controller::zeroMoeda($request['PrecoVenda']);
        $obj->Reservado             = Controller::zero($request['Reservado']);
        $obj->EstoqueMinimo         = Controller::zero($request['EstoqueMinimo']);
        $obj->TributoId             = $request['TributoId'];
        $obj->Ativo                 = isset($request['Ativo']);
        $obj->ControlaEstoque       = isset($request['ControlaEstoque']);
        $obj->Combustivel           = isset($request['Combustivel']);
        $obj->ProducaoPropria       = isset($request['ProducaoPropria']);

        $msg = 'Item salvo com sucesso';
        try {
            $obj->save();
        }catch(\Exception $e) {
            $msg = 'Não foi possível ' . ($request['Id'] ? 'alterar' : 'incluir') . ' o item. ';
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
        $obj = Item::find($id);
        $listaCategorias = Categoria::orderBy('Descricao')->get();
        $listaUnidades = UnidadeComercial::orderBy('Descricao')->get();
        $listaTributos = Tributo::orderBy('Descricao')->get();
        return view('item.edit')->with([
            'msg' => $msg,
            'obj' => $obj,
            'listaCategorias' => $listaCategorias,
            'listaUnidades' => $listaUnidades,
            'listaTributos' => $listaTributos,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $obj = Item::find($request['Id']);
        $msg = "Item {$obj->Descricao} excluído.";
        $success = true;
        try {
            $obj->delete();
        }catch(\Exception $e) {
            $msg = 'Não foi possível excluir o item. ';
            $success = false;
            session()->flashInput($request->input());
        }
        return response()->json([
            'success' => $success,
            'msg' => $msg,
        ]);
    }

    public function pesquisaPorCodigoBarras($codigoBarras) {
        $dadosEmpresaId = 1; // enquanto não tem o login, está fixo
        $dadosEmpresa = DadosEmpresa::find($dadosEmpresaId);
        $obj = Item::where('CodigoBarras', $codigoBarras)->first();
        if (!$obj) {
            // Item não localizado - pesquisar na(s)
            // base(s) alternativa(s)
            $listaBancos = ConfigBanco::where('DadosEmpresaId', $dadosEmpresaId)
                    ->orderBy('Ordem')->get();
            foreach($listaBancos as $banco) {
                if ($banco->Tipo == 'P') {
                    $dynamicConfig = [
                        'driver' => 'pgsql',
                        'host' => $banco->Servidor,
                        'port' => $banco->Porta,
                        'database' => $banco->Banco,
                        'username' => $banco->Usuario,
                        'password' => $banco->Senha,
                        'charset' => 'utf8',
                        'prefix' => '',
                        'schema' => 'public',
                        'sslmode' => 'prefer',
                    ];
                    
                    // Criação da conexão PDO
                    try {
                        $dsn = sprintf(
                            'pgsql:host=%s;port=%s;dbname=%s;sslmode=%s',
                            $dynamicConfig['host'],
                            $dynamicConfig['port'],
                            $dynamicConfig['database'],
                            $dynamicConfig['sslmode']
                        );
                    
                        $pdo = new \PDO(
                            $dsn,
                            $dynamicConfig['username'],
                            $dynamicConfig['password']
                        );
                    
                        // Configurações adicionais do PDO
                        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
                        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                    
                        // Executando uma consulta
                        $sql = "
                        SELECT  
                            {$banco->CampoCodigoBarras},
                            {$banco->CampoCEST},
                            {$banco->CampoCusto},
                            {$banco->CampoDescricao},
                            {$banco->CampoEstoque},
                            {$banco->CampoNCM},
                            {$banco->CampoPreco},
                            {$banco->CampoReservado}
                        FROM 
                            {$banco->TabelaItem}
                        WHERE
                            {$banco->CampoCodigoBarras} = '{$codigoBarras}'";

                        $stmt = $pdo->query($sql);
                        $result = $stmt->fetchAll();
                        $obj = new Item;
                        $obj->CodigoCest = $result[0][$banco->CampoCEST];
                        $obj->CodigoBarras = $result[0][$banco->CampoCodigoBarras];
                        $obj->CodigoNCM = $result[0][$banco->CampoNCM];
                        $obj->Descricao = $result[0][$banco->CampoDescricao];
                        $obj->Disponivel = $result[0][$banco->CampoEstoque];
                        $obj->Reservado = $result[0][$banco->CampoReservado];
                        $obj->PrecoVenda = $result[0][$banco->CampoPreco];
                        $obj->PrecoCusto = $result[0][$banco->CampoCusto];
                        $obj->CategoriaId = $dadosEmpresa->CategoriaPadraoId;
                        $obj->TributoId = $dadosEmpresa->TributoPadraoId;
                        $obj->UnidadeComercialId = $dadosEmpresa->UnidadeComercialPadraoId;
                        $obj->ConfigBancoId = $banco->Id;
                        $obj->save();
                        return response()->json([
                            'success' => true,
                            'msg' => 'Item localizado',
                            'obj' => $obj,
                        ]);        
                        
                    } catch (\PDOException $e) {
                        return response()->json([
                            'success' => false,
                            'msg' => 'Erro ao conectar ao banco '.$banco->Banco,
                            'err'=>$e,
                            'sql'=>$sql,                            
                            'obj' => $obj
                        ]);        
                    }                    
                }
            }
        }
        return response()->json([
            'success' => true,
            'msg' => 'Item localizado',
            'obj' => $obj,
        ]);        
    }

    public function importarXML($msg = '') {
        return view('item.import_xml')->with(['msg' => $msg]);
    }

    public function processarXML(Request $request) {                
        if ($request->hasFile('xmlFile')) {
            $xmlFile = $request->file('xmlFile');

            // Verifique se o arquivo é um XML válido antes de continuar
            if ($xmlFile->isValid() && $xmlFile->getClientOriginalExtension() === 'xml') {
                // Ler o conteúdo do arquivo XML
                $xmlContent = file_get_contents($xmlFile);

                // Converter o XML para um objeto PHP
                $xmlObject = simplexml_load_string($xmlContent);

                // Converta o objeto SimpleXMLElement em um array associativo
                $xmlArray = json_decode(json_encode($xmlObject), true);
                $ide = $xmlArray['NFe']['infNFe']['ide'];
                $emit = $xmlArray['NFe']['infNFe']['emit'];
                $det = $xmlArray['NFe']['infNFe']['det'];
                $chNFe = $xmlArray['protNFe']['infProt']['chNFe'];
                /*
                $dest = $xmlArray['NFe']['infNFe']['dest'];
                $pag = $xmlArray['NFe']['infNFe']['pag'];
                */

                // Verifica se o arquivo já foi processado
                $entrada = Entrada::where('ChaveNFe', $chNFe)->first();
                if ($entrada) {
                    return $this->importarXML('Esta nota já foi importada');
                }

                $prod = [];
                if (isset($det['prod'])) {
                    // apenas um item
                    $codigoBarras = $det['prod']['cEAN'];
                    $item = Item::where('CodigoBarras', $codigoBarras)->first();
                    $det['prod']['Id'] = $item != null ? $item->Id : 0;
                    $qtUnidade = (int) filter_var($det['prod']['uCom'], FILTER_SANITIZE_NUMBER_INT);
                    $det['prod']['qtUnidade'] = $qtUnidade == 0 ? 1 : $qtUnidade;
                    $det['prod']['precoUnidade'] = $det['prod']['vUnCom']/ $det['prod']['qtUnidade'];
                    $det['prod']['precoVenda'] = $item != null ? $item->PrecoVenda : $det['prod']['vUnCom'];
                    $prod[] = $det['prod'];                    
                }else{
                    for($i = 0; $i < sizeof($det); $i++) {
                        $codigoBarras = $det[$i]['prod']['cEAN'];
                        $item = Item::where('CodigoBarras', $codigoBarras)->first();
                        $det[$i]['prod']['Id'] = $item != null ? $item->Id : 0;
                        $qtUnidade = (int) filter_var($det[$i]['prod']['uCom'], FILTER_SANITIZE_NUMBER_INT);
                        $det[$i]['prod']['qtUnidade'] = $qtUnidade == 0 ? 1 : $qtUnidade;
                        $det[$i]['prod']['precoUnidade'] = $det[$i]['prod']['vUnCom']/ $det[$i]['prod']['qtUnidade'];
                        $det[$i]['prod']['precoVenda'] = $item != null ? $item->PrecoVenda : $det[$i]['prod']['vUnCom'];
                        $prod[] = $det[$i]['prod'];
                    }
                }

                $listaUnidades = UnidadeComercial::orderBy('Descricao')->get();
                $listaCategorias = Categoria::orderBy('Descricao')->get();
                $listaTributos = Tributo::orderBy('Descricao')->get();
                $dados = [
                    'ide'=>$ide,
                    'emit'=>$emit,
                    'prod'=>$prod,
                    'chNFe'=>$chNFe,
//                    'dest'=>$dest,
//                    'pag'=>$pag,
                    'listaUnidades'=>$listaUnidades,
                    'listaCategorias'=>$listaCategorias,
                    'listaTributos'=>$listaTributos,
                    'qtItens'=>sizeof($prod),
                ];
                

                // Retorne a view "xml_result" passando o array associativo como parâmetro
                return view('item.xml_listview')->with($dados);
            }
        }

        return $this->importarXML('Arquivo inválido');
    }

    function executarImportacaoXML(Request $request) {
        $qtItens = $request['qtItens'];
        //$percPrecoVenda = $request['percPrecoVenda'];
//        Controller::x($request->all());
        // Verifica se a cidade existe no banco
        $codCidade = $request['hdnCodigoMunicipioFornecedor'];
        $cidade = Cidade::where('CodigoIBGE', $codCidade)->first();
        if (!$cidade) {
            // Incluir a cidade
            $cidade = new Cidade();
            $estado = Estado::where('Sigla', $request['hdnUFFornecedor'])->first();
            $cidade = new Cidade();
            $cidade->EstadoId = $estado->Id;
            $cidade->Nome = $request['hdnNomeMunicipioFornecedor'];
            $cidade->CodigoIBGE = $codCidade;
            $cidade->save();            
        }

        // Verifica o CEP
        $cep = Cep::where('Codigo', $request['hdnCEPFornecedor'])->first();
        if (!$cep) {
            // Verifica se o bairro está cadastrado
            $bairro = Bairro::where('CidadeId', $cidade->Id)
                            ->where('Nome', $request['hdnBairroFornecedor'])->first();
            if(!$bairro) {
                // Incluir bairro
                $bairro = new Bairro();
                $bairro->CidadeId = $cidade->Id;
                $bairro->Nome = $request['hdnBairroFornecedor'];                
                $bairro->save();
            }
            $cep = new Cep;
            $cep->Codigo = $request['hdnCEPFornecedor'];
            $cep->Logradouro = $request['hdnLogradouroFornecedor'];
            $cep->BairroId = $bairro->Id;
            $cep->save();
        }

        // Verifica se o fornecedor está cadastrado
        $fornecedor = Fornecedor::where('CnpjCpf', $request['CNPJFornecedor'])->first();
        if(!$fornecedor) {
            $fornecedor = new Fornecedor();
            $fornecedor->CnpjCpf = $request['CNPJFornecedor'];
            $fornecedor->InscricaoEstadual = $request['IE'];
            $fornecedor->Nome = $request['NomeFornecedor'];
            $fornecedor->CepId = $cep->Id;
            $fornecedor->Numero = $request['hdnNumeroFornecedor'];
            $fornecedor->Telefone = $request['FoneFornecedor'];
            $fornecedor->save();
        }

        // Inclui entrada
        $entrada = new Entrada;
        $entrada->ChaveNFe = $request['hdnChNFe'];
        $entrada->FornecedorId = $fornecedor->Id;
        $entrada->save();

        for($i = 0; $i < $qtItens; $i++) {
            $quantidade = Controller::zero($request['Quantidade'.$i]);
            $idItem = $request['hdnId'.$i];

            $estoqueAnterior = 0;
            $custoAnterior = 0;
            $item = new Item;
            if ($idItem > 0) {
                $item = Item::find($idItem);
                $estoqueAnterior = $item->Disponivel;
                $custoAnterior = $item->PrecoCusto;
            }else{
                $item->CodigoBarras = $request['CodigoBarras'.$i];
            }
            
            $item->Descricao = $request['Descricao'.$i];
            $item->CodigoNCM = $request['CodigoNCM'.$i];
            $item->CodigoCest = $request['CodigoCest'.$i];
            $item->UnidadeComercialId = $request['UnidadeComercialId'.$i];
            $item->CategoriaId = $request['CategoriaId'.$i];
            $item->TributoId = $request['TributoId'.$i];
            $item->PrecoCusto = Controller::zeroMoeda($request['PrecoUnidade'.$i]);
            $item->PrecoVenda = Controller::zeroMoeda($request['PrecoVenda'.$i]); 
            $item->ControlaEstoque = isset($request['ControlaEstoque'.$i]);                
            $item->Disponivel = $quantidade + $estoqueAnterior;
            $item->save();
            $precoCustoImp = Controller::zeroMoeda($request['PrecoCustoImp'.$i]);

            $entradaItem = new EntradaItem();
            $entradaItem->EntradaId = $entrada->Id;
            $entradaItem->Quantidade = $quantidade;
            $entradaItem->ItemId = $item->Id;
            $entradaItem->Custo = $precoCustoImp / $quantidade;
            $entradaItem->Subtotal = Controller::zeroMoeda($request['Subtotal'.$i]);
            $entradaItem->Save();

            $movimentoItem = new MovimentoItem();
            $movimentoItem->ItemId = $item->Id;
            $movimentoItem->Quantidade = $quantidade;
            $movimentoItem->SaldoAnterior = $estoqueAnterior;
            $movimentoItem->Saldo = $quantidade + $estoqueAnterior;
            $movimentoItem->Tipo = "E";
            $movimentoItem->CustoAnterior = $custoAnterior;
            $movimentoItem->NovoCusto = $item->PrecoCusto;
            $movimentoItem->Save();

        }
        return $this->importarXML('Importação executada com sucesso');
    }

    public function saveAjax(Request $request)
    {
        // alteração
        $obj = Item::find($request['Id']);
        
        $obj->PrecoVenda            = Controller::zeroMoeda($request['PrecoVenda']);
        $obj->CodigoNCM             = $request['CodigoNCM'];
        $obj->CodigoCest            = $request['CodigoCest'];

        $msg = 'Item salvo com sucesso';
        try {
            $obj->save();
        }catch(\Exception $e) {
            $msg = 'Não foi possível ' . ($request['Id'] ? 'alterar' : 'incluir') . ' o item. ';
            session()->flashInput($request->input());
        }
        
        return response()->json([
            'success' => true,
            'msg' => $msg,
        ]);
    }

    public function historicoPrecos($id) {
        $lista = ReajustePrecos::where('ItemId', $id)
                        ->orderBy('DataHora', 'DESC')->get();
        return response()->json([
            'success' => true,
            'lista' => $lista,
        ]);
    }

}

