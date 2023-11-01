@extends('template-cad')
@section('sidebar-menu')
<nav class="mt-2">
    
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/unidade.index" class="nav-link">
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
    </ul>
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="javascript:deleteUnidade();" class="nav-link">
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
    Alteração de unidade
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
                <form id="formCad" action="/unidade.store" method="post">
                    @csrf
                <input type="hidden" id="Id" name="Id" value="{{$obj->Id}}">
                    <div class="card-body">
                <!-- Cógigo -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="Codigo">Código</label>
                    <input type="text" 
                            name="Codigo" 
                            class="form-control" 
                            id="Codigo" 
                            maxlength="6" 
                            value="{{$obj->Codigo}}"
                            >
                    </div>

                <!-- Descrição -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="Descricao">Descrição</label>
                    <input type="text" 
                            name="Descricao" 
                            class="form-control" 
                            id="Descricao" 
                            maxlength="30" 
                            value="{{$obj->Descricao}}"
                            >
                    </div>

                <!-- Fator Conversão -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="FatorConversao">Fator Conversão</label>
                    <input type="number" 
                            name="FatorConversao" 
                            class="form-control" 
                            id="FatorConversao" 
                            maxlength="120" 
                            value="{{$obj->FatorConversao}}"
                            >
                    </div>
                </div>

                <!-- Pesagem -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="Pesagem">Pesagem</label>
                    <input type="number" 
                            name="Pesagem" 
                            class="form-control" 
                            id="Pesagem" 
                            maxlength="4" 
                            value="{{$obj->Pesagem}}"
                            >
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
function deleteUnidade() {

    $.confirm({
        title: 'Atenção!',
        content: 'Clique em Sim para confirmar a exclusão da unidade',
        theme: 'dark',
        buttons: {
            Sim: function () {
                var idUnidade = $('#Id').val()
                $.ajax({
                    method: "post",
                    url: 'unidade.delete',
                    data: {
                        _token: "{{ csrf_token() }}",
                        Id:idUnidade
                    },
                    success: function (data) {
                        toast(data.msg);
                        if (data.success) {
                            setTimeout(function(){ location.href = 'unidade.index'; }, 3000);            
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