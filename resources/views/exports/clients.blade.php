<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$type}}</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>EMPRESA</th>
        <th>NOMBRE</th>
        <th>EMAIL</th>
        <th>TELEFONO</th>
        <th>DIRECCION</th>
        <th>OBSERVACIONES</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td>{{ $item->company }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->phone }}</td>
            <td>{{ $item->note }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

