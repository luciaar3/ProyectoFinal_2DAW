<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Crear tienda</h2>
    <form action="{{route('stores.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div>Nombre:</div>
        <input type="text" name="name"/><br>
        <div>Tipo:</div>
        <select name="type" id="type">
            <option value="fixed">Fijo</option>
            <option value="roaming">Ambulante</option>
        </select><br>
        <div>Descripción:</div>
        <input type="text" name="description"/><br>
        <div>Horarios:</div>
        <input type="text" name="schedules"/><br>
        <div>Ciudad:</div>
        <input type="text" name="city"/><br>
        <div>Número:</div>
        <input type="number" name="number"/><br>
        <div>Calle:</div>
        <input type="text" name="street"/><br>
        <div>Teléfono:</div>
        <input type="tel" name="phone"/><br>
        <div>Foto:</div>
        <input type="file" name="image"/><br>
        <input type="submit" id="submit"/>
        <br>
        @if ($errors->any())
            Hay errores en la vadilacion: <br>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        @endif
    </form>
</body>
</html>
