@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ asset('images/avatars/' . $user->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        <h4 class="mt-3">{{ $user->name }}</h4>
                        <div class="mt-3">
                            <div class="mb-2">
                                <strong>Edad:</strong> {{ $user->age }} años
                            </div>
                            <div class="mb-2">
                                <strong>Fecha de Registro:</strong> {{ $user->created_at->format('d/m/Y') }}
                            </div>
                            <div class="mb-2">
                                <strong>Última Actualización:</strong> {{ $user->updated_at->format('d/m/Y') }}
                            </div>
                            <div class="mb-2">
                                <strong>Avatar:</strong> {{ $user->avatar }}
                            </div>
                        </div>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary w-100 mt-3">Editar Perfil</a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="mb-4">Amigos</h4>
                        @if($friends->isEmpty())
                            <p class="text-muted">No tienes amigos aún.</p>
                        @else
                            <div class="row">
                                @foreach($friends as $friend)
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <img src="{{ asset('images/avatars/' . $friend->avatar) }}" alt="{{ $friend->name }}" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                                <h5 class="mt-3">{{ $friend->name }}</h5>
                                                <p class="text-muted">{{ $friend->age }} años</p>
                                                <form action="{{ route('users.removeFriend', ['user' => $user->id]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="friend_id" value="{{ $friend->id }}">
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar a {{ $friend->name }} de tus amigos?')">Eliminar Amigo</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-4">Añadir Amigo</h4>
                        @if($potentialFriends->isEmpty())
                            <p class="text-muted">No hay usuarios disponibles para añadir como amigos.</p>
                        @else
                            <div class="row">
                                @foreach($potentialFriends as $potentialFriend)
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <img src="{{ asset('images/avatars/' . $potentialFriend->avatar) }}" alt="{{ $potentialFriend->name }}" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                                <h5 class="mt-3">{{ $potentialFriend->name }}</h5>
                                                <p class="text-muted">{{ $potentialFriend->age }} años</p>
                                                <form action="{{ route('users.addFriend', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="friend_id" value="{{ $potentialFriend->id }}">
                                                    <button type="submit" class="btn btn-primary btn-sm">Añadir Amigo</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
