@extends('layouts.layout')

@section('head')
    <title>Корзина</title>
    <script>
        function changeCount(id_product, count) {
            let priceProduct = document.querySelector('#price_product'+id_product).innerHTML; // получили цену за продукт
            document.querySelector('#sum_basket'+id_product).value = +priceProduct * +count; // изменили сумму у продукта

            let sumsInput = document.querySelectorAll('.sum_basket'); // взяли все суммы у каждого продукта
            let finalPrice = 0; // финальная стоимость
            sumsInput.forEach(item => { // берем каждую сумму продукта и добавляем в финальную стоимость
                finalPrice += +item.value;
            })

            document.querySelector('#final_price').innerHTML = finalPrice; // изменяем финальную стоимость на фронте
        }

        function deleteBasket(id_product) {
            document.querySelector('#id_product_delete_basket').value = id_product; // изменяем значения у нашей невидимой формы
            document.querySelector('#deleteBasket').submit(); // имитируем нажатие на кнопку
        }

        function toggleCardText(checkbox) {
            let cardTextField = document.getElementById('cardText');
            cardTextField.style.display = checkbox.checked ? 'block' : 'none';
        }

        function validateForm(event) {
            let cardCheckbox = document.getElementById('addCard');
            let cardText = document.getElementById('cardTextInput').value;
            if (cardCheckbox.checked && cardText.trim() === '') {
                event.preventDefault();
                alert('Пожалуйста, введите текст открытки.');
            }
        }
    </script>
@endsection

@section('content')
    <div class="content order">
        {{ session('msg') }}
        <div class="line"></div>
        <form action="{{ route('addOrder') }}" class="w100" method="POST" onsubmit="validateForm(event)">
            @csrf
            @if(count($productsBasket) > 0)
                <div class="wrap">
                    <div class="row">
                        @php($finalPrice = 0)
                        @foreach($productsBasket as $product)
                            @php($finalPrice += $product->count_basket * $product->price_product)
                            <div class="col">
                                <img class="basket-img" src="{{ $product->path_product }}" alt="img">
                                <div class="row">
                                    <h3><a target="_blank" href="{{ route('product', ['id' => $product->id_product]) }}">{{ $product->name_product }}</a></h3>
                                    <p><span id="price_product{{ $product->id_product }}">{{ $product->price_product }}</span> руб.</p>
                                </div>
                                <div class="row">
                                    <p>
                                        <input type="hidden" name="id_products[]" value="{{ $product->id_product }}" />
                                        <input
                                            id="sum_basket{{ $product->id_product }}"
                                            class="sum_basket"
                                            type="hidden"
                                            name="sum_baskets[]"
                                            value="{{ $product->count_basket * $product->price_product }}"
                                        >
                                        <input
                                            onchange="changeCount({{ $product->id_product }}, this.value)"
                                            type="number"
                                            value="{{ $product->count_basket }}"
                                            max="{{ $product->count_product }}"
                                            min="1"
                                            name="count_baskets[]"
                                        >
                                    </p>
                                </div>
                                <p class="text-right">
                                    <a class="card-button btn" onclick="deleteBasket({{ $product->id_product }})" class="text-small">Удалить из корзины</a>
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <p>Общая стоимость:</p>
                        <h2><span id="final_price">{{ $finalPrice }}</span> руб.</h2>
                    </div>

                    <input class="reg__input" type="password" placeholder="Ваш пароль" name="password" required class="input-pass-confirm">
                    <button class="card-button btn" class="order-confirm">Сформировать заказ</button>
                </div>
            @else
                <div class="basket-msg">
                    Ваша корзина пуста
                </div>
            @endif
        </form>

        <form action="{{ route('deleteBasket') }}" method="post" id="deleteBasket">
            @csrf
            @method("DELETE")
            <input type="hidden" name="id_product" id="id_product_delete_basket" />
        </form>
    </div>
@endsection
