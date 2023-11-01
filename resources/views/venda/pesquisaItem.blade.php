@extends('template')

@section('sidebar-menu')
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/venda.index" class="nav-link">
                <img src="/img/Previous.png" width="40"/>
                <p>
                &nbsp;Voltar
                </p>
            </a>
        </li>
    </ul>
</nav>
@endsection

@section('main-content')
<div class="container">
    <form id="formPesquisaItem">
        @csrf
    <div class="row">
        <div class="col-12 text-center border border-white">
            <div class="form-group mb-2">
                <label for="descricao">Descrição</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="descricao" 
                    onkeypress="handle(event)"
                    autofocus>
            </div>
        </div>
    </div>    
    <div class="row" style="height:450px; margin-top: 10px;">        
        <div class="col-12 text-center border border-white">
            <div class="card">
                <div class="card-body">                
                    <div id="divResultadoPesquisa"></div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>    
@endsection

@section('ready')
    pesquisaItens();
@endsection

<script>
    function pesquisaItens() {
        var descricao = $('#descricao').val();

        $.ajax({
            method: "post",
            url: 'venda.executaPesquisaItem',
            data: {
                _token: "{{ csrf_token() }}",
                descricao:descricao
            },
            success: function (data) {
                $('#divResultadoPesquisa').html(data);
            }
        });    
    }

    function handle(e){
        if(e.keyCode === 13){
            e.preventDefault(); 
            pesquisaItens();
        }
    }
    
</script>