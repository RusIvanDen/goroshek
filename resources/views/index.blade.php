@extends('layouts.layout')
@section('head')
    <title>Главная страница - О нас</title>
@endsection
@section('content')
<main class="main">
    <div class="slider">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php $p = 0 ?>
                @foreach($products as $product)
                @if ($p < 4)
                <div class="swiper-slide">
                    <img class="swiper-slide-img" src="/{{ $product->path_product }}" />
                    <p><a class="slider-link" href="{{ route('product', ['id' => $product->id_product]) }}">{{ $product->name_product }}</a></p>
                </div>
                    <?php $p += 1 ?>
                    @endif
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="main__text">
        <p>
            Наша цель — создавать прекрасное настроение, дарить положительные эмоции.
            Ведь согласитесь, качественный, актуальный аксессуар, да еще созданный в России,
            подарит положительные эмоции не только Вам, но и окружающим.
        </p>
    </div>
</main>
@endsection
