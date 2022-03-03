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
        </tbody>
    </table>
</body>
</html>