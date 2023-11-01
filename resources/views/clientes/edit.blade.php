@extends('template-cad')
@section('sidebar-menu')
<nav class="mt-2">
    
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/ordemServico.index" class="nav-link">
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
            <a href="javascript:deleteOrdemServico();" class="nav-link">
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
    Alteração de OS
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">{{$obj->Cliente}} <small>[{{$obj->Id}}]</small></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="formCad" action="/ordemServico.store" method="post">
                    @csrf
                <input type="hidden" id="Id" name="Id" value="{{$obj->Id}}">
                <div class="card-body">                

                <div class="form-group">
                    <div class="form-group">
                    <label for="Cliente">Cliente</label>
                    <input type="text" 
                            name="Cliente" 
                            class="form-control" 
                            id="Cliente" 
                            maxlength="45" 
                            value="{{$obj->Cliente}}"
                            >
                    </div>

                    <div class="form-group">
                        <label for="Status">Status</label>
                        <select class="form-control col-12" id="Status" name="Status">
                            <option value="Aberta">Aberta</option>
                            <option value="EmAndamento">Em Andamento</option>
                            <option value="Fechada">Fechada</option>
                        </select>
                    </div>    

    
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

                    <div class="form-group">
                        <label for="Prioridade">Prioridade</label>
                        <select class="form-control col-12" id="Prioridade" name="Prioridade">
                            <option value="Baixa">Baixa</option>
                            <option value="Media">Média</option>
                            <option value="Alta">Alta</option>
                        </select>
                    </div>    
                    

                    <div class="form-group">
                        <label for="TaxaServico">Taxa de Serviço</label>
                        <input type="text" class="form-control" id="TaxaServico" name="TaxaServico" onfocus="insertPriceMask(this)" value="{{$obj->TaxaServico}}">
                    </div>
    
                    <div class="form-group">
                        <label for="Motivo">Motivo da Chamada</label>
                        <textarea name="Motivo" id="Motivo" rows="5" class="form-control" value="{{$obj->Motivo}}" cols="40" maxlength="400">{{$obj->Motivo}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="Diagnostico">Diagnóstico</label>
                        <textarea name="Diagnostico" id="Diagnostico" rows="5" class="form-control" value="{{$obj->Diagnostico}}" cols="40" maxlength="400">{{$obj->Diagnostico}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="Procedimento">Procedimento</label>
                        <textarea name="Procedimento" rows="5" id="Procedimento" class="form-control" value="{{$obj->Procedimento}}" cols="40" maxlength="400">{{$obj->Procedimento}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="Observacao">Observação</label>
                        <textarea name="Observacao" rows="5" id="Observacao" class="form-control" value="{{$obj->Observacao}}" cols="40" maxlength="400">{{$obj->Observacao}}</textarea>
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