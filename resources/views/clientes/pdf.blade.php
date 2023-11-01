<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
            
                <table id="dataTable" class="table table-stripped">
                    <thead>
                    <tr>
                        <th>Alterar</th>
                        <th>Excluir</th>
                        <th>N.Controle</th>
                        <th>Cliente</th>
                        <th>Motivo</th>
                        <th>Prioridade</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lista as $obj)
                    <input type="hidden" id="i{{$obj->Id}}" value="{{$obj->Id}}">
                    <tr>
                        <td width="1%">
                            <a href="/ordemServico.edit.{{$obj->Id}}"><img src="/img/Edit24.png" /></a>
                        </td>
                        <td width="1%">
                            <a href="javascript:deleteOrdemServico('i{{$obj->Id}}');"><img src ="/img/Delete_24.png" /></a>
                        </td>
                        <td>
                            {{$obj->Id}}
                        </td>
                        <td>
                            {{$obj->Cliente}}
                        </td>
                        <td>
                            {{$obj->Motivo}}
                        </td>
                        <td>
                            {{$obj->Prioridade}}
                        </td>
                        <td width="1%">
                            <a href="/ordemServico.gerarPdf.{{$obj->Id}}"><img src="/img/Document-Download-01.png" /></a>
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
