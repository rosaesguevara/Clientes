<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AppClientes</title>
</head>
<body>
    <?php 
        echo "<center><h3>Bienvenido a la API de consumo para clientes</h3></center>";
    ?>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Url</th>
                <th>Descripción</th>
                <th>Parametros que recibe</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <a href="http://127.0.0.1/api-clientes/api/municipio/list.php" target="_blank">
                        http://127.0.0.1/api-clientes/api/municipio/list.php
                    </a>
                </td>
                <td>Lista los municipios</td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <a href="http://127.0.0.1/api-clientes/api/tipoDocumento/list.php" target="_blank">
                        http://127.0.0.1/api-clientes/api/tipoDocumento/list.php
                    </a>
                </td>
                <td>Lista los tipos de documentos</td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <a href="http://127.0.0.1/api-clientes/api/cliente/list.php" target="_blank">
                        http://127.0.0.1/api-clientes/api/tipoDocumento/list.php
                    </a>
                    <br/>
                    <a href="http://127.0.0.1/api-clientes/api/cliente/list.php?idCliente=1" target="_blank">
                        http://127.0.0.1/api-clientes/api/tipoDocumento/list.php?idCliente=1
                    </a>
                </td>
                <td>Lista/obtiene cliente</td>
                <td>idCliente (para obtener un registro en especifico)</td>
            </tr>
            <tr>
                <td>
                    <a href="javascript:void(0)">
                        http://127.0.0.1/api-clientes/api/tipoDocumento/save.php
                    </a>
                </td>
                <td>Ingresa/actualiza cliente</td>
                <td>nombres, apellidos, idCliente (para modificar)</td>
            </tr>
        </tbody>
    </table>
    <style type="text/css">
        table {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border: 1px solid black;
        }
    </style>
</body>
</html>