@extends('template-cad')
@section('sidebar-menu')
<nav class="mt-2">    
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/item.index" class="nav-link">
                <img src="/img/Previous.png" width="40"/>
                <p>
                &nbsp;Voltar
                </p>
            </a>
        </li>
    </ul>
</nav>
@endsection
@section('titulo-cadastro')
    Importação de XML
@endsection

@section('main-content')
    <form id="xmlForm" method="post" action="/item.processarXML" enctype="multipart/form-data">
        @csrf
        <a href="#" class="btn btn-primary" id="btnSelectFile">Selecionar arquivo XML</a>
        <input type="file" name="xmlFile" id="xmlFileInput" accept="application/xml, text/xml" style="display: none;" />
        <button type="submit" style="display: none;"></button>
    </form>
@endsection
@section('ready')
    $("#btnSelectFile").on("click", function(e) {
                e.preventDefault();
                // Simular clique no input file oculto
                $("#xmlFileInput").click();
            });

            $("#xmlFileInput").on("change", function() {
                $.confirm({
                    title: 'Atenção!',
                    content: 'Clique em Sim para a importação do arquivo selecionado.',
                    theme: 'dark',
                    buttons: {
                        Sim: function () {
                            $("#xmlForm").submit();
                        },
                        Não: function () {
                            
                        }
                    }
                });                        
            });
@endsection
