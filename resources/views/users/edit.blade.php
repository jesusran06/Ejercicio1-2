@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Editar Usuario</div>
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="age" class="form-label">Edad</label>
                        <input type="number" 
                               class="form-control @error('age') is-invalid @enderror" 
                               id="age" 
                               name="age" 
                               value="{{ old('age', $user->age) }}" 
                               required>
                        @error('age')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña (solo si deseas cambiarla)</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="avatar" class="form-label">Avatar</label>
                        <select class="form-select @error('avatar') is-invalid @enderror" 
                                id="avatar" 
                                name="avatar" 
                                required>
                            <option value="avatar1.png" {{ $user->avatar === 'avatar1.png' ? 'selected' : '' }}>Avatar 1</option>
                            <option value="avatar2.png" {{ $user->avatar === 'avatar2.png' ? 'selected' : '' }}>Avatar 2</option>
                            <option value="avatar3.png" {{ $user->avatar === 'avatar3.png' ? 'selected' : '' }}>Avatar 3</option>
                        </select>
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
