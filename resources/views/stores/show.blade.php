<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <img src="/storage/{{$store->image}}" alt="Foto de {{$store->name}}" height="300px">
    <h2>{{$store->name}} (Mercado {{$store->type}})</h2>
    <div>{{$store->description}}</div>
    <div>Horarios: {{$store->schedules}}</div>
    <div>Ubicación: {{$store->city}}, {{$store->street}}, {{$store->number}}</div>
    <div>Contáctanos: {{$store->phone}}</div>
</body>
</html>
