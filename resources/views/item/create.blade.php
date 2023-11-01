@extends('template-cad')
@section('sidebar-menu')
<nav class="mt-2">
    
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/item.index" class="nav-link">
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
    Inclusão de item
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
                <!-- form start -->
                <form id="formCad" action="/item.store" method="post">
                    @csrf
                <div class="card-body">                

                <div class="form-group">
                <label>Clique na imagem para alterar</label><br>
                    @if(old('Imagem'))
                        <img src="{{old('Imagem')}}" onclick="loadImage(this, 'Imagem')" width="200" height="250"/>
                    @else
                        <img src="/img/Image_01.png" onclick="loadImage(this, 'Imagem')" width="200" height="250"/>
                    @endif                    
                    <input type="hidden" id="Imagem" name="Imagem" value="{{old('Imagem')}}">
                </div>                
                <div class="form-group">
                    <label for="CodigoBarras">Código de barras</label>
                    <input type="text" 
                            name="CodigoBarras" 
                            class="form-control" 
                            id="CodigoBarras" 
                            maxlength="14" 
                            value="{{old('CodigoBarras')}}"
                            onblur="javascript:pesquisaItemPorCodigoDeBarras()"
                            >
                    </div>
                    <div class="form-group">
                    <label for="Descricao">Descrição</label>
                    <input type="text" 
                            name="Descricao" 
                            class="form-control" 
                            id="Descricao" 
                            maxlength="120"
                            value="{{old('Descricao')}}"
                            >
                    </div>
                    <div class="form-group">
                    <label for="CategoriaId">Categoria</label>
                    <select class="form-control" id="CategoriaId" name="CategoriaId">
                        @foreach($listaCategorias as $e)
                        <option value="{{$e->Id}}" {{($e->Id == old('CategoriaId') || $e->Id == 1) ? 'selected' : ''}}>{{$e->Descricao}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="UnidadeComercialId">Unidade</label>
                    <select class="form-control" id="UnidadeComercialId" name="UnidadeComercialId">
                        @foreach($listaUnidades as $e)
                        <option value="{{$e->Id}}" {{($e->Id == old('UnidadeComercialId') || $e->Id == 1) ? 'selected' : ''}}>{{$e->Descricao}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="CodigoNCM">NCM</label>
                    <input type="text" 
                            name="CodigoNCM" 
                            class="form-control" 
                            id="CodigoNCM" 
                            maxlength="8" 
                            value="{{old('CodigoNCM')}}"
                            >
                    </div>
                    <div class="form-group">
                    <label for="CodigoCest">CEST</label>
                    <input type="text" 
                            name="CodigoCest" 
                            class="form-control" 
                            id="CodigoCest" 
                            maxlength="7" 
                            value="{{old('CodigoCest')}}"
                            >
                    </div>
                    <div class="form-group">
                    <label for="TributoId">Tributos</label>
                    <select class="form-control" id="TributoId" name="TributoId">
                        @foreach($listaTributos as $e)
                        <option value="{{$e->Id}}" {{($e->Id == old('TributoId')) ? 'selected' : ''}}>{{$e->Descricao}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="Disponivel">Disponível</label>
                    <input type="number" class="form-control" id="Disponivel" name="Disponivel" value="{{old('Disponivel')}}">
                    </div>
                    <div class="form-group">
                    <label for="EstoqueMinimo">Estoque mínimo</label>
                    <input type="number" class="form-control" id="EstoqueMinimo" name="EstoqueMinimo"  value="{{old('EstoqueMinimo')}}">
                    </div>
                    <div class="form-group">
                    <label for="PrecoCusto">Preço custo</label>
                    <input type="text" class="form-control" id="PrecoCusto" name="PrecoCusto" onfocus="insertPriceMask(this)" value="{{old('PrecoCusto')}}">
                    </div>
                    <div class="form-group">
                    <label for="PrecoVenda">Preço venda</label>
                    <input type="text" class="form-control" id="PrecoVenda" name="PrecoVenda"onfocus="insertPriceMask(this)" value="{{old('PrecoVenda')}}">
                    </div>
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" id="ControlaEstoque" name="ControlaEstoque" {{old('ControlaEstoque') ? 'checked' : ''}}>
                        <label class="custom-control-label" for="ControlaEstoque">Controla estoque</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" id="ProducaoPropria" name="ProducaoPropria" {{old('ProducaoPropria') ? 'checked' : ''}}>
                        <label class="custom-control-label" for="ProducaoPropria">Produção própria</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" id="Combustivel" name="Combustivel" {{old('Combustivel') ? 'checked' : ''}}>
                        <label class="custom-control-label" for="Combustivel">Combustível</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" id="Ativo" name="Ativo" {{old('Ativo') ? 'checked' : ''}}>
                        <label class="custom-control-label" for="Ativo">Ativo</label>
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