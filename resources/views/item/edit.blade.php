@extends('template-cad')
@section('sidebar-menu')
<nav class="mt-2">
    
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/item.index" class="nav-link">
                <img src="/img/Previous.png" width="40"/>
                <p>
                &nbsp;Voltar
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:save();" class="nav-link">
                <img src="/img/Save_02.png" width="40"/>
                <p>
                &nbsp;Salvar
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:historicoPrecos();" class="nav-link">
                <img src="/img/History24.png" width="40"/>
                <p>
                &nbsp;Preços
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:deleteItem();" class="nav-link">
                <img src="/img/Delete_04.png" width="40"/>
                <p>
                &nbsp;Excluir
                </p>
            </a>
        </li>
    </ul>
</nav>
@endsection

@section('titulo-cadastro')
    Alteração de item
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">{{$obj->Descricao}} <small>[{{$obj->Id}}]</small></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="formCad" action="/item.store" method="post">
                    @csrf
                <input type="hidden" id="Id" name="Id" value="{{$obj->Id}}">
                <div class="card-body">                

                <div class="form-group">
                <label>Clique na imagem para alterar</label><br>
                    @if($obj->Imagem)
                        <img src="data:image/png;base64, {{$obj->Imagem}}" onclick="loadImage(this, 'Imagem')" width="200" height="250"/>
                    @else
                        <img src="/img/Image_01.png" onclick="loadImage(this, 'Imagem')" width="200" height="250"/>
                    @endif                    
                    <input type="hidden" id="Imagem" name="Imagem" value="data:image/png;base64, {{$obj->Imagem}}">
                </div>                
                <div class="form-group">
                    <label for="CodigoBarras">Código de barras</label>
                    <input type="text" 
                            name="CodigoBarras" 
                            class="form-control" 
                            id="CodigoBarras" 
                            maxlength="14" 
                            value="{{$obj->CodigoBarras}}"
                            readonly
                            >
                    </div>
                    <div class="form-group">
                    <label for="Descricao">Descrição</label>
                    <input type="text" 
                            name="Descricao" 
                            class="form-control" 
                            id="Descricao" 
                            maxlength="120" 
                            value="{{$obj->Descricao}}"
                            >
                    </div>

                    <div class="form-group">
                        <label for="CategoriaId">Categoria</label>
                        <select class="form-control col-12" id="CategoriaId" name="CategoriaId">
                            @foreach($listaCategorias as $e)
                            <option value="{{$e->Id}}" {{($e->Id == $obj->CategoriaId) ? 'selected' : ''}}>{{$e->Descricao}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                    <label for="UnidadeComercialId">Unidade</label>
                    <select class="form-control" id="UnidadeComercialId" name="UnidadeComercialId">
                        @foreach($listaUnidades as $e)
                        <option value="{{$e->Id}}" {{($e->Id == $obj->UnidadeComercialId) ? 'selected' : ''}}>{{$e->Descricao}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="CodigoNCM">NCM</label>
                    <input type="text" 
                            name="CodigoNCM" 
                            class="form-control" 
                            id="CodigoNCM" 
                            maxlength="8" 
                            value="{{$obj->CodigoNCM}}"
                            >
                    </div>
                    <div class="form-group">
                    <label for="CodigoCest">CEST</label>
                    <input type="text" 
                            name="CodigoCest" 
                            class="form-control" 
                            id="CodigoCest" 
                            maxlength="7" 
                            value="{{$obj->CodigoCest}}"
                            >
                    </div>
                    <div class="form-group">
                    <label for="TributoId">Tributos</label>
                    <select class="form-control" id="TributoId" name="TributoId">
                        @foreach($listaTributos as $e)
                        <option value="{{$e->Id}}" {{($e->Id == $obj->TributoId) ? 'selected' : ''}}>{{$e->Descricao}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="Disponivel">Disponível</label>
                    <input type="number" class="form-control" id="Disponivel" name="Disponivel" value="{{$obj->Disponivel}}">
                    </div>
                    <div class="form-group">
                    <label for="EstoqueMinimo">Estoque mínimo</label>
                    <input type="number" class="form-control" id="EstoqueMinimo" name="EstoqueMinimo" value="{{$obj->EstoqueMinimo}}">
                    </div>
                    <div class="form-group">
                    <label for="PrecoCusto">Preço custo</label>
                    <input type="text" class="form-control" id="PrecoCusto" name="PrecoCusto" value="{{$obj->PrecoCusto}}" onfocus="insertPriceMask(this);">
                    </div>
                    <div class="form-group">
                    <label for="PrecoVenda">Preço venda</label>
                    <input type="text" class="form-control" id="PrecoVenda" name="PrecoVenda" value="{{$obj->PrecoVenda}}" onfocus="insertPriceMask(this)">
                    </div>
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" id="ControlaEstoque" name="ControlaEstoque" {{$obj->ControlaEstoque ? 'checked' : ''}}>
                        <label class="custom-control-label" for="ControlaEstoque">Controla estoque</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" id="ProducaoPropria" name="ProducaoPropria" {{$obj->ProducaoPropria ? 'checked' : ''}}>
                        <label class="custom-control-label" for="ProducaoPropria">Produção própria</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" id="Combustivel" name="Combustivel" {{$obj->Combustivel ? 'checked' : ''}}>
                        <label class="custom-control-label" for="Combustivel">Combustível</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" id="Ativo" name="Ativo" {{$obj->Ativo ? 'checked' : ''}}>
                        <label class="custom-control-label" for="Ativo">Ativo</label>
                    </div>
                  </div>

                </div>
                </form>
            </div>
            <!-- /.card -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">

            </div>
            <!--/.col (right) -->
        </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection

<script>

function save() {    
    document.getElementById('formCad').submit();
}
function deleteItem() {

    $.confirm({
        title: 'Atenção!',
        content: 'Clique em Sim para confirmar a exclusão do item',
        theme: 'dark',
        buttons: {
            Sim: function () {
                var idItem = $('#Id').val();
                $.ajax({
                    method: "post",
                    url: 'item.delete',
                    data: {
                        _token: "{{ csrf_token() }}",
                        Id:idItem
                    },
                    success: function (data) {
                        toast(data.msg);
                        if (data.success) {
                            setTimeout(function(){ location.href = 'item.index'; }, 3000);            
                        }
                    }
                });    
            },
            Não: function () {
                
            }
        }
    });  
}

function historicoPrecos(id) {
    var idItem = $('#Id').val()
    $.ajax({
        method: "get",
        url: '/item.historicoPrecos.' + idItem,
        data: {},
        success: function (data) {
            var lista = data.lista;
            var qtd = lista.length;
            if (qtd > 0) {
                var html = '{{$obj->Descricao}}' +
                    '<table class="table" width="100%">' +
                    '<tr><th>Data/hora</th><th class="text-right">Preço anterior</th><th class="text-right">Preço novo</th></tr>';
                for (let i=0; i<qtd; i++) {
                    html = html + '<tr><td>' + 
                                   dma(lista[i].DataHora) +
                                  '</td><td class="text-right">' + 
                                  lista[i].PrecoAnterior + 
                                  '</td><td class="text-right">' + 
                                  lista[i].PrecoNovo + 
                                  '</td></tr>';
                }
                html = html + '</table>';
                $.dialog({
                    title: 'Histórico de alteração de preços',
                    theme:'dark',
                    boxWidth: '600px',
                    useBootstrap: false,
                    content: html                            
                });
            }
        }
    });
}
</script>