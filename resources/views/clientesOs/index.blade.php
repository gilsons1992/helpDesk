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
            <a href="/clientesOs.create" class="nav-link">
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
    Cadastro de clientes OS
@endsection

@section('ready')
    loadRecords('clienteOs');
@endsection

<script>
    function deleteClienteOs(comp) {
        $.confirm({
            title: 'Atenção!',
            content: 'Clique em Sim para confirmar a exclusão do cliente',
            theme: 'dark',
            buttons: {
                Sim: function () {
                    var idCliente = $('#' + comp).val()
                    $.ajax({
                        method: "post",
                        url: 'clientesOs.delete',
                        data: {
                            _token: "{{ csrf_token() }}",
                            Id:idCliente
                        },
                        success: function (data) {
                            toast(data.msg);
                            if (data.success) {
                                setTimeout(function(){ location.href = 'clientesOs.index'; }, 3000);            
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