@extends('template-cad')
@section('sidebar-menu')
<nav class="mt-2">
    
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/clientesOs.index" class="nav-link">
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
</nav>
@endsection

@section('titulo-cadastro')
    Inclusão de usuário OS
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
                <!-- form start -->
                <form id="formCad" action="/clientesOs.store" method="post">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="Empresa">Empresa</label>
                            <input type="text" 
                                    name="Empresa" 
                                    class="form-control" 
                                    id="Empresa" 
                                    maxlength="45" 
                                    value="{{old('Empresa')}}"
                                    >
                            </div>
    
                        <div class="form-group">
                        <label for="Nome">Nome</label>
                        <input type="text" 
                                name="Nome" 
                                class="form-control" 
                                id="Nome" 
                                maxlength="45" 
                                value="{{old('Nome')}}"
                                >
                        </div>
    
                        <div class="form-group">
                            <label for="Endereco">Endereço</label>
                            <input type="text" 
                                    name="Endereco" 
                                    class="form-control" 
                                    id="Endereco" 
                                    maxlength="16" 
                                    value="{{old('Endereco')}}"
                                    >
                        </div>
                
                        <div class="form-group">
                            <label for="Telefone">Telefone</label>
                            <input type="number" 
                                    name="Telefone" 
                                    class="form-control" 
                                    id="Telefone" 
                                    oninput="limiteNumeroTelefone(this)"
                                    value="{{old('Telefone')}}"
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

</script>