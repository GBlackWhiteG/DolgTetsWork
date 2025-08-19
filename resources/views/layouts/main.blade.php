<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/styles.css">
    @vite('resources/css/app.css')
    <title>Document</title>
</head>
<body>
<nav class="shadow-lg">
    <div class="container flex justify-between items-center py-4 px-0.5 box-content mx-auto">
        <a href="">Logo</a>
        <label class="flex gap-2 items-center">
            <span>Ссылка на Google таблицу:</span>
            <form action="{{ route('setGoogleSheetUrl') }}" method="POST">
                @csrf
                <input type="text" name="google-sheet-url" placeholder="http://..."
                       class="border border-black rounded p-2" value="@if(isset($settings->google_spreadsheet_url)) {{ $settings->google_spreadsheet_url }} @endif">
                <button type="submit">Сохранить</button>
            </form>
        </label>
        <div class="flex gap-4">
            <form action="{{ route('fillDb') }}" method="POST">
                @csrf
                <button type="submit" class="cursor-pointer">Заполнить БД</button>
            </form>
            <form action="{{ route('clearDb') }}" method="POST">
                @csrf
                <button type="submit" class="cursor-pointer">Очистить БД</button>
            </form>
            <form action="{{ route('clearGoogleSheet') }}" method="POST">
                @csrf
                <button type="submit" class="cursor-pointer">Очистить таблицу</button>
            </form>
        </div>
    </div>
</nav>
<main class="mt-8">
    <div class="container px-1 box-content mx-auto">
        @yield('content')
    </div>
</main>

@yield('scripts')
</body>
</html>
