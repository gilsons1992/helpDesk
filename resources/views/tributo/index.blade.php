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
            <a href="/tributo.create" class="nav-link">
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
    Cadastro de tributo
@endsection

@section('ready')
    loadRecords('tributo');
@endsection

<script>
    function deleteTributo(comp) {
        $.confirm({
            title: 'Atenção!',
            content: 'Clique em Sim para confirmar a exclusão do tributo',
            theme: 'dark',
            buttons: {
                Sim: function () {
                    var idTributo = $('#' + comp).val()
                    $.ajax({
                        method: "post",
                        url: 'tributo.delete',
                        data: {
                            _token: "{{ csrf_token() }}",
                            Id:idTributo
                        },
                        success: function (data) {
                            toast(data.msg);
                            if (data.success) {
                                setTimeout(function(){ location.href = 'tributo.index'; }, 3000);            
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