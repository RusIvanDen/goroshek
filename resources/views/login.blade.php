@extends('layouts.layout')

@section('head')
    <title>Авторизация</title>
@endsection

@section('content')
    <div class="content">
        <div class="reg__bg">
            <div class="reg__inf">
                <form action="{{ route('auth') }}" method="post" class="reg">
                    <h2>Авторизация</h2>
                    @csrf
                    <input type="text" placeholder="Логин" name="login" value="{{ old('login') ?? '' }}" class="reg__input reg__login" onchange="reg4()"/>
                    @error('login')
                    <div class="error">
                        {{ $message }}
                    </div>
                    @enderror
                    <input type="password" placeholder="Пароль" name="password" class="reg__input reg__password" onchange="reg6()"/>
                    @error('password')
                    <div class="error">
                        {{ $message }}
                    </div>
                    @enderror
                    @error('error')
                    <div class="error">
                        {{ $message }}
                    </div>
                    @enderror
                    <div class="error">{{ session('msg') }}</div>
                    <button type="submit">Войти</button>
                </form>
            </div>
        </div>
    </div>
@endsection

