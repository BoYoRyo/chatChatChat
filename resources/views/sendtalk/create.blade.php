<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('トーク画面') }} 
        </h2>
    </x-slot>
        <form method="POST" action={{ route('sendtalk.store') }}>
            <div id="container">
                <h2>トークする相手の名前</h2>
                <div class="content">
                    <div class="message-area you">
                        <div class="user-image" style="background-image: url(img.jpg);"></div>
                    </div>
                </div>
            </div>
        </form>
        <textarea maxlength="30"></textarea>
        <button name="btn">送信</button>
</x-app-layout>