<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IDIOMES</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($idiomes as $idioma)
    <tr>
        <td>{{ $idioma->ID_IDIOMA }}</td>
        <td>{{ $idioma->NOM_IDIOMA }}</td>
    </tr>
    @endforeach
    </tbody>
</table>


</body>
</html>
<?php
