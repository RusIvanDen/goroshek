<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class AdminController extends Controller
{
    // дефолт страница, если роль не админ
    private function defaultPage() {
        return redirect(route('404'));
    }

    // проверяем админ ли
    private function checkAdmin($request) {
        return $request->user && $request->user->isAdmin();
    }

    // админ панель
    public function admin(Request $request) {
        if ($this->checkAdmin($request)) {
            $categories = DB::table('category')->get(); // или так DB::select("SELECT * FROM category;")

            if ($request->status) {
                $orders = DB::select("SELECT * FROM `order` o
                                    JOIN order_product as op ON op.id_order = o.id_order
                                    JOIN user as u ON u.id_user = o.id_user
                                    JOIN product as p ON p.id_product = op.id_product
                                    JOIN status as s ON o.id_status = s.id_status
                                    WHERE s.id_status = ?
                                    ORDER BY o.id_order DESC
                                    ", [$request->status]);
            } else {
                $orders = DB::select("SELECT * FROM `order` o
                                    JOIN order_product as op ON op.id_order = o.id_order
                                    JOIN user as u ON u.id_user = o.id_user
                                    JOIN product as p ON p.id_product = op.id_product
                                    JOIN status as s ON o.id_status = s.id_status
                                    ORDER BY o.id_order DESC
                                    ");
            }

            $groupOrders = []; // группируем по id_order массивы
            foreach ($orders as $order) { // циклом проходим по исходному массиву – и собираем его элементы в новый массив, в котором ключами будут значения поля id_order:
                $groupOrders[$order->id_order][] = $order;
            }

            $statuses = DB::table('status')->get();

            return view('admin', [
                // передаем данные на страницу в ввиде ассоциативного массива, вызывается так $mass['key']
//                'categories' => json_decode(json_encode($categories, JSON_UNESCAPED_UNICODE), true),
                // передаем данные на страницу в ввиде stdClass, вызывается так $mass->key
                'categories' => $categories,
                'orders' => $groupOrders,
                'statuses' => $statuses
            ]);
        };
        return $this->defaultPage();
    }

    // обработка добавление категории
    public function addCategory(Request $request) {
        if ($this->checkAdmin($request)) {
            $data = $request->all();
            // можно не добавлять валидацию и можно оставить ее на фронте, если в ТЗ про это ничего не сказано)
//            $fields = Validator::make($data,[
//                'name_category' => 'required',
//            ]);
//            if ($fields->fails()) {
//                return redirect(url()->previous())
//                    ->withErrors($fields);
//            }

            DB::table('category')->insert([
                'name_category' => $data['name_category']
            ]); // или так DB::insert("INSERT INTO `category` (`name_category`) VALUES (?);", [$data['name_category']]);

            return redirect(url()->previous().'#categories')
                ->with(['msgForCategory' => 'Категория добавлена']);
        }
        return $this->defaultPage();
    }

    // обработка удаление категории
    public function deleteCategory(Request $request) {
        if ($this->checkAdmin($request)) {
            // возможно здесь нужна будет, какая-то проверка, например если эта категория уже используется и ее удалить нельзя, или если найдены товары, то удалить все товары с этой категорией и тд
            $id_category = $request->id_category;

            $checkProduct = DB::table('product') // пример проверки, если нужно проверить, что категория не используется
            ->where('id_category', $id_category)
                ->first();
            if ($checkProduct) return redirect(url()->previous().'#categories')->with(['msgForCategory' => 'Категория уже используется в товаре - '.route('product', ['id' => $checkProduct->id_product])]);

            DB::table('category')->where('id_category', $id_category)->delete();
            return redirect(url()->previous().'#categories')
                ->with(['msgForCategory' => 'Категория удалена']);
        }
        return $this->defaultPage();
    }

    // обработка добавление товара
    public function addProduct(Request $request) {
        if ($this->checkAdmin($request)) {
            // про валидацию ничего не сказано в ТЗ, но если ее напишут, нужно будет добавить), ниже пример валидации файла
//            $fields = Validator::make($request->all(),[
//                'image' => 'required|mimes:jpg,png|max:10240', // обязательный, макс 10 мбайт файл с расширением png, jpg
//            ]);
//            if ($fields->fails()) {
//                return redirect(url()->previous())
//                    ->withErrors($fields)
//                    ->withInput();
//            }

            // можем валидировать и по другому
//            if (!$img) {
//                return redirect(url()->previous())
//                    ->withErrors(['errorForImg' => 'Картинка не выбрана'])
//                    ->withInput();
//            }
//            if ($img->getSize() > 5000000) { // проверяем на размер, если больше 5МБ, то ошибку посылаем
//                return redirect(url()->previous())
//                    ->withErrors(['errorForImg' => 'Картинка должна иметь размер не более 5МБ'])
//                    ->withInput();
//            }

//            $typeImg = ""; // зададим расширение для картинки
//            switch ($img->extension()) {
//                case 'jpg':
//                case 'jpeg':
//                    $typeImg = 'jpeg';
//                    break;
//                case 'png':
//                    $typeImg = 'png';
//                    break;
//                case 'gif':
//                    $typeImg = 'gif';
//                    break;
//                default:
//                    return redirect(url()->previous())
//                        ->withErrors(['errorForImg' => 'Расширение картинки должно быть jpg, jpeg, png или gif'])
//                        ->withInput();
//            }

            // код на случай динамических полей в форме и у нас вместо характеристик для каждого поля, одно полей в формате json
//            $body = $request->except(['_token', 'name_product', 'id_category', 'image', 'user']); // удалить лишние поля, например, если мы добавим в наш html-форму новое поле, оно будет автоматом добавлятся в базу, без изменения этого кода)
//            $body = json_encode($body, JSON_UNESCAPED_UNICODE);
            // {
            //    "year": "2001",
            //    "count": "23",
            //    "model": "Das",
            //    "price": "234",
            //    "country": "Греция"
            //}

            // для того, чтобы получить доступ к загруженной картинке нужено выполнить одно из 3 действий:
            // если нету консоли на сервере, можно вставить php код, чтоб он выполнился - symlink('/home/username/projectname/storage/app/public', '/home/username/public_html/storage')
            // если есть доступ к cmd, то: php artisan storage:link
            // доступ через ssh: ln -s /path/to/laravel/storage/avatars /path/to/laravel/public/avatars
            // нужно будет узнать, какой сервер будет - https://techarks.ru/qa/laravel/laravel-5-kak-poluchit-dos-RC/
            // еще нужно учесть, что если проект был запакован в архив, то символическая ссылка удаляется и вместо нее создается папка с вашими файлами
            // в общем нашел способ, который будет перемещать загруженный файл в папку public, но на практике лучше в папку storage перемещать

            $img = $request->file('image'); // получили файл
            $typeImg = $img->extension(); // взяли расширение

            $uniqName = md5(uniqid(rand(), true)); // уникальное название для нашего файла в файловой системе
            $nameImg = $uniqName.'.'.$typeImg;
            $pathFolder = 'images/products/';
            if (!$img->move(public_path($pathFolder), $nameImg)) { // сохранить картинку в public\image\products
                return redirect(url()->previous())
                    ->withErrors(['errorForImg' => 'Что-то пошло не так, картинка не может загрузиться на сервер'])
                    ->withInput();
            }


            $pub = 'public/';


            $path = $pathFolder.$nameImg;
            DB::table('product')->insert([
                'id_category' => $request->id_category,
                'name_product' => $request->name_product,
                'price_product' => $request->price_product,
                'brand_product' => $request->brand_product,
                'count_product' => $request->count_product,
                'path_product' => $request->path_product,
                'path_product' => $pub.$path,
                'mechanism_product' => $request->mechanism_product,
                'weight' => $request->weight,
                'size' => $request->size,
                'color' => $request->color,
                'info' => $request->info,
            ]);

            return redirect(url()->previous().'#addFormProduct') // сразу покажет форму с добавлением товара по id, который указан у тега формы
            ->with(['msgForProduct' => 'Товар успешно добавлен']);
        }
        return $this->defaultPage();
    }

    // изменение товара
    public function changeProductPage(Request $request, $id) {
        if ($this->checkAdmin($request)) {
            $product = DB::table('product')
                ->where('id_product', $id)
                ->first();
            if (!$product) return $this->defaultPage();

            $categories = DB::table('category')->get();

            return view('changeProduct', [
                'product' => $product,
                'categories' => $categories
            ]);
        }
        return $this->defaultPage();
    }

    // обработка изменение товара
    public function changeProduct(Request $request) {
        if ($this->checkAdmin($request)) {
            $id_product = $request->id_product;
            $product = DB::table('product')
                ->where('id_product', $id_product)
                ->first();
            if (!$product) return $this->defaultPage();

            // тут можно так же добавить валидацию, если нужно будет по ТЗ

            $img = $request->file('image');
            $path = '';
            if ($img) {
                unlink('../'.$product->path_product); // удаляем старый файл с картинкой
                $typeImg = $img->extension();
                $uniqName = md5(uniqid(rand(), true)); // уникальное название для нашего файла в файловой системе
                $nameImg = $uniqName.'.'.$typeImg;
                $pathFolder = 'images/products/';
                if (!$img->move(public_path($pathFolder), $nameImg)) { // сохранить картинку в public\image\products
                    return redirect(url()->previous())
                        ->withErrors(['errorForImg' => 'Что-то пошло не так, картинка не может загрузиться на сервер'])
                        ->withInput();
                }
                $path = $pathFolder.$nameImg;
            }

            DB::table('product')->where('id_product', $id_product)->update([
                'id_category' => $request->id_category ? $request->id_category : $product->id_category,
                'name_product' => $request->name_product ? $request->name_product : $product->name_product,
                'price_product' => $request->price_product ? $request->price_product : $product->price_product,
                'brand_product' => $request->brand_product ? $request->brand_product : $product->brand_product,
                'count_product' => $request->count_product ? $request->count_product : $product->count_product,
                'path_product' => $request->path_product ? $request->path_product : $product->path_product,
                'path_product' =>  $img ? 'public/'.$path : $product->path_product,
                'mechanism_product' => $request->mechanism_product ? $request->mechanism_product : $product->mechanism_product,
                'weight' => $request->weight ? $request->weight : $product->weight,
                'size' => $request->size ? $request->size : $product->size,
                'color' => $request->color ? $request->color : $product->color,
                'info' => $request->info ? $request->info : $product->info,
            ]);

            return redirect(url()->previous())
                ->with(['msgForProduct' => 'Товар успешно изменен']);
        }
        return $this->defaultPage();
    }

    // обработка удаления товара
    public function deleteProduct(Request $request) {
        if ($this->checkAdmin($request)) {
            $id_product = $request->id_product;
            $product = DB::table('product')
                ->where('id_product', $id_product)
                ->first();
            if (!$product) return $this->defaultPage();

            unlink('../'.$product->path_product);
            DB::table('product')->where('id_product', $id_product)->delete();

            return redirect(route('products'));
        }
        return $this->defaultPage();
    }

    // изменение статуса заказа
    public function changeStatusOrder(Request $request) {
        if ($this->checkAdmin($request)) {
            $id_status= $request->id_status;
            $id_order= $request->id_order;
            $reason_order= $request->reason_order;

            if ($reason_order) {
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

                DB::table('order')
                    ->where('id_order', $id_order)
                    ->update([
                        'id_status' => $id_status,
                        'reason_order' => $reason_order
                    ]);
            } else {
                DB::table('order')
                    ->where('id_order', $id_order)
                    ->update([
                        'id_status' => $id_status
                    ]);
            }

            return redirect(route('admin').'#ordersAll');
        }
        return $this->defaultPage();
    }
}
