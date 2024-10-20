@extends('layouts.layout')
@section('head')
    <title>Регистрация</title>
@endsection
@section('content')
    <div class="content">
        <div class="reg__bg">
            <div class="reg__inf">
            <form action="{{ route('userCreate') }}" method="post" class="reg">
                <h2>Регистрация</h2>
                @csrf
                <input type="checkbox" name="rules" required class="part-checkbox"/>
                <p class="p_cherniy">Согласие с правилами регистрации</p>
                <input type="text" placeholder="Имя" name="name" value="{{ old('name') ?? '' }}" class="reg__input reg__name" onchange="reg1()"/>
                <input type="text" placeholder="Фамилия" name="surname" value="{{ old('surname') ?? '' }}" class="reg__input reg__surname" onchange="reg2()"/>
                <input type="text" placeholder="Отчество" name="patronymic" value="{{ old('patronymic') ?? '' }}" class="reg__input reg__patronymic" onchange="reg3()"/>
                <input type="text" placeholder="Логин" name="login" value="{{ old('login') ?? '' }}" class="reg__input reg__login" onchange="reg4()"/>
                <input type="email" placeholder="Email" name="email" value="{{ old('email') ?? '' }}" class="reg__input reg__email" onchange="reg5()"/>
                <input type="number" placeholder="Телефон" name="phone" value="{{ old('phone') ?? '' }}" class="reg__input reg__phone" onchange="reg8()"/>
                <input type="password" placeholder="Пароль" name="password" class="reg__input reg__password" onchange="reg6()"/>
                <input type="password" placeholder="Повтор пароля" name="password_repeat" class="reg__input reg__password2" onchange="reg7()"/>
                <button type="submit">Зарегистрироваться</button>
                <div class="error">
                @if ($errors->any())
                    @foreach($errors->all() as $error)
                        {{ $error }} <br>
                    @endforeach
                @endif
                </div>
        </form>
        </div>
        </div>
    </div>
@endsection

