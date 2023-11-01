@extends('template-cad')
@section('sidebar-menu')
<nav class="mt-2">
    
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/tributo.index" class="nav-link">
                <img src="/img/Previous.png" width="40"/>
                <p>
                &nbsp;Voltar
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:save();" class="nav-link">
                <img src="/img/Save_02.png" width="40"/>
                <p>
                &nbsp;Salvar
                </p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="javascript:deleteTributo();" class="nav-link">
                <img src="/img/Delete_04.png" width="40"/>
                <p>
                &nbsp;Excluir
                </p>
            </a>
        </li>
    </ul>
</nav>
@endsection

@section('titulo-cadastro')
    Alteração de tributo
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">{{$obj->Descricao}} <small>[{{$obj->Id}}]</small></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="formCad" action="/tributo.store" method="post">
                    @csrf
                <input type="hidden" id="Id" name="Id" value="{{$obj->Id}}">
                    <div class="card-body">
                <!-- Descrição -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="Descricao">Descrição</label>
                    <input type="text" 
                            name="Descricao" 
                            class="form-control" 
                            id="Descricao" 
                            maxlength="40" 
                            value="{{$obj->Descricao}}"
                            >
                    </div>
                </div>

                <!-- Alíquota ICMS consumidor -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="AliquotaICMSConsumidor">Alíquota ICMS consumidor</label>
                    <input type="text" 
                            maxlength="7"
                            class="form-control" 
                            id="AliquotaICMSConsumidor" 
                            name="AliquotaICMSConsumidor" 
                            onfocus="insertPriceMask(this)" 
                            value="{{$obj->AliquotaICMSConsumidor}}">
                    </div>
                </div>

                <!-- Alíquota ICMS contribuinte -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="AliquotaICMSContribuinte">Alíquota ICMS contribuinte</label>
                    <input type="text" 
                            maxlength="7"
                            class="form-control" 
                            id="AliquotaICMSContribuinte" 
                            name="AliquotaICMSContribuinte" 
                            onfocus="insertPriceMask(this)" 
                            value="{{$obj->AliquotaICMSContribuinte}}">
                    </div>
                </div>

                <!-- Alíquota ICMS ST -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="AliquotaICMSST">Alíquota ICMS ST</label>
                    <input type="text" 
                            maxlength="7"
                            class="form-control" 
                            id="AliquotaICMSST" 
                            name="AliquotaICMSST" 
                            onfocus="insertPriceMask(this)" 
                            value="{{$obj->AliquotaICMSST}}">
                    </div>
                </div>

                <!-- CST Consumidor -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CSTConsumidor">CST Consumidor</label>
                    <input type="text" 
                            name="CSTConsumidor" 
                            class="form-control" 
                            id="CSTConsumidor" 
                            onfocus="insertPriceMask(this)" 
                            maxlength="2" 
                            value="{{$obj->CSTConsumidor}}">
                    </div>
                </div>

                <!-- CST Contribuinte -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CSTContribuinte">CST Contribuinte</label>
                    <input type="text" 
                            name="CSTContribuinte" 
                            class="form-control" 
                            id="CSTContribuinte" 
                            onfocus="insertPriceMask(this)" 
                            maxlength="2" 
                            value="{{$obj->CSTContribuinte}}">
                            
                    </div>
                </div>

                <!-- CST Substituição Tributária -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CSTSubstituicaoTributaria">CST Substituição Tributária</label>
                    <input type="text" 
                            name="CSTSubstituicaoTributaria" 
                            class="form-control" 
                            id="CSTSubstituicaoTributaria" 
                            onfocus="insertPriceMask(this)" 
                            maxlength="2" 
                            value="{{$obj->CSTSubstituicaoTributaria}}">
                    </div>
                </div>

                <!-- CSOSN Consumidor -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CSOSNConsumidor">CSOSN Consumidor</label>
                    <input type="text" 
                            name="CSOSNConsumidor" 
                            class="form-control" 
                            onfocus="insertPriceMask(this)" 
                            id="CSOSNConsumidor" 
                            maxlength="3" 
                            value="{{$obj->CSOSNConsumidor}}">
                    </div>
                </div>

                <!-- CSOSN Contribuinte -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CSOSNContribuinte">CSOSN Contribuinte</label>
                    <input type="text" 
                            name="CSOSNContribuinte" 
                            class="form-control" 
                            id="CSOSNContribuinte" 
                            onfocus="insertPriceMask(this)" 
                            maxlength="3" 
                            value="{{$obj->CSOSNContribuinte}}">
                    </div>
                </div>

                <!-- Origem mercadoria -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="OrigemMercadoria">Origem mercadoria</label>
                    <input type="text" 
                            name="OrigemMercadoria" 
                            class="form-control" 
                            onfocus="insertPriceMask(this)" 
                            id="OrigemMercadoria" 
                            maxlength="1" 
                            value="{{$obj->OrigemMercadoria}}"
                            >
                    </div>
                </div>

                <!-- Alíquota PIS -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="AliquotaPIS">Alíquota PIS</label>
                    <input type="text" 
                            maxlength="7"
                            class="form-control" 
                            id="AliquotaPIS" 
                            name="AliquotaPIS" 
                            onfocus="insertPriceMask(this)" 
                            value="{{$obj->AliquotaPIS}}">
                    </div>
                </div>
 
                <!-- Alíquota COFINS -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="AliquotaCOFINS">Aliquota COFINS</label>
                    <input type="text" 
                            maxlength="7"
                            class="form-control" 
                            id="AliquotaCOFINS" 
                            name="AliquotaCOFINS" 
                            onfocus="insertPriceMask(this)" 
                            value="{{$obj->AliquotaCOFINS}}">
                    </div>
                </div>

                <!-- CST PIS -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CSTPIS">CST PIS</label>
                    <input type="text" 
                            name="CSTPIS" 
                            class="form-control" 
                            onfocus="insertPriceMask(this)" 
                            id="CSTPIS" 
                            maxlength="2" 
                            value="{{$obj->CSTPIS}}"
                            >
                    </div>
                </div>

                <!-- CST COFINS -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CSTCOFINS">CST COFINS</label>
                    <input type="text" 
                            name="CSTCOFINS" 
                            class="form-control" 
                            id="CSTOCOFINS" 
                            maxlength="2" 
                            onfocus="insertPriceMask(this)" 
                            value="{{$obj->CSTCOFINS}}"
                            >
                    </div>
                </div>

                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
            <!-- right column -->
        <div class="col-md-6">

            </div>
            <!--/.col (right) -->
        </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
<script>

function save() {    
    document.getElementById('formCad').submit();
}
function deleteTributo() {

    $.confirm({
        title: 'Atenção!',
        content: 'Clique em Sim para confirmar a exclusão da tributo',
        theme: 'dark',
        buttons: {
            Sim: function () {
                var idTributo = $('#Id').val()
                $.ajax({
                    method: "post",
                    url: 'tributo.delete',
                    data: {
                        _token: "{{ csrf_token() }}",
                        Id:idTributo
                    },
                    success: function (data) {
                        toast(data.msg);
                        if (data.success) {
                            setTimeout(function(){ location.href = 'tributo.index'; }, 3000);            
                        }
                    }
                });    
            },
            Não: function () {
                
            }
        }
    });  
}

</script>