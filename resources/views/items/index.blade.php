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
            <input class="btn" type="submit" value="削除する">
        </form>
    @endforeach
</div>
<!-- 温度表示 -->
<p>↓大阪？の天気</p>
<p id="target"></p>

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
            const response = await fetch("https://api.open-meteo.com/v1/forecast?latitude=34.6998&longitude=135.5148&hourly=weathercode");
            
            if (!response.ok) throw new Error("Network response was not ok");
            
            const data = await response.json();
            
            const header = document.getElementById('target');

            // data.hourlyが存在するかを一度だけチェック
            if (data.hourly && data.hourly.weathercode) {
                for(let i = 0; i < data.hourly.weathercode.length; i++) {
                    const weatherCode = data.hourly.weathercode[i] || "Unknown"; 
                    const weatherDate = data.hourly.time[i] || "Unknown"; 
                    switch (weatherCode){
                        case "Unknown":
                            weatherType = "晴天";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 1:
                            weatherType = "晴れ";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 2:
                            weatherType = "時々曇り";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 3:
                            weatherType = "曇り";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 45:
                            weatherType = "霧";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 48:
                            weatherType = "霧氷";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 51:
                            weatherType = "軽い霧雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 53:
                            weatherType = "霧雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 55:
                            weatherType = "濃い霧雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 56:
                            weatherType = "氷結霧雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 57:
                            weatherType = "濃い氷結霧雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 61:
                            weatherType = "小雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 63:
                            weatherType = "雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 65:
                            weatherType = "大雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 66:
                            weatherType = "凍てつく雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 67:
                            weatherType = "凍てつく大雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 71:
                            weatherType = "小雪";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 73:
                            weatherType = "雪";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 75:
                            weatherType = "大雪";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 77:
                            weatherType = "ひょう";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 80:
                            weatherType = "軽いにわか雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 81:
                            weatherType = "にわか雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 82:
                            weatherType = "激しいにわか雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 85:
                            weatherType = "軽い雪";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 86:
                            weatherType = "激しい雪";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 95:
                            weatherType = "雷雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 96:
                            weatherType = "ひょうを伴う雷雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        case 99:
                            weatherType = "ひょうを伴う激しい雷雨";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                            break;
                        default:
                            weatherType = "不明";
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherType}</p>`);
                            header.insertAdjacentHTML('beforebegin', `<p>${weatherDate}</p>`);
                    }
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
