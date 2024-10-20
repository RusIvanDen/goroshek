<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class WebController extends Controller
{
    // о нас
    public function index() {
        $products = DB::table('product')
            ->where('count_product', '>', 0)
            ->orderByDesc('id_product')
            ->limit(5)
            ->get();

        return view('index', [
            'products' => $products
        ]);
    }

    // где нас найти?
    public function where() {
        return view('where');
    }

    // 404
    public function notFoundPage() {
        return view('404');
    }

    // все товары
    public function products(Request $request) {
        // можно динамически формировать запрос)
        $products = DB::table('product')
            ->where('count_product', '>', 0);
        if ($request->category) $products = $products->where('id_category', $request->category);
        $products = $products->orderBy($request->sort ? $request->sort : 'id_product', $request->order ? $request->order : 'desc')
            ->get();

        $categories = DB::table('category')->get();

        // возможно можно оптимизировать
        if ($request->user) {
            foreach ($products as $product) {
                $inBasket = DB::table('basket')->where('id_user', $request->user['id_user'])->where('id_product', $product->id_product)->first();
                $product->inBasket = $inBasket ? true : false;
            }
        }

        return view('products', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    // отдельный товар
    public function product(Request $request, $id) {
        $product = DB::table('product')
            ->where('id_product', $id)
            ->first();
        if (!$product) return redirect(route('404'));

        $inBasket = false;
        if ($request->user) $inBasket = DB::table('basket')->where('id_user', $request->user['id_user'])->where('id_product', $id)->first();
        $product->inBasket = $inBasket ? true : false;

        return view('product', [
            'product' => $product
        ]);
    }

    // корзина
    public function basket(Request $request) {
        if (!$request->user) return redirect(route('index'));

        $productsBasket = DB::table('basket')
            ->where('id_user', $request->user['id_user'])
            ->join('product', 'product.id_product', '=', 'basket.id_product')
            ->get();

        return view('basket', [
            'productsBasket' => $productsBasket
        ]);
    }

    // обработка добавление в корзину товара
    public function addBasket(Request $request) {
        if (!$request->user) return redirect(route('index'));

        DB::table('basket')->insert([
            'id_user' => $request->user['id_user'],
            'id_product' => $request->id_product,
            'count_basket' => 1
        ]);

        return redirect(route('basket'));
    }

    // обработка удаление из корзины товара
    public function deleteBasket(Request $request) {
        if (!$request->user) return redirect(route('index'));

        DB::table('basket')
            ->where('id_user', $request->user['id_user'])
            ->where('id_product', $request->id_product)
            ->delete();

        return redirect(url()->previous());
    }

    // заказы
    public function orders(Request $request) {
        if (!$request->user) return redirect(route('index'));

        $orders = DB::select("SELECT * FROM `order` o
                                    JOIN order_product as op ON op.id_order = o.id_order
                                    JOIN product as p ON p.id_product = op.id_product
                                    JOIN status as s ON o.id_status = s.id_status
                                    WHERE o.id_user = ?
                                    ORDER BY o.id_order DESC
                                    ", [$request->user['id_user']]);

        $groupOrders = []; // группируем по id_order массивы
        foreach ($orders as $order) { // циклом проходим по исходному массиву – и собираем его элементы в новый массив, в котором ключами будут значения поля id_order:
            $groupOrders[$order->id_order][] = $order;
        }

        return view('orders', [
            'orders' => $groupOrders
        ]);
    }

    // удалить заказ
    public function deleteOrder(Request $request) {
        if (!$request->user) return redirect(route('index'));

        $id_order = $request->id_order;

        $order = DB::table('order')
            ->where('id_order', $id_order)
            ->where('id_user', $request->user['id_user'])
            ->where('id_status', 1)
            ->first();
        if (!$order) return redirect(route('index')); // нет доступа

        $order_product = DB::table('order_product')
            ->where('id_order', $id_order)
            ->get();

        foreach ($order_product as $item) {
            $product = DB::table('product')
                ->where('id_product', $item->id_product)
                ->first();
            DB::table('product')
                ->where('id_product', $product->id_product)
                ->update([
                    'count_product' => $product->count_product + $item->count_order
                ]);
        }

        DB::table('order_product')->where('id_order', $id_order)->delete();
        DB::table('order')->where('id_order', $id_order)->delete();

        return redirect(url()->previous());
    }

    // обработка добавление заказа
    public function addOrder(Request $request) {
        if (!$request->user) return redirect(route('index'));
        $id_user = $request->user['id_user'];

        // так же можно и доп. проверки делать на количество, на сумму и тд, если в ТЗ будет написано, т.к. на фронте можно изменить любые данные
        if ($request->password == $request->user['password']) {
            $id_products = $request->id_products;
            $sum_baskets = $request->sum_baskets;
            $count_baskets = $request->count_baskets;

            $id_order = DB::table('order')->insertGetId([
                'id_status' => 1, // Новый по умолчанию при создании заказа
                'id_user' => $id_user,
                'sum_order' => array_sum($sum_baskets)
            ]);

            for ($i = 0; $i < count($id_products); $i++) { // перебираем полученные массива с формы
                $product = DB::table('product')->where('id_product', $id_products[$i])->first();
                DB::table('product')->where('id_product', $product->id_product)->update([
                    'count_product' => $product->count_product - $count_baskets[$i] // можно так же добавить проверку, если результат вычитания <= 0, то выыводить сообщение такого то товара нету на складе, но мы эти првоерки добавили на фронте, что не безопасно, поэтому, если в ТЗ будет сказано проверить еще и на беке, то добавите проверку
                ]);

                DB::table('order_product')->insert([
                    'id_order' => $id_order,
                    'id_product' => $id_products[$i],
                    'count_order' => $count_baskets[$i]
                ]);

                DB::table('basket')->where('id_user', $id_user)->where('id_product', $id_products[$i])->delete();
            }

            return redirect(route('orders'));
        }
        return redirect(url()->previous())
            ->with(['msg' => 'Пароль неверный']); // если введеный пароль не совпадает с текущим
    }
}
