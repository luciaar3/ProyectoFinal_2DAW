@extends('layouts.layout')
@section('title', 'Notificaciones')
@section('content')
    <h1>Notificaciones recientes:</h1>
    <ul>
    @forelse ($notifications as $notification)
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
@endsection
