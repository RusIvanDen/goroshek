<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    // регистрация
    public function register(Request $request) {
        if ($request->user) return redirect(route('index')); // если пользователь уже авторизован, то его перенаправит на главную страницу
        return view('register');
    }

    // авторизация
    public function login(Request $request) {
        if ($request->user) return redirect(route('index')); // если пользователь уже авторизован, то его перенаправит на главную страницу
        return view('login');
    }

    // обработка авторизации
    public function auth(Request $request) {
        $fields = Validator::make($request->all(),[ // валидация, 1 аргументом поля, которые были переданы, 2 аргументом описание правил
            'login' => 'required',
            'password' => 'required',
        ]);
        // есть ли ошибки валидации
        if ($fields->fails()) {
            return redirect(url()->previous()) // вернуться на прошлую страницу
            ->withErrors($fields) // вернуть ошибки валидации
            ->withInput(); // вернуть значения переданных полей, чтобы можно было пользоваться old() в blade
        }

        $login = $request->login;
        $password = $request->password;
        $user = User::where('login', '=', $login)
            ->where('password', $password) // можно 2 аргумент не передавать "=", это будет значить, что по дефолту ларавел будет подставлять =, если вам нужно <, > и тд то нужно передавать 2 аргумент
            ->first(); //вернет объект

        // если объект пустой
        if (!$user) {
            return redirect(url()->previous())
                ->withErrors(['error' => 'Неверный логин или пароль']) // своя ошибка
                ->withInput();
        }

        Auth::login($user); // создаем сессию с данными нашего пользователя
        return redirect(route('index'));
    }

    // обработка регистрации
    public function userCreate(Request $request) {
        // свои выводы ошибок, смотря какая ошибка в валидации, еще их можно менять тут - resources\lang\en\validation.php
        $messages = [
            'required' => 'Поле :attribute объязательно для заполнения',
        ];

        $request->merge(['id_role'=>1]); // добавим, что по дефолту роль клиент, можем в базе указать по дефолту, чтобы присваивался статус Клиент или в коде
        $data = $request->all();
        $fields = Validator::make($data,[
            'name' => 'required|regex:/[а-яА-Я\- ]/',
            'surname' => 'required|regex:/[а-яА-Я\- ]/',
            'patronymic' => 'nullable|regex:/[а-яА-Я\- ]/',
            'login' => 'required|unique:user,login|regex:/[a-zA-Z0-9\-]/',
            'email' => 'required|unique:user,email|email',
            'phone' => 'required',
            'password' => 'required|min:6',
            'password_repeat' => 'required',
        ], $messages);
        if ($fields->fails()) {
            return redirect(url()->previous())
                ->withErrors($fields)
                ->withInput();
        }
        if ($data['password'] !== $data['password_repeat']) {
            return redirect(url()->previous())
                ->withErrors(['error' => 'Пароли не совпадают'])
                ->withInput();
        }

        User::create($data);
        return redirect(route('login'))
            ->with(['msg' => 'Успешная регистрация']); // сохраняет данные в сессию и отправляет на страницу, будет храниться в session('msg'), после первого запуска, автоматически сообщение стирается
    }

    // обработка выхода
    public function logout(Request $request) {
        if ($request->user) Auth::logout();
        return redirect(route('index'));
    }
}
