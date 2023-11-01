<table id="dataTable" class="table table-stripped">
    <thead>
    <tr>
        <th>Selecionar</th>
        <th>Descrição</th>
        <th style="text-align: right;">Preço</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lista as $obj)
    <input type="hidden" id="i{{$obj->Id}}" value="{{$obj->Id}}">
    <tr>
        <td width="1%">
            <a href="/venda.selecionaItem.{{$obj->Id}}"><img src="/img/CheckMark24.png" /></a>
        </td>
        <td>
            {{$obj->Descricao}}
        </td>
        <td style="text-align: right;">
            {{number_format($obj->PrecoVenda, 2, ',', '')}}
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
