<?php

use App\Http\Controllers\AdminController; // контроллер для админ панели
use App\Http\Controllers\UserController; // контроллер, связанный с авторизацией, регистрацией и сессией
use App\Http\Controllers\WebController; // общий контроллер для всего остального (можно и его разделить на несколько контроллеров по логике)
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// страницы, которым не нужны сведения о пользователе
Route::get('/', [WebController::class, 'index'])->name('index'); // о нас
Route::get('/where', [WebController::class, 'where'])->name('where'); // где нас найти?
Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product');


// страницы, к ним из middleware будет приходить информация о пользователе, которая будет в сессии
// middleware это промежуточные файлы (т.е. код будет выполняться после запроса к url, но до вызова функции в контроллере), которые нужны к примеру для проверки авторизован ли пользователь или нет, если да то открывает страницу, в нашем случае будет использовать middleware, как получения данных о пользовательской сессии и внутри констроллера в функциях будем проверять, админ это, авторизован ли он и тд
Route::middleware('getUser')->group(function () {
    Route::get('/register', [UserController::class, 'register'])->name('register'); // регистрация
    Route::get('/login', [UserController::class, 'login'])->name('login'); // авторизация
    Route::post('/auth', [UserController::class, 'auth'])->name('auth'); // обработка авторизации
    Route::post('/user/create', [UserController::class, 'userCreate'])->name('userCreate'); // обработка регистрации
    Route::match(['get', 'post', 'delete'],'/logout', [UserController::class, 'logout'])->name('logout'); // обработка выхода

    Route::get('/orders', [WebController::class, 'orders'])->name('orders'); // заказы
    Route::post('/order', [WebController::class, 'addOrder'])->name('addOrder'); // добавление заказа
    Route::delete('/order', [WebController::class, 'deleteOrder'])->name('deleteOrder'); // удаление заказа
    Route::patch('/order/status', [AdminController::class, 'changeStatusOrder'])->name('changeStatusOrder'); // изменение статуса заказа

    Route::get('/admin', [AdminController::class, 'admin'])->name('admin'); // админ панель

    Route::post('/category', [AdminController::class, 'addCategory'])->name('addCategory'); // обработка добавление категории
    Route::delete('/category', [AdminController::class, 'deleteCategory'])->name('deleteCategory'); // обработка удаление категории

    Route::get('/products', [WebController::class, 'products'])->name('products'); // все товары
    Route::get('/product/{id}', [WebController::class, 'product'])->name('product'); // отдельный товар
    Route::post('/product', [AdminController::class, 'addProduct'])->name('addProduct'); // обработка добавление товара
    Route::get('/product/change/{id}', [AdminController::class, 'changeProductPage'])->name('changeProductPage'); // изменение товара
    Route::patch('/product', [AdminController::class, 'changeProduct'])->name('changeProduct'); // обработка изменение товара
    Route::delete('/product', [AdminController::class, 'deleteProduct'])->name('deleteProduct'); // обработка удаление товара

    Route::get('/basket', [WebController::class, 'basket'])->name('basket'); // корзина
    Route::post('/basket', [WebController::class, 'addBasket'])->name('addBasket'); // обработка добавление товара в корзину
    Route::delete('/basket', [WebController::class, 'deleteBasket'])->name('deleteBasket'); // обработка удаление товара из корзины
});

// откроется страница 404, если ни один uri не был найден выше https://riptutorial.com/laravel/example/5583/catch-all-routes
Route::get('/404', [WebController::class, 'notFoundPage'])->name('404'); // 404 страница
Route::get('/{any}', [WebController::class, 'notFoundPage'])->where('any', '.*');
