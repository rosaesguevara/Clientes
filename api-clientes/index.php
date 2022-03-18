<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AppClientes</title>
</head>
<body>
    <center><h2>Documentacion de API de clientes</h2></center>
    <table>
        <thead>
            <tr>
                <th>Url</th>
                <th>Descripción</th>
                <th>Metodo</th>
                <th>Parametros que recibe</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                
                    <a href="http://127.0.0.1/Clientes/api-clientes/api/municipio/list.php" target="_blank">
                        http://127.0.0.1/Clientes/api-clientes/api/municipio/list.php
                    </a>
                </td>
                <td>Lista los municipios</td>
                <td>GET</td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <a href="http://127.0.0.1/Clientes/api-clientes/api/tipoDocumento/list.php" target="_blank">
                        http://127.0.0.1/Clientes/api-clientes/api/tipoDocumento/list.php
                    </a>
                </td>
                <td>Lista los tipos de documentos</td>
                <td>GET</td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <a href="http://127.0.0.1/Clientes/api-clientes/api/cliente/list.php" target="_blank">
                        http://127.0.0.1/Clientes/api-clientes/api/cliente/list.php
                    </a>
                    <br/>
                    <a href="http://127.0.0.1/Clientes/api-clientes/api/cliente/list.php?idCliente=1" target="_blank">
                        http://127.0.0.1/Clientes/api-clientes/api/cliente/list.php?idCliente=1
                    </a>
                </td>
                <td>Lista/obtiene cliente</td>
                <td>GET</td>
                <td>idCliente (para obtener un registro en especifico)</td>
            </tr>
            <tr>
                <td>
                    <a href="javascript:void(0)">
                        http://127.0.0.1/Clientes/api-clientes/api/cliente/save.php
                    </a>
                </td>
                <td>Ingresa/modifica cliente</td>
                <td>POST</td>
                <td>nombres, apellidos, idCliente (para modificar)</td>
            </tr>
            <tr>
                <td>
                    <a href="javascript:void(0)">
                        http://127.0.0.1/Clientes/api-clientes/api/cliente/delete.php
                    </a>
                </td>
                <td>Elimina cliente</td>
                <td>POST</td>
                <td>idCliente</td>
            </tr>
            <tr>
                <td>
                    <a href="http://127.0.0.1/Clientes/api-clientes/api/documento/list.php" target="_blank">
                        http://127.0.0.1/Clientes/api-clientes/api/documento/list.php
                    </a>
                    <br/>
                    <a href="http://127.0.0.1/Clientes/api-clientes/api/documento/list.php?idCliente=1" target="_blank">
                        http://127.0.0.1/Clientes/api-clientes/api/documento/list.php?idCliente=1
                    </a>
                    <br/>
                    <a href="http://127.0.0.1/Clientes/api-clientes/api/documento/list.php?idDocumento=1" target="_blank">
                        http://127.0.0.1/Clientes/api-clientes/api/documento/list.php?idDocumento=1
                    </a>
                </td>
                <td>Lista/obtiene documento</td>
                <td>GET</td>
                <td>
                	idCliente (para obtener los registros de un cliente)<br/>
                	idDocumento (para obtener un registro en especifico)
                </td>
            </tr>
            <tr>
                <td>
                    <a href="javascript:void(0)">
                        http://127.0.0.1/Clientes/api-clientes/api/documento/save.php
                    </a>
                </td>
                <td>Ingresa/modifica documento</td>
                <td>POST</td>
                <td>numeroDocumento, idCliente, idTipoDocumento, idDocumento (para modificar)</td>
            </tr>
            <tr>
                <td>
                    <a href="javascript:void(0)">
                        http://127.0.0.1/Clientes/api-clientes/api/documento/delete.php
                    </a>
                </td>
                <td>Elimina documento</td>
                <td>POST</td>
                <td>idDocumento</td>
            </tr>


            <tr>
                <td>
                    <a href="http://127.0.0.1/Clientes/api-clientes/api/direccion/list.php" target="_blank">
                        http://127.0.0.1/Clientes/api-clientes/api/direccion/list.php
                    </a>
                    <br/>
                    <a href="http://127.0.0.1/Clientes/api-clientes/api/direccion/list.php?idCliente=1" target="_blank">
                        http://127.0.0.1/Clientes/api-clientes/api/direccion/list.php?idCliente=1
                    </a>
                    <br/>
                    <a href="http://127.0.0.1/Clientes/api-clientes/api/direccion/list.php?idDireccion=1" target="_blank">
                        http://127.0.0.1/Clientes/api-clientes/api/direccion/list.php?idDireccion=1
                    </a>
                </td>
                <td>Lista/obtiene direccion</td>
                <td>GET</td>
                <td>
                	idCliente (para obtener los registros de un cliente)<br/>
                	idDireccion (para obtener un registro en especifico)
                </td>
            </tr>
            <tr>
                <td>
                    <a href="javascript:void(0)">
                        http://127.0.0.1/Clientes/api-clientes/api/direccion/save.php
                    </a>
                </td>
                <td>Ingresa/modifica direccion</td>
                <td>POST</td>
                <td>direccion, idCliente, idMunicipio, idDireccion (para modificar)</td>
            </tr>
            <tr>
                <td>
                    <a href="javascript:void(0)">
                        http://127.0.0.1/Clientes/api-clientes/api/direccion/delete.php
                    </a>
                </td>
                <td>Elimina direccion</td>
                <td>POST</td>
                <td>idDireccion</td>
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