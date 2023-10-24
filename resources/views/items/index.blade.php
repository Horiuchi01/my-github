<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>イラスト・写真</title>
    <!-- CSSリンク -->
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>

<h1 class="logo">イラスト・写真</h1>
<h3>商品数: {{ count($items) }} 枚</h3>

<!-- 日付時刻表示 -->
<p id="currentDate"></p>
<p id="currentTime"></p>

<h1 class="logo">注文フォーム</h1>
<!-- 注文フォーム -->
@if(session("feedback.success"))
    <p>{{ session("feedback.success") }}</p>
@endif
<form method="post" action="{{ route('order.confirm') }}">
    @csrf
    <!-- 商品リスト表示 -->
    @foreach($items as $item)
        <div class="item">
            <h3 class="item-name">{{ $item->name }}</h3>
            @if($item instanceof \App\Models\Illustration)
                <p class="item-type">イラストの種類: {{ $item->type }}</p>
            @elseif($item instanceof \App\Models\Photograph)
                <p class="item-type">被写体: {{ $item->subject }}</p>
            @endif
            <p class="item-price">¥{{ $item->price }}</p>
            <img src="{{ asset('img/items/' . $item->image) }}" class="item-image" alt="{{ $item->name }}" onclick="toggleImageSize(this);">
            <br/>
            <label class="quantity" for="quantity[{{ $item->name }}]">数量:</label>
            <input class="quantity" name="quantity[{{ $item->name }}]" type="number" value="0" min="0">
            <span>枚</span>
        </div>
    @endforeach
    <input class="btn" type="submit" value="注文する">
</form>
<div>
    <!-- 新しく追加した機能 -->
    <p>過去の注文</p>
    @foreach($dbItems as $dbitem)
        <p>{{ $dbitem->name }}</p>
        <p>{{ $dbitem->itemPrice }}</p>
        <p>{{ $dbitem->totalPrice }}</p>
        <form action="{{ route('items.delete', ['itemId' => $dbitem->id]) }}" method="post">
            @method("DELETE")
            @csrf
            <button class="btn" type="submit">削除</button>
        </form>
    @endforeach
</div>
<!-- 温度表示 -->
<p>ここから温度</p>
<div id="test"></div>

<!-- JSコード -->
<script>
    function toggleImageSize(image) {
        if (image.classList.contains('item-image')) {
            image.classList.remove('item-image');
            image.style.cursor = "zoom-out";
        } else {
            image.classList.add('item-image');
            image.style.cursor = "zoom-in";
        }
    }

    function displayCurrentDate() {
        var currentDate = new Date();
        document.getElementById("currentDate").textContent = "現在の日付: " + currentDate.toLocaleDateString();
    }

    function displayCurrentTime() {
        var currentTime = new Date();
        document.getElementById("currentTime").textContent = "現在の時刻: " + currentTime.toLocaleTimeString();
    }

    window.onload = function () {
        displayCurrentDate();
        displayCurrentTime();
        setInterval(displayCurrentTime, 1000);
    };

    async function fetchWeather() {
        try {
            const response = await fetch("https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&hourly=temperature_2m&timezone=Asia%2FTokyo");
            
            if (!response.ok) throw new Error("Network response was not ok");
            
            const data = await response.json();
            
            const header = document.getElementById('test');

            // data.hourlyが存在するかを一度だけチェック
            if (data.hourly && data.hourly.temperature_2m) {
                for(let i = 0; i < data.hourly.temperature_2m.length; i++) {
                    const temperature = data.hourly.temperature_2m[i] || "Unknown";  // 温度データを取得
                    header.insertAdjacentHTML('beforebegin', `<p>${temperature}</p>`);  // 温度をpタグで表示
                }
            }

        } catch (error) {
            console.log(`エラーが発生しました: ${error.message}`);
        }
    }

    fetchWeather();

</script>
</body>
</html>
