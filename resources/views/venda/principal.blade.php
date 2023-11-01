<div class="container">
    <div class="row">
        <div class="col-12 text-center border border-white">
            <h4><span id="spDescricaoItem">C A I X A&nbsp;&nbsp;&nbsp;&nbsp;L I V R E</span></h4>
        </div>
    </div>
    <div class="row" style="height:450px; margin-top: 10px;">
        <div class="col-8" style="background-color:white;color:black;font-family: 'Courier New', Courier, monospace;">
            <span id="spItensVenda"></span>
        </div>
        <div class="col-4">
            <div class="image-container">
                <img 
                    id="imagemItem" 
                    src="/img/Image_01.png" 
                    class="img-fluid"
                    style="width: 100%;height: 100%;object-fit: fill;" 
                    alt="Image">
            </div>
        </div>
    </div>
    <!-- Rodapé -->
    <div class="row border border-white" style="height:100px; margin-top: 10px;">
        <span id="divRodape">
            <input type="hidden" id="codigoUtimoItem">
            <input type="hidden" id="vendaId" value="{{$venda->Id}}">
            <table width="100%">
                <tr>
                    <td style="padding: 10px;">
                        <div class="form-group mb-2">
                            <label for="codigoBarras">Código</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="codigoBarras" 
                                maxlength="14"
                                size="12"
                                value="{{$itemSelecionado ? $itemSelecionado->CodigoBarras : ''}}"
                                onkeypress="handle(event)"
                                onblur="this.focus()"
                                autofocus 
                                onfocus="this.select()">
                        </div>
                    </td>
                    <td style="padding: 10px;">
                        <div class="form-group mb-2">
                            <label for="precoUnitario">Preço unitário</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="precoUnitario" 
                                readonly
                                style="text-align: right"
                                size="10"
                                >
                        </div>
                    </td>
                    <td style="padding: 10px;">
                        <div class="form-group mb-2">
                            <label for="quantidade">Quantidade</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="quantidade" 
                                value="1"
                                readonly
                                style="text-align: right"
                                size="5"
                                >
                        </div>
                    </td>
                    <td style="padding: 10px;">
                        <div class="form-group mb-2">
                            <label for="subtotal">Subtotal</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="subtotal" 
                                readonly
                                style="text-align: right"
                                size="10"
                                >
                        </div>
                    </td>
                    <td style="padding: 10px;">
                        <div class="form-group mb-2">
                            <label for="subtotal">Total</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="total" 
                                readonly
                                style="text-align: right"
                                size="10"
                                >
                        </div>
                    </td>
                </tr>
            </table>
        </span>
    </div>
</div>
<script>
    
    function handle(e){
        if(e.keyCode === 13){
            e.preventDefault(); 
            var codigoBarras = $('#codigoBarras').val();
            if (!codigoBarras) {
                $('#codigoBarras').focus();
                return;
            }
            $.ajax({
                    method: "get",
                    url: 'item.pesquisaPorCodigoBarras.' + codigoBarras,
                    data: {},
                    success: function (data) {
                        if (!data.success) {
                            toast(data.msg);
                            return;
                        }
                        if (!data.obj) {
                            toast('Item não localizado');
                            return;
                        }
                        $('#spDescricaoItem').html(data.obj.Descricao);
                        $('#precoUnitario').val(floatToStr(data.obj.PrecoVenda));
                        $('#codigoBarras').val('');
                        calcularSubtotal();
                        adicionaItemAoCupom(data.obj.Id);
                    }
            });                
        }
    }

    function calcularSubtotal() {
        var unitario = strToFloat($('#precoUnitario').val());
        var quantidade = strToFloat($('#quantidade').val());
        var subtotal = unitario * quantidade;
        $('#subtotal').val(floatToStr(subtotal));
    }

    function retornaItens(vendaId) {
        $.ajax({
            method: "get",
            url: 'venda.retornaItens.' + vendaId,
            data: {},
            success: function (data) {
                $('#spItensVenda').html(data);
                $('#total').val($('#hdnTotal').val());
                var imgSrc = "data:image/png;base64, " + $('#logoEmpresa').val();
                if($('#hdnImagemUltimoItem').val()) {
                    imgSrc = "data:image/png;base64, " + $('#hdnImagemUltimoItem').val();
                }
                $("#imagemItem").attr("src", imgSrc);
                $('#precoUnitario').val($('#hdnUltimoPreco').val());
                $('#subtotal').val($('#hdnUltimoSubtotal').val());
                $('#quantidade').val($('#hdnUltimaQuantidade').val());
            }
        });            
    }

    function adicionaItemAoCupom(itemId) {
        var vendaId = $('#vendaId').val();
        var unitario = strToFloat($('#precoUnitario').val());
        var quantidade = strToFloat($('#quantidade').val());
        var subtotal = strToFloat($('#subtotal').val());
        $.ajax({
            method: "post",
            url: 'venda.adicionaItemAoCupom',
            data: {
                _token: "{{ csrf_token() }}",
                itemId:itemId,
                vendaId:vendaId,
                unitario:unitario,
                quantidade:quantidade,
                subtotal:subtotal
            },
            success: function (data) {
                retornaItens(vendaId);
            }
        });            
        
    }
    retornaItens($('#vendaId').val());
</script>