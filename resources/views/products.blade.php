@extends('layouts.layout')
@section('head')
    <title>Все товары</title>
    <script>
        function changeFilter(sort, order) {
            document.querySelector('#sortInput').value = sort;
            document.querySelector('#orderInput').value = order;
            document.querySelector('#filterProducts').submit();
        }
    </script>
@endsection
@section('content')
    @php($order = !request('order') || request('order') == 'asc' ? 'desc' : 'asc')
    @if(request('order'))
        @php($arrow = request('order') == 'asc' ? '&uarr;' : '&darr;')
    @endif
    <div class="content catalog_cont">
        <div class="row" style="margin-bottom: 20px">
            <form id="filterProducts" action="{{ route('products') }}" style="display: flex; justify-content: space-between; width: 100%">
                <p class="filter_prod">
                    <a class="filter_prod_a" href="{{ route('products') }}">Сбросить</a> |
                    <span class="filter_prod_b" id="year" onclick="changeFilter('weight', '{{ $order }}')">Вес
                        @if(request('sort') == 'weight')
                            {!! $arrow !!}
                        @endif
                    </span> |
                    <span class="filter_prod_c" id="name" onclick="changeFilter('size', '{{ $order }}')">Размер
                        @if(request('sort') == 'size')
                            {!! $arrow !!}
                        @endif
                    </span> |
                    <span class="filter_prod_d" id="price" onclick="changeFilter('price_product', '{{ $order }}')">Цена
                        @if(request('sort') == 'price_product')
                            {!! $arrow !!}
                        @endif
                    </span>
                </p>
                <input id="sortInput" type="hidden" name="sort" value="{{ request('sort') }}">
                <input id="orderInput" type="hidden" name="order" value="{{ request('order') }}">
                <select class="filter_prod" id="category" name="category" onchange="submit()">
                    <option value disabled selected>Фильтрация по категориям</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id_category }}" {{ request('category') == $category->id_category ? 'selected' : '' }}>{{ $category->name_category }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="card-blocks" id="products">
            @if(count($products) > 0)
                @foreach($products as $product)
                    <div class="card-block">
                        <img class="card-image" src="{{ asset($product->path_product) }}" alt="product">
                        <div class="card-info">
                            <h3 class="card-text"><a target="_blank" href="{{ route('product', ['id' => $product->id_product]) }}">{{ $product->name_product }}</a></h3>
                            <p class="card-price">{{ $product->price_product }} руб.</p>
                            @auth()
                                @if(auth()->user()->isAdmin())
                                    <div class="row">
                                        <div class="row-btn">
                                            <p><a href="{{ route('changeProductPage', ['id' => $product->id_product]) }}" class="text-small"><button class="card-button btn" class="text-small btnA">Редактировать</button></a></p>
                                            <p>
                                            <form action="{{ route('deleteProduct') }}" method="post">
                                                @csrf
                                                @method("DELETE")
                                                <input type="hidden" name="id_product" value="{{ $product->id_product }}">
                                                <p>
                                                    <button class="card-button btn" type="submit" class="text-small btnA btnB">Удалить</button>
                                                </p>
                                        </div>
                                        </form>
                                        </p>
                                    </div>
                                @endif
                                <p class="text-right">
                                @if($product->inBasket)
                                    <form action="{{ route('deleteBasket') }}" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <input type="hidden" name="id_product" value="{{ $product->id_product }}">
                                        <button class="card-button btn" type="submit" class="text-small btnA">Удалить из корзины</button>
                                    </form>
                                @else
                                    <form action="{{ route('addBasket') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id_product" value="{{ $product->id_product }}">
                                        <button class="card-button btn" type="submit" class="text-small btnA">В корзину</button>
                                    </form>
                                    @endif
                                    </p>
                                @endauth
                        </div>
                    </div>
                @endforeach
            @else
                <div>Товаров в данный момент нет</div>
            @endif
        </div>
    </div>
@endsection
@section('footer')
    <footer class="footer-products">
    </footer>
@endsection
