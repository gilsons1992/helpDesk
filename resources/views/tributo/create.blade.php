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
</nav>
@endsection

@section('titulo-cadastro')
    Inclusão de tributo
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
                <!-- form start -->
                <form id="formCad" action="/tributo.store" method="post">
                    @csrf
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
                            value="{{old('Descricao')}}"
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
                            value="{{old('AliquotaICMSConsumidor')}}">
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
                            value="{{old('AliquotaICMSContribuinte')}}">
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
                            value="{{old('AliquotaICMSST')}}">
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
                            maxlength="2" 
                            onfocus="insertPriceMask(this)" 
                            value="{{old('CSTConsumidor')}}"
                            >
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
                            value="{{old('CSTContribuinte')}}"
                            >
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
                            value="{{old('CSTSubstituicaoTributaria')}}"
                            >
                    </div>
                </div>

                <!-- CSOSN Consumidor -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CSOSNConsumidor">CSOSN Consumidor</label>
                    <input type="text" 
                            name="CSOSNConsumidor" 
                            class="form-control" 
                            id="CSOSNConsumidor" 
                            onfocus="insertPriceMask(this)" 
                            maxlength="3" 
                            value="{{old('CSOSNConsumidor')}}"
                            >
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
                            value="{{old('CSOSNContribuinte')}}"
                            >
                    </div>
                </div>

                <!-- Origem mercadoria -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="OrigemMercadoria">Origem mercadoria</label>
                    <input type="text" 
                            name="OrigemMercadoria" 
                            class="form-control" 
                            id="OrigemMercadoria" 
                            onfocus="insertPriceMask(this)" 
                            maxlength="1" 
                            value="{{old('OrigemMercadoria')}}"
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
                            value="{{old('AliquotaPIS')}}">
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
                            value="{{old('AliquotaCOFINS')}}">
                    </div>
                </div>

                <!-- CST PIS -->
                <div class="form-group">
                    <div class="form-group">
                    <label for="CSTPIS">CST PIS</label>
                    <input type="text" 
                            name="CSTPIS" 
                            onfocus="insertPriceMask(this)" 
                            class="form-control" 
                            id="CSTPIS" 
                            maxlength="2" 
                            value="{{old('CSTPIS')}}"
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
                            value="{{old('CSTCOFINS')}}"
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

</script>