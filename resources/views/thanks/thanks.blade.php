<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>イラスト・写真注文フォーム</title>
    <!-- CSSファイルのリンク -->
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
</head>

<body>
    <h1 class="logo">イラスト・写真</h1>
    <h2>注文を受け付けました！</h2>

    <!-- アイテムリストの表示 -->
    <!-- $itemNames と $itemPrices の要素数が一致している場合のみアイテムリストを表示するように変更 -->
    @if(count($itemNames) == count($itemPrices) && count($itemNames) > 0)
    <p>注文した商品一覧：</p>
    <ul>
        <!-- 各アイテムの名称と価格をリスト表示 -->
        @foreach(array_combine($itemNames, $itemPrices) as $itemName => $itemPrice)
        <li class="item-list">
            {{ $itemName }} - {{ $itemPrice }}円
        </li>
        @endforeach
    </ul>
    @endif

    <!-- 合計金額の表示 -->
    <p>合計金額：{{ $totalPrice }}円</p>
    
    <form method="get" action="{{ route('items.index') }}">
        <input class="btn" type="submit" value="TOPに戻る">
    </form>
</body>

</html>
