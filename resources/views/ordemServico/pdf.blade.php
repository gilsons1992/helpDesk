
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordem de serviço</title>
    <style>
        @page{
            margin: 150px 50px ;
        }
        body{
            font-family: 'Verdana', sans-serif;
            margin:0px;
            padding:0px;
        }
        .header{
            position: fixed;
            left: 0;
            right:0;
            top: -100px;
            height: 200px;
            padding: 10px;
            background: #ffffff;
            margin-bottom:100px;
            text-align: center;
        }
        .header img{
            height: 200px;
        }
        .footer{
            position: fixed;
            left: 0;
            right:0;
            bottom:0;
            background: #333;
            color:#FFF;
            text-align: center;
            padding: 10px;
        }
        h1{
            text-align: center;
        }
        table{
            width: 100%;
            border:1px solid #000000;
            padding: 0px;
            margin-top: 100px;
        }
        table tr th {
            background: #ffffff;
            color:#000000;
            padding:5px;
            text-align: left;
        }
        table tr:nth-child(even) td{
            background: #ffffff;
        }
        .image{
            text-align: center;
        }
        .image img{
           border: 1px solid #000000;
            padding:3px;
            margin:5px;
        }
    </style>
</head>
<body>
 
<header class="header">
        <img src="<?php echo $pic ?>" />
</header>
 
<h1>Ordem de serviço</h1>

    <table>
        <tr>
            <th>Número da OS:</th>
            <td>{{$obj->Id}}</td>
        </tr>

        <tr>
            <th>Cliente:</th>
            <td>{{$obj->Cliente}}</td>
        </tr>

        <tr>
            <th>Diagnóstico:</th>
            <td>{{$obj->Diagnostico}}  </td>
        </tr>

        <tr>
            <th>Procedimento:</th>
            <td>{{$obj->Procedimento}}  </td>
        </tr>

        <tr>
            <th>Observação:</th>
            <td>{{$obj->Observacao}}  </td>
        </tr>
    </table>

    <table>

        <tr>
            <th>Valor do serviço:<th>{{$obj->TaxaServico}}</th></th>
        <tr>

        <tr>
            <th>Assinatura: <th>________________________________________________</th></th>
        <tr>
            
    </table>
     
<footer class="footer">
    Gerado em <?php echo (new DateTime())->format('d/m/Y    ')?>
</footer>
     
</body>
</html>