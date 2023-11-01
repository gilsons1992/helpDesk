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
        <li class="nav-item">
            <a href="javascript:cancelaItens()" class="nav-link">
                <img src="/img/Delete_04.png" width="40"/>
                <p>
                &nbsp;Cancelar
                </p>
            </a>
        </li>
    </ul>
</nav>
@endsection

@section('main-content')
    <form id="formExcItemVenda" action="/venda.executaCancelaItem" method="post">
        @csrf
        <table width="100%" class="table">
            <tr>
                <th>#</th>
                <th></th>
                <th>Item</th>
                <th style="text-align: right;">Unitário</th>
                <th style="text-align: right;">Quantidade</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
            @foreach($listaItensVenda as $item)
                <tr>
                    <td>{{$item->Ordem}}</td>
                    <td>
                        <div class="form-check">
                            <input type="checkbox" 
                                    class="form-check-input" 
                                    id="chkItem{{$item->Id}}" 
                                    name="chkItem{{$item->Id}}" 
                                    value="{{$item->Id}}">
                        </div>
                    </td>
                    <td>{{$item->item->Descricao}}</td>
                    <td style="text-align: right;">{{number_format($item->PrecoUnitario,2,',','')}}</td>
                    <td style="text-align: right;">{{number_format($item->Quantidade,2,',','')}}</td>
                    <td style="text-align: right;">{{number_format($item->Subtotal,2,',','')}}</td>
                </tr>
            @endforeach
        </table>        
    </form>
@endsection
<script>
    function cancelaItens() {
        var checkboxes = $('input[type="checkbox"][name^="chkItem"]');
        
        var algumMarcado = checkboxes.is(':checked');        
        if (!algumMarcado) {
            toast('Nenhum item foi selecionado para cancelamento');
            return;
        }
        $('#formExcItemVenda').submit();
    }
</script>