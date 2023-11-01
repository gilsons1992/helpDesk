@extends('template-cad')
@section('sidebar-menu')
<nav class="mt-2">
    
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/usuario.index" class="nav-link">
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
            <a href="javascript:deleteUsuario();" class="nav-link">
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
    Alteração de usuário
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">{{$obj->Nome}} <small>[{{$obj->Id}}]</small></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="formCad" action="/usuario.store" method="post">
                    @csrf
                <input type="hidden" id="Id" name="Id" value="{{$obj->Id}}">
                <div class="card-body">                

                <div class="form-group">
                    <div class="form-group">
                    <label for="Nome">Nome</label>
                    <input type="text" 
                            name="Nome" 
                            class="form-control" 
                            id="Nome" 
                            maxlength="45" 
                            value="{{$obj->Nome}}"
                            >
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                        <label for="Login">Login</label>
                        <input type="text" 
                                name="Login" 
                                class="form-control" 
                                id="Login" 
                                maxlength="16" 
                                value="{{$obj->Login}}"
                                >
                    </div>
    
                    <div class="form-group">
                        <div class="form-group">
                        <label for="Senha">Senha</label>
                        <input type="password" 
                                name="Senha" 
                                class="form-control" 
                                id="Senha" 
                                maxlength="32" 
                                value="{{$obj->Senha}}"
                                >
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="text" 
                                name="Email" 
                                class="form-control" 
                                id="Email" 
                                maxlength="120" 
                                value="{{$obj->Email}}"
                                >
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                        <label for="Telefone">Telefone</label>
                        <input type="number" 
                                name="Telefone" 
                                class="form-control" 
                                id="Telefone" 
                                oninput="limiteNumeroTelefone(this)"
                                value="{{$obj->Telefone}}"
                                >
                    </div>

                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" id="Ativo" name="Ativo" {{$obj->Ativo ? 'checked' : ''}}>
                        <label class="custom-control-label" for="Ativo">Ativo</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" id="Adm" name="Adm" {{$obj->Adm ? 'checked' : ''}}>
                        <label class="custom-control-label" for="Adm">Administrador</label>
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
function deleteUsuario() {

    $.confirm({
        title: 'Atenção!',
        content: 'Clique em Sim para confirmar a exclusão do usuário',
        theme: 'dark',
        buttons: {
            Sim: function () {
                var idUsuario = $('#Id').val()
                $.ajax({
                    method: "post",
                    url: 'usuario.delete',
                    data: {
                        _token: "{{ csrf_token() }}",
                        Id:idUsuario
                    },
                    success: function (data) {
                        toast(data.msg);
                        if (data.success) {
                            setTimeout(function(){ location.href = 'usuario.index'; }, 3000);            
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