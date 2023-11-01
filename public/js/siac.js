function insertPriceMask(componente) {
    $('#' + componente.id).mask('###0,00', {reverse:true});
    componente.select();
}

function insertQuantMask(componente) {
    $('#' + componente.id).mask('######0,0000', {reverse:true});
    componente.select();
}

function insertPercentMask(componente) {
    $('#' + componente.id).mask('######0,0', {reverse:true});
    componente.select();
}


function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

function loadRecords(entity) {
    switch(entity) {
        case 'tributo':
            loadTributo();
            break;
        case 'usuario':
            loadUsuario();
            break;
        case 'unidade':
            loadUnidade();
            break;
        case 'configbanco':
            loadConfigBanco();
            break;
        case 'categoria':
            loadCategorias();
            break;
        case 'item':
            loadItens();
            break;
        case 'ordemServico':
            loadOrdemServicos();
        break;
        case 'clienteOs':
            loadClientesOs();
        break;
            }    
}

function warning (texto) {
    $.alert({
        title: 'Atenção!',
        content: texto,
        icon: 'fa fa-exclamation-triangle',
        animation: 'scale',
        closeAnimation: 'scale',
        theme: 'dark',
        buttons: {
            okay: {
                text: 'Ok',
                btnClass: 'btn-blue'
            }
        }
    });
}

function loadItens() {
    var categoria = $('#filtroCategoria').val();
    var descricao = $('#filtroDescricao').val();
    var codigoBarras = $('#filtroCodigoBarras').val();
    var ativos = $('#filtroAtivo').is(':checked') ? 'S' : 'N';
    var inativos = $('#filtroInativo').is(':checked') ? 'S' : 'N';
    var pagina = $('#pagina').val();
    var primeiraPaginaPaginador = $('#primeiraPaginaPaginador').val();

    if (ativos == 'N' && inativos == 'N') {
        warning('Não posso pesquisar os itens com as duas únicas situações possíveis (ativo e inativo) desmarcadas.<br>. Por favor selecione pelo menos uma situação.');
        return;
    }
    $.ajax({
        method: "get",
        url: '/item.retrieveAll',
        data: {
            'categoria':categoria,
            'descricao':descricao,
            'codigoBarras':codigoBarras,
            'ativos':ativos,
            'inativos':inativos,
            'pagina':pagina,
            'primeiraPaginaPaginador':primeiraPaginaPaginador
        },
        success: function (data) {
            $('#content-body').html(data);
        }
    });

}


function loadCategorias() {
    var descricao = $('#filtroDescricao').val();
    var pagina = $('#pagina').val();
    var primeiraPaginaPaginador = $('#primeiraPaginaPaginador').val();

    $.ajax({
        method: "get",
        url: '/categoria.retrieveAll',
        data: {
            'descricao':descricao,
            'pagina':pagina,
            'primeiraPaginaPaginador':primeiraPaginaPaginador
        },
        success: function (data) {
            $('#content-body').html(data);
        }
    });

}

function loadUsuario() {
    var pagina = $('#pagina').val();
    var primeiraPaginaPaginador = $('#primeiraPaginaPaginador').val();

    $.ajax({
        method: "get",
        url: '/usuario.retrieveAll',
        data: {
            'pagina':pagina,
            'primeiraPaginaPaginador':primeiraPaginaPaginador
        },
        success: function (data) {
            $('#content-body').html(data);
        }
    });

}

function loadClientesOs() {
    var pagina = $('#pagina').val();
    var primeiraPaginaPaginador = $('#primeiraPaginaPaginador').val();

    $.ajax({
        method: "get",
        url: '/clientesOs.retrieveAll',
        data: {
            'pagina':pagina,
            'primeiraPaginaPaginador':primeiraPaginaPaginador
        },
        success: function (data) {
            $('#content-body').html(data);
        }
    });

}
function loadConfigBanco() {
    var pagina = $('#pagina').val();
    var primeiraPaginaPaginador = $('#primeiraPaginaPaginador').val();

    $.ajax({
        method: "get",
        
        url: '/configBanco.retrieveAll',
        data: {
            'pagina':pagina,
            'primeiraPaginaPaginador':primeiraPaginaPaginador
        },
        success: function (data) {
            $('#content-body').html(data);
        }
    });

}

function loadUnidade() {
    var pagina = $('#pagina').val();
    var primeiraPaginaPaginador = $('#primeiraPaginaPaginador').val();

    $.ajax({
        method: "get",
        
        url: '/unidade.retrieveAll',
        data: {
            'pagina':pagina,
            'primeiraPaginaPaginador':primeiraPaginaPaginador
        },
        success: function (data) {
            $('#content-body').html(data);
        }
    });

}

function loadOrdemServicos() {
    var pagina = $('#pagina').val();
    var primeiraPaginaPaginador = $('#primeiraPaginaPaginador').val();

    $.ajax({
        method: "get",
        
        url: '/ordemServico.retrieveAll',
        data: {
            'pagina':pagina,
            'primeiraPaginaPaginador':primeiraPaginaPaginador
        },
        success: function (data) {
            $('#content-body').html(data);
        }
    });

}

function loadTributo() {
    var pagina = $('#pagina').val();
    var primeiraPaginaPaginador = $('#primeiraPaginaPaginador').val();

    $.ajax({
        method: "get",
        
        url: '/tributo.retrieveAll',
        data: {
            'pagina':pagina,
            'primeiraPaginaPaginador':primeiraPaginaPaginador
        },
        success: function (data) {
            $('#content-body').html(data);
        }
    });

}

function habilitaFiltro() {
    if($('#div-sidebar-menu').width() > 100) {
        $('#div-filtro').hide();
    }else{
        $('#div-filtro').show();
    }
}


function selectImage() {
    return new Promise((resolve, reject) => {
      const input = document.createElement('input');
      input.type = 'file';
      input.accept = 'image/*';
  
      input.onchange = (event) => {
        const file = event.target.files[0];
        const reader = new FileReader();
  
        reader.onloadend = () => {
          const base64Data = reader.result;
          resolve(base64Data);
        };
  
        reader.onerror = (error) => {
          reject(error);
        };
  
        reader.readAsDataURL(file);
      };
  
      input.click();
    });
}

function loadImage(img, componente) {
    selectImage()
    .then((base64Data) => {
      $('#' + componente).val(base64Data);
      img.src = base64Data;
    })
    .catch((error) => {
      console.error('Erro ao selecionar imagem:', error);
    });
  
}

function toastAtivo() {
    return $('#snackbar').hasClass('show');
}
  
function toast(texto) {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar");
    $('#snackbar').html(texto);
    // Add the "show" class to DIV
    x.className = "show";
  
    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

function pesquisaItemPorCodigoDeBarras() {
    var codigoBarras = $('#CodigoBarras').val();
    $.ajax({
        method: "get",
        url: 'item.pesquisaPorCodigoBarras.' + codigoBarras,
        data: {            
        },
        success: function (data) {
            if (data.obj) {
                // Existe no banco
                // Dá mensagem e retorna para o campo de código de barras
                toast('Já tem um item cadastrado com esse código de barras: ' + data.obj.Descricao + '.');
                $('#CodigoBarras').focus();
                $('#CodigoBarras').select();
                return;
            }
            // Pesquisar no(s) banco(s) alternativo(s) - caso haja(m)
            // Pesquisar na API
            $.ajax({
                method: "get",
                url: 'http://alovasconcelos.com.br/gtin/?c=' + codigoBarras,
                data: {
                },
                success: function (data) {
                    if (data != '-1') {
                        $('#Descricao').val(data.Descricao);
                        $('#CodigoNCM').val(data.CodigoNCM);
                        $('#CodigoCest').val(data.CodigoCEST);
                        $('#CategoriaId').focus();
                    }
                    return;
                }
            });
                   
        }
    });
   
}

function xmlToJson(xml) {
    const obj = {};

    if (xml.nodeType == 1) {
        if (xml.attributes.length > 0) {
            obj['@attributes'] = {};
            for (let j = 0; j < xml.attributes.length; j++) {
                const attribute = xml.attributes.item(j);
                obj['@attributes'][attribute.nodeName] = attribute.nodeValue;
            }
        }
    } else if (xml.nodeType == 3) {
        obj['#text'] = xml.nodeValue.trim();
    }

    if (xml.hasChildNodes()) {
        for (let i = 0; i < xml.childNodes.length; i++) {
            const item = xml.childNodes.item(i);
            const nodeName = item.nodeName;

            if (typeof obj[nodeName] == 'undefined') {
                obj[nodeName] = xmlToJson(item);
            } else {
                if (typeof obj[nodeName].push == 'undefined') {
                    const old = obj[nodeName];
                    obj[nodeName] = [];
                    obj[nodeName].push(old);
                }

                obj[nodeName].push(xmlToJson(item));
            }
        }
    }

    return obj;
}

function alerta(texto, titulo = '') {
    $.alert({
        theme:'dark',
        title:titulo,
        content:texto
    });
}

function newToast(text, type = 'info', title = 'Atenção'){
    $(document).Toasts('create', {
        class: 'bg-' + type,
        title: title,
        body: text
    })
}

function strToFloat(valor) {
    return parseFloat(valor.replace(',', '.'));
}

function floatToStr(valor) {
    return valor.toString().replace('.', ',');
}

function setPage(page) {
    $('#pagina').val(page);
}

function setFirstPage(page) {
    $('#primeiraPaginaPaginador').val(page);
}

function editCategoria (id) {
    // incluir/alterar/excluir categoria
    $.confirm({
            title: 'Categoria',
            content: '' +
            '<form action="/categoria.ajaxStore" class="formName" id="formCategoria">' +
            '<input type="hidden" name="_token" value="{{ csrf_token() }}" />' +
            '<div class="form-group">' +
            '<label>Descrição</label>' +
            '<input type="text" class="name form-control" required name="DescricaoCategoria" />' +
            '</div>' +
            '</form>',
            theme: 'dark',
            buttons: {
                formSubmit: {
                    text: 'Salvar',
                    btnClass: 'btn-blue',
                    theme: 'dark',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if(!name){
                            $.alert('Informe a descrição da Categoria, por favor.');
                            return false;
                        }
                        $('#formCategoria').submit();   
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
        });
    }
});    
}

function dma(data) {
    const [dataParte, horaParte] = data.split(' ');
    const [ano, mes, dia] = dataParte.split('-');
    const [hora, minutos, segundos] = horaParte.split(':');
  
    return `${dia}/${mes}/${ano} ${hora}:${minutos}:${segundos}`;
}

function carregaVenda() {    
    $.ajax({
        method: "get",
        url: '/venda.carrega',
        data: {},
        success: function (data) {
            $('#content-body').html(data);
        }
    });
}

function cancelaItem() {
    
}

function cancelaVenda() {
    
}

function limiteNumeroTelefone(input) {
    const maxLength = 20; // Defina o limite máximo de dígitos
    if (input.value.length > maxLength) {
        input.value = input.value.slice(0, maxLength);
    }
}

function nomeClienteOs() {
    var clienteOs = $('#clienteOsId').val();
    $.ajax({
        
        method: "get",
        url: 'ordemServico.pesquisaCliente.' + clienteOsId,
        data: {            
        },
        success: function (data) {
            console.log(response);
            if (data.obj) {
                // Existe no banco
                $('#Telefone').val(data.Telefone);
                $('#Endereco').val(data.Endereco);
                $('#Empresa').val(data.Empresa);
        return;
            }
        }
    });
   
}
