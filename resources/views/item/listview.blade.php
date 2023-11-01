<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            
                <table id="dataTable" class="table table-stripped">
                    <thead>
                    <tr>
                        <th>Alterar</th>
                        <th>Excluir</th>
                        <th>Descrição</th>
                        <th>NCM</th>
                        <th>CEST</th>
                        <th>Preço</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lista as $obj)
                    <input type="hidden" id="i{{$obj->Id}}" value="{{$obj->Id}}">
                    <tr>
                        <td width="1%">
                            <a href="/item.edit.{{$obj->Id}}"><img src="/img/Edit24.png" /></a>
                        </td>
                        <td width="1%">
                            <a href="javascript:deleteItem('i{{$obj->Id}}');"><img src ="/img/Delete_24.png" /></a>
                        </td>
                        <td>
                            {{$obj->Descricao}}
                        </td>
                        <td>
                            <input type="text" 
                            class="form-control" 
                            id="CodigoNCM{{$obj->Id}}" 
                            onblur="save('{{$obj->Id}}')"
                            maxlength="8" 
                            value="{{$obj->CodigoNCM}}"
                            >                        
                        </td>
                        <td>
                            <input type="text" 
                            class="form-control" 
                            id="CodigoCest{{$obj->Id}}" 
                            onblur="save('{{$obj->Id}}')"
                            maxlength="7" 
                            value="{{$obj->CodigoCest}}"
                            >                            
                        </td>
                        <td>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="PrecoVenda{{$obj->Id}}" 
                                onblur="save('{{$obj->Id}}')"
                                value="{{number_format($obj->PrecoVenda, 2, ',', '')}}" 
                                onfocus="insertPriceMask(this);">
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @include('pagination')            
        </div>
        <!-- /.card -->
    </div>
</div>
<script>
function save(id) {
    var preco = $('#PrecoVenda' + id).val();
    var ncm = $('#CodigoNCM' + id).val();
    var cest = $('#CodigoCest' + id).val();
    
    $.ajax({
        method: "post",
        url: '/item.saveAjax',
        data: {
            _token: "{{ csrf_token() }}",
            'PrecoVenda':preco,
            'CodigoNCM':ncm,
            'CodigoCest':cest,
            Id:id
        },
        success: function (data) {
            //toast('Ok. Alteração salva no banco.')
        }
    });

}
</script>