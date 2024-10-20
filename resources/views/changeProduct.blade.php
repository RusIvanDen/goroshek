@extends('layouts.layout')

@section('head')
    <title>Изменение товара - {{ $product->name_product }}</title>
@endsection

@section('content')
    <div class="content">
        <div class="head" id="addFormProduct">Изменение товара</div>
        <div class="line"></div>
        <form action="{{ route('changeProduct') }}" method="POST" enctype="multipart/form-data" class="form-change">
            @csrf
            @method("PATCH")
            <input class="reg__input" type="hidden" name="id_product" value="{{ $product->id_product }}">
            <input class="reg__input" type="text" placeholder="Название" name="name_product" value="{{ $product->name_product }}" required class="input-pass">
            <input class="reg__input" type="number" placeholder="Цена" name="price_product" value="{{ $product->price_product }}" required class="input-pass">
            <input class="reg__input" type="text" placeholder="Бренд" name="country_product" value="{{ $product->brand_product }}" required class="input-pass">
            <input class="reg__input" type="number" placeholder="Количество" name="price_product" value="{{ $product->count_product }}" required class="input-pass">
            <input class="reg__input" type="text" placeholder="Путь на сервере" name="country_product" value="{{ $product->path_product }}" required class="input-pass">
            <input class="reg__input" type="text" placeholder="Механизм" name="country_product" value="{{ $product->mechanism_product }}" required class="input-pass">
            <input class="reg__input" type="number" placeholder="Вес" name="price_product" value="{{ $product->weight }}" required class="input-pass">
            <input class="reg__input" type="number" placeholder="Размер" name="price_product" value="{{ $product->size }}" required class="input-pass">
            <input class="reg__input" type="text" placeholder="Цвет" name="country_product" value="{{ $product->color }}" required class="input-pass">
            <input class="reg__input" type="text" placeholder="Описание" name="country_product" value="{{ $product->info }}" required class="input-pass">


            <select class="filter_prod" name="id_category" required class="input-pass">
                <option value selected disabled>Категория</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id_category }}" {{ $product->id_category == $category->id_category ? 'selected' : '' }}>{{ $category->name_category }}</option>
                @endforeach
            </select>

            <input class="reg__input" type="number" placeholder="Количество на складе" name="count_product" required class="input-pass" value="{{ $product->count_product }}">
            <p class="text-left">Фотография товара</p>
            <img class="img_prod" src="{{ asset($product->path_product) }}">
            <input type="file" name="image" required accept=".jpg, .png, .jpeg" class="input-pass">
            <button>Изменить</button>
        </form>
        @error('msgForImg')
        {{ $message }}
        @enderror
        {{ session('msgForProduct') }}
    </div>
@endsection
