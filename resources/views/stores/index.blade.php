<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Index provisional</h2>
    <a href="{{route('stores.create')}}">Crear tienda</a>
    <ul>
    @forelse ($stores as $store)
        <li><a href="{{route('stores.show', $store)}}">{{$store->name}}</a></li>
        @isadmin()
            <a href="{{route('stores.edit', $store)}}">Modificar tienda</a>
            <form action="{{route('stores.destroy', $store)}}" method="post">
                @csrf
                @method('delete')
            <input type="submit" value="Eliminar tienda">
        @else
        @endisadmin
    @empty
    @endforelse
    </ul>
</body>
</html>
