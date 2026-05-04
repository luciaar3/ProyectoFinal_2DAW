@extends('layouts.layout')
@section('title', 'Foros')
@section('content')
<div class="container mt-5 text-center">
    <h1>Foros disponibles:</h1>
    <ul>
    @forelse ($forums as $foros)
        <li>
        <h3>{{$notification->title}}</h3>
        <p>{{$notification->message}}</p>
        <form action="{{route('notifications.destroy', $notification)}}" method="post">
            @csrf
            @method('delete')
        <input type="submit" value="Eliminar notificación">
        </form>
        </li>
    @empty
        No hay notificaciones
    @endforelse
    </ul>
</div>
@endsection
