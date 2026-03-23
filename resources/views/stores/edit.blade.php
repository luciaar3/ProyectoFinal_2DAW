<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Editar tienda</h2>
    <form action="{{route('stores.update', $store)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>Nombre:</div>
        <input type="text" name="name" value="{{$store->name}}"><br>
        <div>Tipo:</div>
        <select name="type" id="type" value="{{$store->type}}">
            <option value="fixed">Fijo</option>
            <option value="roaming">Ambulante</option>
        </select><br>
        <div>Descripción:</div>
        <input type="text" name="description" value="{{$store->description}}"><br>
        <div>Horarios:</div>
        <input type="text" name="schedules" value="{{$store->schedules}}"><br>
        <div>Ciudad:</div>
        <input type="text" name="city" value="{{$store->city}}"><br>
        <div>Número:</div>
        <input type="number" name="number" value="{{$store->number}}"><br>
        <div>Calle:</div>
        <input type="text" name="street" value="{{$store->street}}"><br>
        <div>Teléfono:</div>
        <input type="tel" name="phone" value="{{$store->phone}}"><br>
        <div>Foto:</div>
        <input type="file" name="image" value="{{$store->image}}"><br>
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
