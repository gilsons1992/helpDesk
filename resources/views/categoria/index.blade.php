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
            <a href="/categoria.create" class="nav-link">
                <img src="/img/Plus_01.png" width="40"/>
                <p>
                &nbsp;Incluir
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
                    <label for="filtroDescricao">Descrição</label><br>
                    <div class="input-group mb-3">
                    <input type="text" id="filtroDescricao" name="filtroDescricao" class="form-control" value="{{$filtroDescricao}}" maxlength="120">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="loadRecords('categoria')"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </li>
            </div>
        </div>
    </ul>
</nav>
@endsection

@section('titulo-cadastro')
    Cadastro de categorias
@endsection

@section('ready')
    loadRecords('categoria');
    @if($filtroDescricao) 
        $('.collapse').collapse();
    @endif  
@endsection

<script>
    function deleteCategoria(comp) {
        $.confirm({
            title: 'Atenção!',
            content: 'Clique em Sim para confirmar a exclusão da categoria',
            theme: 'dark',
            buttons: {
                Sim: function () {
                    var idCategoria = $('#' + comp).val()
                    $.ajax({
                        method: "post",
                        url: 'categoria.delete',
                        data: {
                            _token: "{{ csrf_token() }}",
                            Id:idCategoria
                        },
                        success: function (data) {
                            toast(data.msg);
                            if (data.success) {
                                setTimeout(function(){ location.href = 'categoria.index'; }, 3000);            
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