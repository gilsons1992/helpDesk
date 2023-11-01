@extends('template-cad')

@section('sidebar-menu')
<nav class="mt-2">    
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/item.importarXML" class="nav-link">
                <img src="/img/Previous.png" width="40"/>
                <p>
                &nbsp;Voltar
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:executarImportacaoXML()" class="nav-link">
                <img src="/img/Save_02.png" width="40"/>
                <p>
                &nbsp;Importar
                </p>
            </a>
        </li>
    </ul>
</nav>
@endsection

@section('titulo-cadastro')
    Nota {{$ide['nNF']}}
@endsection

@section('main-content')
<form id="formImp" method="post" action="item.executarImportacaoXML">
@csrf

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dados do emitente</h3>
            </div>
            <div class="card-body .bg-light">
                <div class="container-fluid">
                    <div class="row">
                    <div class="col-md-6">
                        <label for="NomeFornecedor">Razão </label>
                            <input type="text" 
                                            name="NomeFornecedor" 
                                            class="form-control" 
                                            value="{{$emit['xNome']}}"
                                            readonly
                                            >
                        </div>
                        <div class="col-md-2">
                        <label for="CNPJFornecedor">CNPJ</label>
                            <input type="text" 
                                            name="CNPJFornecedor" 
                                            class="form-control" 
                                            value="{{$emit['CNPJ']}}"
                                            readonly
                                            >
                        </div>
                        <div class="col-md-2">
                        <label for="IEFornecedor">Inscrição estadual</label>
                            <input type="text" 
                                            name="IEFornecedor" 
                                            class="form-control" 
                                            value="{{$emit['IE']}}"
                                            readonly
                                            >
                        </div>
                        <div class="col-md-2">
                        <label for="FoneFornecedor">Fone</label>
                            <input type="text" 
                                            name="FoneFornecedor" 
                                            class="form-control" 
                                            value="{{isset($emit['enderEmit']['fone']) ? $emit['enderEmit']['fone'] : ''}}"
                                            readonly
                                            >
                        </div>
                        <input type="hidden" name="hdnChNFe" value="{{$chNFe}}" />                        
                        <input type="hidden" name="hdnLogradouroFornecedor" value="{{$emit['enderEmit']['xLgr']}}" />                        
                        <input type="hidden" name="hdnNumeroFornecedor" value="{{$emit['enderEmit']['nro']}}" />                        
                        <input type="hidden" name="hdnBairroFornecedor" value="{{$emit['enderEmit']['xBairro']}}" />                        
                        <input type="hidden" name="hdnNomeMunicipioFornecedor" value="{{$emit['enderEmit']['xMun']}}" />                        
                        <input type="hidden" name="hdnCodigoMunicipioFornecedor" value="{{$emit['enderEmit']['cMun']}}" />                        
                        <input type="hidden" name="hdnUFFornecedor" value="{{$emit['enderEmit']['UF']}}" />                        
                        <input type="hidden" name="hdnCEPFornecedor" value="{{$emit['enderEmit']['CEP']}}" />                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Relacionar os itens à categoria</h3>
            </div>
            <div class="card-body .bg-light">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="CategoriaId">Categoria</label>
                        <div class="input-group mb-3">
                            <select class="form-control col-12" id="CategoriaId" name="CategoriaId" >
                                @foreach($listaCategorias as $e)
                                <option value="{{$e->Id}}" {{($e->Id == 1) ? 'selected' : ''}}>{{$e->Descricao}}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <a class="form-control" href="javascript:alteraCategoria()"><img src="/img/Category24.png" /></a>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Calcular seu preço de venda</h3>
            </div>
            <div class="card-body .bg-light">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="Percentual">Percentual</label>
                        <div class="input-group mb-3">
                            <input type="text" 
                            class="form-control" 
                            id="percPrecoVenda" 
                            name="percPrecoVenda" 
                            onfocus="insertPercentMask(this)">
                            <div class="input-group-append">
                                <a class="form-control" href="javascript:aplicaPercentualPrecoVenda()"><img src="/img/Calculator24.png" /></a>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Itens da nota</h3>
            </div>
                <input type="hidden" id="qtItens" name="qtItens" value="{{$qtItens}}" />
            <!-- /.card-header -->
                @foreach($prod as $i => $item)
                <input type="hidden" id="hdnId{{$i}}" name="hdnId{{$i}}" value="{{$item['Id']}}">
                <div class="col-12">
                    <div id="div{{$i}}" class="card card-primary shadow">
                        <div class="card-body .bg-light">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6">
                                    <label for="Descricao{{$i}}">Descrição</label>
                                    <input type="text" 
                                            name="Descricao{{$i}}" 
                                            class="form-control" 
                                            id="Descricao{{$i}}" 
                                            maxlength="120" 
                                            value="{{$item['xProd']}}"
                                            original="{{$item['xProd']}}"
                                            >
                                    </div>
                                    <div class="col-md-2">
                                    <label for="CodigoBarras{{$i}}">Código de barras</label>
                                    <input type="text" 
                                            name="CodigoBarras{{$i}}" 
                                            class="form-control" 
                                            id="CodigoBarras{{$i}}" 
                                            value="{{$item['cEAN']}}"
                                            readonly
                                            >
                                    </div>
                                    <div class="col-md-2">
                                    <label for="CodigoNCM{{$i}}">NCM</label>
                                    <input type="text" 
                                            name="CodigoNCM{{$i}}" 
                                            class="form-control" 
                                            id="CodigoNCM{{$i}}" 
                                            maxlength="8" 
                                            original="{{$item['NCM']}}" 
                                            value="{{$item['NCM']}}"
                                            >                                    
                                    </div>
                                    <div class="col-md-2">
                                    <label for="CodigoCest{{$i}}">CEST</label>
                                    <input type="text" 
                                            name="CodigoCest{{$i}}" 
                                            class="form-control" 
                                            id="CodigoCest{{$i}}" 
                                            maxlength="7" 
                                            value="{{isset($item['CEST']) ? $item['CEST'] : '' }}"
                                            original="{{isset($item['CEST']) ? $item['CEST'] : '' }}"
                                            >
                                    </div>

                                    <div class="col-md-2">
                                    <label for="UnidadeImp{{$i}}">Unidade imp.</label>
                                    <input type="text" class="form-control" id="UnidadeImp{{$i}}" name="UnidadeImp{{$i}}" value="{{$item['uCom']}}" readonly>
                                    </div>
                                    <div class="col-md-2">
                                    <label for="PrecoCustoImp{{$i}}">Preço custo</label>
                                    <input type="text" class="form-control" id="PrecoCustoImp{{$i}}" name="PrecoCustoImp{{$i}}" value="{{number_format($item['vUnCom'], 2, ',', '.')}}" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="QuantidadeCompraImp{{$i}}">Quantidade</label>
                                        <input type="text" class="form-control" id="QuantidadeImp{{$i}}" name="QuantidadeImp{{$i}}" value="{{number_format($item['qCom'], 4, ',', '.')}}" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="Subtotal{{$i}}">Subtotal</label>
                                        <input type="text" class="form-control" id="Subtotal{{$i}}" name="Subtotal{{$i}}" value="{{number_format($item['vProd'], 2, ',', '.')}}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                    <label for="UnidadeComercialId{{$i}}">Sua unidade</label>
                                    <select class="form-control" id="UnidadeComercialId{{$i}}" name="UnidadeComercialId{{$i}}">
                                        @foreach($listaUnidades as $e)
                                            <option value="{{$e->Id}}" {{$e->Id == 1 ? 'selected' : ''}}>{{$e->Descricao}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="Quantidade{{$i}}">Qt. sua unidade</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="Quantidade{{$i}}" 
                                            name="Quantidade{{$i}}" 
                                            value="{{number_format($item['qtUnidade'], 4, ',', '.')}}"
                                            original="{{number_format($item['qtUnidade'], 4, ',', '.')}}"
                                            onblur="javascript:calculaPrecoPorUnidade('{{$i}}')"
                                            >
                                    </div>
                                    <div class="col-md-2">
                                    <label for="PrecoUnidade{{$i}}">Preço na sua unidade</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="PrecoUnidade{{$i}}" 
                                        name="PrecoUnidade{{$i}}" 
                                        value="{{number_format($item['precoUnidade'], 2, ',', '.')}}" 
                                        original="{{number_format($item['precoUnidade'], 2, ',', '.')}}" 
                                        readonly>
                                    </div>
                                    <div class="col-md-2">
                                    <label for="PrecoVenda{{$i}}">Seu preço venda</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="PrecoVenda{{$i}}" 
                                        name="PrecoVenda{{$i}}"                                         
                                        value="{{number_format($item['precoVenda'], 2, ',', '.')}}" 
                                        original="{{number_format($item['precoVenda'], 2, ',', '.')}}" 
                                        onfocus="insertPriceMask(this)">
                                    </div>
                                    <div class="col-md-3">
                                    <label for="CategoriaId{{$i}}">Categoria</label>
                                    <select class="form-control" id="CategoriaId{{$i}}" name="CategoriaId{{$i}}">
                                        @foreach($listaCategorias as $e)
                                            <option value="{{$e->Id}}" {{$e->Id == 1 ? 'selected' : ''}}>{{$e->Descricao}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="col-md-3">
                                    <label for="TributoId{{$i}}">Tributos</label>
                                    <select class="form-control" id="TributoId{{$i}}" name="TributoId{{$i}}">
                                        @foreach($listaTributos as $e)
                                            <option value="{{$e->Id}}" {{$e->Id == 1 ? 'selected' : ''}}>{{$e->Descricao}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="ControlaEstoque{{$i}}">Controla estoque</label>
                                        <div class="custom-control custom-switch">
                                                <input class="custom-control-input" id="ControlaEstoque{{$i}}" name="ControlaEstoque{{$i}}" type="checkbox" onchange="javascript:mostraControlaEstoque('{{$i}}');" checked>
                                                <label class="custom-control-label" for="ControlaEstoque{{$i}}" id="lblControlaEstoque{{$i}}">Sim</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <input type="hidden" id="i{{$i}}" value="{{$i}}">
                            <table width="100%">
                                <tr>
                                    <td>
                                        @if($item['Id'] > 0)
                                            <label style="color: blue;">Item já consta no sistema</label>
                                        @else
                                            <label style="color: yellow;">Item será incluído no sistema</label>
                                        @endif
                                    </td>
                                    <td align="center">
                                        <div class="custom-control custom-switch">
                                            <input class="custom-control-input" id="importa_{{$i}}" type="checkbox" checked>
                                            <label class="custom-control-label" for="importa_{{$i}}"></label>
                                        </div>
                                    </td>
                                    <td align="center">
                                        <a href="javascript:desfazAlteracoesImportacao({{$i}})"><img src="/img/Command Undo-WF.png" /></a>
                                    </td>
                                </tr>
                            </table>
                        </div>                
                    </div>
                    <!-- /.card -->
                </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
@endsection
<script>
    function desfazAlteracoesImportacao(i) {
        $('#Descricao' + i).val($('#Descricao' + i).attr('original'));
        $('#CodigoNCM' + i).val($('#CodigoNCM' + i).attr('original'));
        $('#CodigoCest' + i).val($('#CodigoCest' + i).attr('original'));
        $('#PrecoVenda' + i).val($('#PrecoVenda' + i).attr('original'));
        $('#PrecoUnidade' + i).val($('#PrecoUnidade' + i).attr('original'));
        $('#Quantidade' + i).val($('#Quantidade' + i).attr('original'));
    }

    function calculaPrecoPorUnidade(i) {
        
        var precoImportado = strToFloat($('#PrecoCustoImp' + i).val());
        var quantConversao = strToFloat($('#Quantidade' + i).val());
        var precoPorUnidade = precoImportado / quantConversao;
        var perc = $('#percPrecoVenda').val();
        var precoVenda = precoPorUnidade * (1 + perc / 100);
        
        $('#PrecoUnidade' + i).val(floatToStr(precoPorUnidade.toFixed(2)));
        if ($('#hdnId' + i).val() == 0){
            $('#PrecoVenda' + i).val(floatToStr(precoVenda.toFixed(2)));
        }
    }

    function executarImportacaoXML() {
        $.confirm({
            title: 'Atenção!',
            content: 'Clique em Sim para confirmar a importação dos itens',
            theme: 'dark',
            buttons: {
                Sim: function () {
                    $('#formImp').submit();
                },
                Não: function () {
                    
                }
            }
        });        
    }

    function aplicaPercentualPrecoVenda() {
        var perc = strToFloat($('#percPrecoVenda').val());
        if (Number.isNaN(perc)) {
            toast("Informe um percentual válido.");
            $('#percPrecoVenda').focus();
            return;
        }
        var qtItens = $('#qtItens').val();
        for (let i =0; i < qtItens; i++) {
            if ($('#hdnId' + i).val() != 0){
                continue;
            }
            var precoUnidade = strToFloat($('#PrecoUnidade' + i).val());
            if (isNaN(precoUnidade)) {
                return;
            }
            var precoVenda = precoUnidade * (1 + perc / 100);
            $('#PrecoVenda' + i).val(floatToStr(precoVenda.toFixed(2)));
        }                        
    }
    function alteraCategoria() {
        var qtItens = $('#qtItens').val();
        for (let i =0; i < qtItens; i++) {            
            idCategoria = $('#CategoriaId').val();                        
            $('#CategoriaId' + i).val(idCategoria);
        }                        

    }
    function mostraControlaEstoque(i) {
        var contEstoque = $('#ControlaEstoque' + i).is(":checked") ? 'Sim' : 'Não';

        $('#lblControlaEstoque' + i).text(contEstoque);
    }
</script>