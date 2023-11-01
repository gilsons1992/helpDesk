<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
            
                <table id="dataTable" class="table table-stripped">
                    <thead>
                    <tr>
                        <th>Alterar</th>
                        <th>Excluir</th>
                        <th>Nome</th>
                        <th>Empresa</th>
                        <th>Telefone</th>
                        <th>Prioridade</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lista as $obj)
                    <input type="hidden" id="i{{$obj->Id}}" value="{{$obj->Id}}">
                    <tr>
                        <td width="1%">
                            <a href="/clientesOs.edit.{{$obj->Id}}"><img src="/img/Edit24.png" /></a>
                        </td>
                        <td width="1%">
                            <a href="javascript:deleteClienteOs('i{{$obj->Id}}');"><img src ="/img/Delete_24.png" /></a>
                        </td>
                        <td>
                            {{$obj->Nome}}
                        </td>
                        <td>
                            {{$obj->Empresa}}
                        </td>
                        <td>
                            {{$obj->Telefone}}
                        </td>
                        <td>
                            {{$obj->Prioridade}}
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
