@extends('layouts.layout')

@section('head')
    <title>Админ панель</title>
@endsection

@section('content')
    <div class="content admin-content">
        <p style="margin-bottom: 20px">
            <a class="sort-adm" href="{{ route('admin') }}">{!! !request('status') ? "<b>Все</b>" : "Все" !!} |</a>
            @foreach($statuses as $status)
                <a class="sort-adm" href="{{ route('admin', ['status' => $status->id_status]) }}">{!! request('status') == $status->id_status ? "<b>$status->name_status</b>" : $status->name_status !!}</a> {{ !$loop->last ? '|' : '' }}
            @endforeach
        </p>

        @if(count($orders) > 0)
            @foreach($orders as $idOrder => $order)
                @php($totalCount = 0)
                @foreach($order as $product)
                    @php($totalCount += $product->count_order)
                @endforeach
                <div class="wrap">
                    <div class="row">
                        <h2>Заказ {{ $order[0]->id_order }}</h2>
                    </div>
                    <div class="row">
                        <p>Заказчик: <b>{{ "{$order[0]->surname} {$order[0]->name} {$order[0]->patronymic}" }}</b></p>
                        <p>Статус: <b>{{ $order[0]->name_status }}</b></p>
                        <p>Количество товаров: <b>
                                {{ $totalCount }}
                            </b></p>
                        <p>Общая стоимость: <b>
                                {{ $order[0]->sum_order }}
                                руб.</b></p>
                    </div>
                    @if($order[0]->reason_order)
                        <div class="row">
                            <p>Причина отмены:</p>
                            <p><b>{{ $order[0]->reason_order }}</b></p>
                        </div>
                    @endif
                    <hr>
                    <div class="row">
                        @foreach($order as $product)
                            <div class="col col-orders">
                                <div class="row">
                                    <h3><a target="_blank" href="{{ route('product', ['id' => $product->id_product]) }}">{{ $product->name_product }}</a></h3>
                                    <p>{{ $product->price_product }} руб.</p>
                                </div>
                                <div class="row">
                                    <p>Количество:</p>
                                    <b>{{ $product->count_order }}</b>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>

                    @if($order[0]->id_status == 1)
                        <form action="{{ route('changeStatusOrder') }}" class="w100" method="post">
                            @csrf
                            @method("PATCH")
                            <input type="hidden" name="id_order" value="{{ $idOrder }}">
                            <input type="hidden" name="id_status" value="2">
                            <button class="admin-order" type="submit">Подтвердить заказ</button>
                        </form>
                        <br>
                    @endif

                    @if($order[0]->id_status == 1 || $order[0]->id_status == 2)
                        <h3 class="text-center">Отменить заказ</h3>
                        <form action="{{ route('changeStatusOrder') }}" class="w100" method="post">
                            @csrf
                            @method("PATCH")
                            <textarea name="reason_order" placeholder="Причина отмены" required></textarea>
                            <input type="hidden" name="id_order" value="{{ $idOrder }}">
                            <input type="hidden" name="id_status" value="3">
                            <button class="admin-order-delete" type="submit" style="margin:0">Отменить заказ</button>
                        </form>
                    @endif

                    @if($order[0]->id_status == 3)
                        <h3 class="text-center">Причина отмены:</h3>
                        <p class="reason">{{ $order[0]->reason_order }}</p>
                    @endif

                    <p class="text-small text-right">Отправили {{ date('d.m.Y в H:i:s', strtotime($order[0]->created_at)) }}</p>
                </div><br>
            @endforeach
        @else
            <div>Заказы не найдены</div>
        @endif


        <form action="{{ route('addCategory') }}" method="post">
{{--            <div class="head categ" id="categories">Категории</div>--}}
            @csrf
            <div class="part admin-add">
                <input type="text" placeholder="Название категории" name="name_category" required class="input-pass">
                <button>Добавить</button>
            </div>
        </form>
        <form action="{{ route('deleteCategory') }}" method="post">
            @csrf
            {{--        замедьте мы указали метод post в html форме, но на самом деле у нас метод delete для laravel    --}}
            @method('DELETE')
            <div class="part admin-add">
                <select name="id_category" required class="input-pass">
                    <option value selected disabled>Категории</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id_category }}">{{ $category->name_category }}</option>
                    @endforeach
                </select>
                <button>Удалить</button>
            </div>
        </form>
        {{ session('msgForCategory') }}

{{--        <div class="head" id="addFormProduct">Добавить товар</div>--}}
        <form action="{{ route('addProduct') }}" method="POST" enctype="multipart/form-data" class="admin-add">
            @csrf
            <input class="reg__input" type="text" placeholder="Название" name="name_product" required class="input-pass">
            <input class="reg__input" type="number" placeholder="Цена" name="price_product" required class="input-pass">
            <input class="reg__input" type="text" placeholder="Бренд" name="country_product" required class="input-pass">
            <input class="reg__input" type="number" placeholder="Количество" name="price_product" required class="input-pass">
            <input class="reg__input" type="text" placeholder="Путь на сервере" name="country_product" required class="input-pass">
            <input class="reg__input" type="text" placeholder="Механизм" name="country_product" required class="input-pass">
            <input class="reg__input" type="number" placeholder="Вес" name="price_product" required class="input-pass">
            <input class="reg__input" type="number" placeholder="Размер" name="price_product" required class="input-pass">
            <input class="reg__input" type="text" placeholder="Цвет" name="country_product" required class="input-pass">
            <input class="reg__input" type="text" placeholder="Описание" name="country_product" required class="input-pass">
            <select class="filter_prod" name="id_category" required class="input-pass">
                <option value selected disabled>Категория</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id_category }}">{{ $category->name_category }}</option>
                @endforeach
            </select>
            <input class="reg__input" type="number" placeholder="Количество на складе" name="count_product" required class="input-pass">
            <p class="text-left">Фотография товара</p>
            <input type="file" name="image" required accept=".jpg, .png, .jpeg" class="input-pass">
            <button>Добавить</button>
        </form>
        @error('image')
        <div class="error">
            {{ $message }}
        </div>
        @enderror
        @error('msgForImg')
        {{ $message }}
        @enderror
        {{ session('msgForProduct') }}
    </div>
@endsection
