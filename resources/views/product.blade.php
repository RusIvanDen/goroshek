@extends('layouts.layout')

@section('head')
    <title>{{ $product->name_product }}</title>
@endsection

@section('content')
    <div class="pr-head">{{ $product->name_product }}</div>
    <div class="content product">

        <div class="line"></div>
        <div class="product wrap">
            <div class="img_prod">
                <img class="img_prod" src="{{ asset($product->path_product) }}" alt="{{ $product->name_product }}">
            </div>
            <div class="pr-text">
                <h3>Характеристики:</h3>
                <p>Бренд: <b>{{ $product->brand_product }}</b></p>
                <p>Механизм: <b>{{ $product->mechanism_product }}</b></p>
                <p>Вес (г): <b>{{ $product->weight }}</b></p>
                <p>Размер: <b>{{ $product->size }}</b></p>
                <p>Цвет: <b>{{ $product->color }}</b></p>
                <p>Описание: <b>{{ $product->info }}</b></p>

                <div class="row">
                    <h3>{{ $product->price_product }} руб.</h3>
                </div>
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="row">
                            <form class="wUnset" action="{{ route('changeProductPage', ['id' => $product->id_product]) }}">
                                <button type="submit" class="card-button">Редактировать</button>
                            </form>
                            <form class="wUnset" action="{{ route('deleteProduct') }}" method="post">
                                @csrf
                                @method("DELETE")
                                <input type="hidden" name="id_product" value="{{ $product->id_product }}">
                                <button type="submit" class="card-button">Удалить</button>
                            </form>
                        </div>
                    @endif
                    <p class="text-right">
                    @if($product->inBasket)
                        <form action="{{ route('deleteBasket') }}" method="post">
                            @csrf
                            @method("DELETE")
                            <input type="hidden" name="id_product" value="{{ $product->id_product }}">
                            <button type="submit" class="card-button">Удалить из корзины</button>
                        </form>
                    @else
                        <form action="{{ route('addBasket') }}" method="post">
                            @csrf
                            <input type="hidden" name="id_product" value="{{ $product->id_product }}">
                            <button type="submit" class="card-button">В корзину</button>
                        </form>
                        @endif
                        </p>
                    @endauth
            </div>
        </div>
    </div>
@endsection
