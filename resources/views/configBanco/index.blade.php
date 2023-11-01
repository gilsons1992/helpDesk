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
            <a href="/configBanco.create" class="nav-link">
                <img src="/img/Plus_01.png" width="40"/>
                <p>
                &nbsp;Incluir
                </p>
            </a>
        </li>
    </ul>
</nav>
@endsection

@section('titulo-cadastro')
    Cadastro de Configuração de banco
@endsection

@section('ready')
    loadRecords('configbanco');
@endsection

<script>
    function deleteConfigBanco(comp) {
        $.confirm({
            title: 'Atenção!',
            content: 'Clique em Sim para confirmar a exclusão da configuração',
            theme: 'dark',
            buttons: {
                Sim: function () {
                    var idConfiguracao = $('#' + comp).val()
                    $.ajax({
                        method: "post",
                        url: 'configBanco.delete',
                        data: {
                            _token: "{{ csrf_token() }}",
                            Id:idConfiguracao
                        },
                        success: function (data) {
                            toast(data.msg);
                            if (data.success) {
                                setTimeout(function(){ location.href = 'configBanco.index'; }, 3000);            
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