<?php
use App\Models\User;

$users = User::all();
?>

@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Usuarios</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo Usuario</a>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Avatar</th>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    <img src="{{ asset('images/avatars/' . $user->avatar) }}" 
                         alt="{{ $user->name }}" 
                         class="rounded-circle" 
                         style="width: 40px; height: 40px; object-fit: cover;">
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->age }}</td>
                <td>
                    <div class="btn-group gap-2">
                        <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
