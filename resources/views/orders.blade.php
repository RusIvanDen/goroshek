
@extends('layouts.layout')

@section('head')
    <title>Заказы</title>
@endsection

@section('content')
    <div class="container ord" style="max-width: 1200px; margin: 0 auto">
        <div class="line"></div>
        <!-- <h3 class="text-center">Список заказов пуст</h3> -->
        <div class="orders cont">
            @if(count($orders) > 0)
                @foreach($orders as $idOrder => $order)
                    @php($totalCount = 0)
                    @foreach($order as $product)
                        @php($totalCount += $product->count_order)
                    @endforeach
                    <div class="wrap orders">
                        <div class="row">
                            <h2>Заказ {{ $order[0]->id_order }}</h2>
                            @if($order[0]->id_status == 1)
                                <form action="{{ route('deleteOrder') }}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <input type="hidden" name="id_order" value="{{ $idOrder }}" />
                                    <button class="card-button btn" type="submit" class="text-small delete-order">Удалить заказ</button>
                                </form>
                            @endif
                        </div>
                        <div class="row">
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
                    </div><br>
                    <hr>
                @endforeach
            @else
                <div class="orders-msg">Вы еще ничего не заказывали((</div>
            @endif
        </div>
        </div>
@endsection
