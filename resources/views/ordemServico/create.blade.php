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
</nav>
@endsection

@section('titulo-cadastro')
    Ordem de Serviço
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
                <!-- form start -->
                <form id="formCad" action="/ordemServico.store" method="post">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                        <label for="Cliente">Cliente</label>
                        <input type="text" 
                                name="Cliente" 
                                class="form-control" 
                                id="Cliente" 
                                maxlength="45" 
                                value="{{old('Cliente')}}"
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
                            <label for="TaxaServico">Taxa de Serviço</label>
                            <input type="text" class="form-control" id="TaxaServico" name="TaxaServico" onfocus="insertPriceMask(this)" value="{{old('TaxaServico')}}">
                        </div>
        
                        <div class="form-group">
                            <label for="Motivo">Motivo da Chamada</label>
                            <textarea name="Motivo" id="Motivo" rows="5" class="form-control" value="{{old('Motivo')}}" cols="40" maxlength="400"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="Diagnostico">Diagnóstico</label>
                            <textarea name="Diagnostico" id="Diagnostico" rows="5" class="form-control" value="{{old('Diagnostico')}}" cols="40" maxlength="400"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="Procedimento">Procedimento</label>
                            <textarea name="Procedimento" rows="5" id="Procedimento" class="form-control" value="{{old('Procedimento')}}" cols="40" maxlength="400"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="Observacao">Observação</label>
                            <textarea name="Observacao" rows="5" id="Observacao" class="form-control" value="{{old('Observacao')}}" cols="40" maxlength="400"></textarea>
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