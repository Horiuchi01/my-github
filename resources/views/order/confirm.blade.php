<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>注文確認</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
</head>
<body>
    <h1 class="logo">イラスト・写真</h1>
    <div class="order">
        <h2>注文内容確認</h2>
        <form method="post" action="{{ route('thanks.store') }}">
            @csrf 
            <ul>
                @foreach($items as $item)
                    @php
                        $itemName = $item['name'];
                        $orderCount = $orderCounts[$itemName] ?? 0;
                        $totalPricePerItem = $item['price'] * $item['itemCount'];
                    @endphp
                    <li class="item-list">
                        {{ $itemName }} x {{ $orderCount }} 枚
                        @if($orderCount > 0)
                            <input name="item-names[]" type="hidden" value="{{ $itemName }}">
                            <input name="item-prices[]" type="hidden" value="{{ $totalPricePerItem }}"> 
                        @endif
                        {{ $totalPricePerItem }} 円
                    </li>
                @endforeach
            </ul>
            <h3>合計金額: {{ $totalPayment }}円</h3>
            <input name="total-price" type="hidden" value="{{ $totalPayment }}">
            @if($totalPayment > 0)
                <input class="btn" type="submit" value="注文決定">
            @endif
        </form>
    </div>
    <input class="btn" type="button" onclick="history.back()" value="戻る">
</body>
</html>
