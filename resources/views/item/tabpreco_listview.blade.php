<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            
                <table id="dataTable" class="table table-stripped">
                    <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Último custo</th>
                        <th>Preço atual</th>
                        <th>Novo preço</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lista as $obj)
                    <input type="hidden" id="i{{$obj->Id}}" value="{{$obj->Id}}">
                    <tr>
                        <td>
                            {{$obj->Descricao}}
                        </td>
                        <td>
                            {{number_format($obj->PrecoCusto, 2, ',', '')}}
                        </td>
                        <td>
                            {{number_format($obj->PrecoVenda, 2, ',', '')}}
                        </td>
                        <td>
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
