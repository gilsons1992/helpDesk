@extends('template-cad')

@section('sidebar-menu')
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/" class="nav-link">
                <img src="/img/Previous.png" width="40"/>
                <p>
                &nbsp;Voltar
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/item.create" class="nav-link">
                <img src="/img/Plus_01.png" width="40"/>
                <p>
                &nbsp;Incluir
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/item.importarXML" class="nav-link">
                <img src="/img/Document-Download-01.png" width="40"/>
                <p>
                &nbsp;Importar XML
                </p>
            </a>
        </li>
        <div id="div-filtro">
            <li id="div-filtro" class="nav-item">            
                    <button class="btn btn-primary btn-block" 
                        type="button"                     
                        data-toggle="collapse" 
                        data-target="#div-filtro-det">
                    Filtrar
                    </button>
            </li>
            <div class="collapse" id="div-filtro-det">
                <li class="nav-item">            
                    <label for="filtroCategoria">Categoria</label><br>
                    <select class="form-control" id="filtroCategoria" name="filtroCategoria" onchange="loadRecords('item');">
                        <option value="">Todas</option>
                        @foreach($listaCategorias as $e)
                            <option value="{{$e->Id}}" {{($e->Id == $filtroCategoria) ? 'selected' : ''}}>{{$e->Descricao}}</option>
                        @endforeach
                    </select>
                </li>
                <li class="nav-item">            
                    <label for="filtroDescricao">Descrição</label><br>
                    <div class="input-group mb-3">
                    <input type="text" id="filtroDescricao" name="filtroDescricao" class="form-control" maxlength="120" value="{{$filtroDescricao}}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="loadRecords('item')"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </li>
                <li class="nav-item">            
                    <label for="filtroCodigoBarras">Código de barras</label><br>
                    <div class="input-group mb-3">
                    <input type="text" id="filtroCodigoBarras" name="filtroCodigoBarras" class="form-control" maxlength="14" value="{{$filtroCodigoBarras}}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="loadRecords('item')"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </li>
                <li class="nav-item">            
                    <label class="custom-control-label">Situação:</label>
                </li>
                <li class="nav-item">            
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" id="filtroAtivo" name="filtroAtivo" onclick="loadRecords('item')" checked>
                        <label class="custom-control-label" for="filtroAtivo">Ativos</label>
                    </div>
                </li>
                <li class="nav-item">            
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" id="filtroInativo" name="filtroInativo" onclick="loadRecords('item')" {{$filtroInativo == 'S' ? 'checked' : ''}}>
                        <label class="custom-control-label" for="filtroInativo">Inativos</label>
                    </div>
                </li>
            </div>
        </div>
    </ul>
</nav>
@endsection

@section('titulo-cadastro')
    Cadastro de itens
@endsection
@section('ready')
    loadRecords('item');
    @if($filtroDescricao || $filtroCategoria || $filtroCodigoBarras || $filtroInativo == 'S') 
        $('.collapse').collapse();
    @endif  

@endsection

<script>
    function deleteItem(comp) {
        $.confirm({
            title: 'Atenção!',
            content: 'Clique em Sim para confirmar a exclusão do item',
            theme: 'dark',
            buttons: {
                Sim: function () {
                    var idItem = $('#' + comp).val()
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
</script>