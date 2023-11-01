@extends('template-cad')
@section('sidebar-menu')
<nav class="mt-2">
    
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/configBanco.index" class="nav-link">
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
            <a href="javascript:deleteConfig();" class="nav-link">
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
    Alteração de configuração
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">{{$obj->CampoDescricao}} <small>[{{$obj->Id}}]</small></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="formCad" action="/configBanco.store" method="post">
                    @csrf
                <input type="hidden" id="Id" name="Id" value="{{$obj->Id}}">
                <div class="card-body">

                <!-- Servidor -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="Servidor">Servidor</label>
                    <input type="text" 
                            name="Servidor" 
                            class="form-control" 
                            id="Servidor" 
                            maxlength="120" 
                            value="{{$obj->Servidor}}"
                            >
                    </div>

                <!-- Tipo -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="Tipo">Tipo</label>
                    <input type="text" 
                            name="Tipo" 
                            class="form-control" 
                            id="Tipo" 
                            maxlength="1" 
                            value="{{$obj->Tipo}}"
                            >
                    </div>

                <!-- Banco -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="Banco">Banco</label>
                    <input type="text" 
                            name="Banco" 
                            class="form-control" 
                            id="Banco" 
                            maxlength="120" 
                            value="{{$obj->Banco}}"
                            >
                    </div>
                </div>

                <!-- Porta -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="Porta">Porta</label>
                    <input type="text" 
                            name="Porta" 
                            class="form-control" 
                            id="Porta" 
                            maxlength="4" 
                            value="{{$obj->Porta}}"
                            >
                    </div>
                </div>

                <!-- Usuario -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="Usuario">Usuário</label>
                    <input type="text" 
                            name="Usuario" 
                            class="form-control" 
                            id="Usuario" 
                            maxlength="45" 
                            value="{{$obj->Usuario}}"
                            >
                    </div>
                </div>

                <!-- Senha -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="Senha">Senha</label>
                    <input type="text" 
                            name="Senha" 
                            class="form-control" 
                            id="Senha" 
                            maxlength="120" 
                            value="{{$obj->Senha}}"
                            >
                    </div>
                </div>

                <!-- DadosEmpresaId -->
                <div class="form-group">
                    <label for="DadosEmpresaId">Dados Empresa</label>
                    <select class="form-control col-12" id="DadosEmpresaId" name="DadosEmpresaId">
                        @foreach($listaDadosEmpresa as $e)
                        <option value="{{$e->Id}}" {{($e->Id == $obj->DadosEmpresaId) ? 'selected' : ''}}>{{$e->RazaoSocial}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- TabelaItem -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="TabelaItem">Tabela de Item</label>
                    <input type="text" 
                            name="TabelaItem" 
                            class="form-control" 
                            id="TabelaItem" 
                            maxlength="45" 
                            value="{{$obj->TabelaItem}}"
                            >
                    </div>
                </div>

                <!-- CampoCodigoBarras -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CampoCodigoBarras">Campo de Codigo de barras</label>
                    <input type="text" 
                            name="CampoCodigoBarras" 
                            class="form-control" 
                            id="CampoCodigoBarras" 
                            maxlength="45" 
                            value="{{$obj->CampoCodigoBarras}}"
                            >
                    </div>
                </div>

                <!-- CampoDescricao -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CampoDescricao">Descrição</label>
                    <input type="text" 
                            name="CampoDescricao" 
                            class="form-control" 
                            id="CampoDescricao" 
                            maxlength="45" 
                            value="{{$obj->CampoDescricao}}"
                            >
                    </div>
                </div>

                <!-- CampoNCM -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CampoNCM">Campo NCM</label>
                    <input type="text" 
                            name="CampoNCM" 
                            class="form-control" 
                            id="CampoNCM" 
                            maxlength="45" 
                            value="{{$obj->CampoNCM}}"
                            >
                    </div>
                </div>

                <!-- CampoCEST -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CampoCEST">Campo CEST</label>
                    <input type="text" 
                            name="CampoCEST" 
                            class="form-control" 
                            id="CampoCEST" 
                            maxlength="45" 
                            value="{{$obj->CampoCEST}}"
                            >
                    </div>
                </div>

                <!-- CampoPreco -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CampoPreco">Preco</label>
                    <input type="text" 
                            name="CampoPreco" 
                            class="form-control" 
                            id="CampoPreco" 
                            maxlength="45" 
                            value="{{$obj->CampoPreco}}"
                            >
                    </div>
                </div>

                <!-- CampoCusto -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CampoCusto">Custo</label>
                    <input type="text" 
                            name="CampoCusto" 
                            class="form-control" 
                            id="CampoCusto" 
                            maxlength="45" 
                            value="{{$obj->CampoCusto}}"
                            >
                    </div>
                </div>

                <!-- CampoEstoque -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CampoEstoque">Estoque</label>
                    <input type="text" 
                            name="CampoEstoque" 
                            class="form-control" 
                            id="CampoEstoque" 
                            maxlength="45" 
                            value="{{$obj->CampoEstoque}}"
                            >
                    </div>
                </div>

                <!-- CampoReservado -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CampoReservado">Reservado</label>
                    <input type="text" 
                            name="CampoReservado" 
                            class="form-control" 
                            id="CampoReservado" 
                            maxlength="45" 
                            value="{{$obj->CampoReservado}}"
                            >
                    </div>
                </div>

                <!-- Ordem -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="Ordem">Ordem</label>
                    <input type="number" 
                            name="Ordem" 
                            class="form-control" 
                            id="Ordem" 
                            maxlength="120" 
                            value="{{$obj->Ordem}}"
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
function deleteConfigBanco() {

    $.confirm({
        title: 'Atenção!',
        content: 'Clique em Sim para confirmar a exclusão da configuração',
        theme: 'dark',
        buttons: {
            Sim: function () {
                var idConfiguracao = $('#Id').val()
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