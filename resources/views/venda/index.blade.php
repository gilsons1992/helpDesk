@extends('template')

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
            <a href="/venda.pesquisaItem" class="nav-link">
                <img src="/img/Document Find-WF.png" width="40"/>
                <p>
                &nbsp;Localizar
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/venda.cancelaItem" class="nav-link">
                <img src="/img/Shopping Remove-02-WF.png" width="40"/>
                <p>
                &nbsp;Cancelar item
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:cancelaVenda()" class="nav-link">
                <img src="/img/Delete_04.png" width="40"/>
                <p>
                &nbsp;Cancelar venda
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:cancelaVenda()" class="nav-link">
                <img src="/img/Digital - Eight.png" width="40"/>
                <p>
                &nbsp;Quantidade
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:cancelaVenda()" class="nav-link">
                <img src="/img/Payments-01-WF.png" width="40"/>
                <p>
                &nbsp;Finalizar
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:cancelaVenda()" class="nav-link">
                <img src="/img/Printer_01.png" width="40"/>
                <p>
                &nbsp;Imprimir
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:cancelaVenda()" class="nav-link">
                <img src="/img/Money-Transfer.png" width="40"/>
                <p>
                &nbsp;Entr./Sangria
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:cancelaVenda()" class="nav-link">
                <img src="/img/Accounting-02-WF.png" width="40"/>
                <p>
                &nbsp;Fechar CX
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:cancelaVenda()" class="nav-link">
                <img src="/img/Barcode-01.png" width="40"/>
                <p>
                &nbsp;Itens
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:cancelaVenda()" class="nav-link">
                <img src="/img/Customer.png" width="40"/>
                <p>
                &nbsp;Clientes
                </p>
            </a>
        </li>
    </ul>
</nav>
@endsection

@section('main-content')
    <input type="hidden" id="logoEmpresa" value="{{$dadosEmpresa->Logo}}"/>
    <div id='content-body'></div>
@endsection

@section('ready')
    carregaVenda();
@endsection    

<script>

</script>