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
            <a href="/ordemServico.create" class="nav-link">
                <img src="/img/Plus_01.png" width="40"/>
                <p>
                &nbsp;Incluir OS
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/ordemServico.create" class="nav-link">
                <img src="/img/user.png" width="40"/>
                <p>
                &nbsp;Clientes
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
                    <label for="filtroNumeroControle">Número de Controle</label><br>
                    <div class="input-group mb-3">
                    <input type="text" id="id" name="id" class="form-control" maxlength="14" value="{{$filtroNumeroControle}}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="loadRecords('ordemServico')"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </li>
            </div>
        </div>
    </ul>
</nav>
@endsection

@section('titulo-cadastro')
    Ordem de Serviço
@endsection

@section('ready')
    loadRecords('ordemServico');
@endsection

<script>
    function deleteOrdemServico(comp) {
        $.confirm({
            title: 'Atenção!',
            content: 'Clique em Sim para confirmar a exclusão da OS',
            theme: 'dark',
            buttons: {
                Sim: function () {
                    var idOrdemServico = $('#' + comp).val()
                    $.ajax({
                        method: "post",
                        url: 'ordemServico.delete',
                        data: {
                            _token: "{{ csrf_token() }}",
                            Id:idOrdemServico
                        },
                        success: function (data) {
                            toast(data.msg);
                            if (data.success) {
                                setTimeout(function(){ location.href = 'ordemServico.index'; }, 3000);            
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