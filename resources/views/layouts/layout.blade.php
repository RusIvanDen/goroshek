<!DOCTYPE html>
<div lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ 'assets/css/style.css' }}" />
</head>
<body>
@yield('head')
<div class="wrapper">
    <header class="header">
        <div class="container">
            <div class="header__body">
                <div class="header__burger">
                    <span></span>
                </div>
                <nav class="header__menu">
                    <p class="header__logo">G<span class="blue">o</span>r<span class="blue">o</span>shek</p>
                    <ul class="header__list">
                        <li><a href="{{ route('index') }}" class="header__link">О нас</a></li>
                        <li><a href="{{ route('products') }}" class="header__link">Каталог</a></li>
                        <li><a href="{{ route('where') }}" class="header__link">Где нас найти</a></li>
                    </ul>
                    @guest()
                    <div class="header__button">
                        <ul class="header__links">
                            <li><a href="{{ route('login') }}" class="open-log"><button class="header__login">Вход</button></a></li>
                            <li><a href="{{ route('register') }}" class="open-reg"><button class="header__reg">Регистрация</button></a>
                            </li>
                        </ul>
                    </div>
                    @endguest
                    @auth()
                        <div class="nonadmin-butt">
                            <a href="{{ route('basket') }}"><button class="header__basket">Корзина</button></a>
                            <a href="{{ route('orders') }}"><button class="header__orders">Заказы</button></a>
                            <a href="{{ route('logout') }}"><button class="header__logout">Выход</button></a>
                        </div>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin') }}"><button class="header__admin">Админ Панель</button></a>
                        @endif
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <div class="message"></div>

    <main>
        @yield('content')
    </main>
    <script src="../../assets/js/norm.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ 'assets/js/index.js' }}"></script>
    <div class="pon">
        @yield('footer')
    </div>
</div>
    </body>

</div>
