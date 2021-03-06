<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Productos</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>CODIGO</th>
        <th>NOMBRE</th>
        <th>DESCRIPCION</th>
        <th>TIPO</th>
        <th>UNIDA DE MEDIDA</th>
        <th>PRECIO DE COMPRA</th>
        <th>PRECIO DE VENTA</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product['code'] }}</td>
            <td>{{ $product['name'] }}</td>
            <td>{{ $product['description'] }}</td>
            <td>{{ $product['type'] }}</td>
            <td>{{ $product['measure'] }}</td>
            <td>{{ $product['price']}}</td>
            <td>{{ $product['sale_price']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

