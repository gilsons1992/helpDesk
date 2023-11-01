<input type="hidden" id="hdnTotal" value="{{$total}}">

<input type="hidden" id="hdnImagemUltimoItem" value="{{$ultimoItem ? $ultimoItem->Imagem : ''}}">
<input type="hidden" id="hdnDescricaoUltimoItem" value="{{$ultimoItem ? $ultimoItem->Descricao : ''}}">
<input type="hidden" id="hdnUltimoPreco" value="{{$ultimoPreco}}">
<input type="hidden" id="hdnUltimoSubtotal" value="{{$ultimoSubtotal}}">
<input type="hidden" id="hdnUltimaQuantidade" value="{{$ultimaQuantidade}}">
<table width="100%" class="table">
    <tr>
        <th>#</th>
        <th>Item</th>
        <th style="text-align: right;">Unitário</th>
        <th style="text-align: right;">Quantidade</th>
        <th style="text-align: right;">Subtotal</th>
    </tr>
    @foreach($listaItensVenda as $item)
        <tr
        @if($item->Cancelado)
            class="table-danger"
        @endif
        >
            <td>{{$item->Ordem}}</td>
            <td>{{$item->item->Descricao}}</td>
            <td style="text-align: right;">{{number_format($item->PrecoUnitario,2,',','')}}</td>
            <td style="text-align: right;">{{number_format($item->Quantidade,2,',','')}}</td>
            <td style="text-align: right;">{{number_format($item->Subtotal,2,',','')}}</td>
        </tr>
    @endforeach
</table>