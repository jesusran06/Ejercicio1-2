<?php
use App\Models\User;

$user = User::findOrFail($user->id);
?>

@extends('layouts.app')

@section('title', $user->name)

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ asset('images/avatars/' . $user->avatar) }}" 
                     alt="{{ $user->name }}" 
                     class="rounded-circle" 
                     style="width: 150px; height: 150px; object-fit: cover;">
                <h3 class="mt-3">{{ $user->name }}</h3>
                <p class="text-muted">Edad: {{ $user->age }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Amigos</div>
            <div class="card-body">
                <div class="row">
                    @foreach($user->friends as $friend)
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="{{ asset('images/avatars/' . $friend->avatar) }}" 
                                     alt="{{ $friend->name }}" 
                                     class="rounded-circle" 
                                     style="width: 80px; height: 80px; object-fit: cover;">
                                <h6 class="mt-2">{{ $friend->name }}</h6>
                                <p class="text-muted">{{ $friend->age }} años</p>
                                <form action="{{ route('users.removeFriend', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{ $friend->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta amistad?')">
                                        Eliminar Amistad
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if($user->friends->isEmpty())
                        <p class="text-muted">Este usuario no tiene amigos aún.</p>
                    @endif


</div>
@endsection
