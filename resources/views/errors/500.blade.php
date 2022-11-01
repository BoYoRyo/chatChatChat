<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('logo/linkedin_banner_image_1.png') }}" style="max-height:60px;">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        <div class="notpagetext">
            <h2>お探しのページは見つかりませんでした</h2>
            <a href="{{ route('friend.index') }}">chatchatchatで友人と新たな会話を創造してみませんか？</a>
            <img src="/error/nature-g6406d9111_1280.png">
        </div>
        <style>
            .notpagetext {
                text-align: center;
                font-family: sans-serif;
            }
        </style>
    </body>
    </html>
</nav>