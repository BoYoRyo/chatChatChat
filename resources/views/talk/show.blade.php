<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if ($group->type == '0')
            {{-- 個人トーク --}}
            <a href="{{ route('friend.show', $groupName->id) }}" class=" flex">
                <div class="bg-white">
                    <img src="{{ asset('icon/' . $groupName->icon) }}" style="max-height:50px;" class="rounded-full">
                </div>
                <div class="ml-3 my-auto">
                    {{ $groupName->name }}
                </div>
            </a>
            @else
            {{-- グループトーク --}}
            <a href="{{ route('group.show', $group->id) }}" class=" flex">
                <div class="bg-white">
                    <img src="{{ asset('icon/' . $group->icon) }}" style="max-height:50px;" class="rounded-full">
                </div>
                <div class="ml-3 my-auto">
                    {{ $groupName }}
                </div>
            </a>
            @endif
        </h2>
    </x-slot>
    @if ($group->conversation->isEmpty())
    {{-- トークがなかった場合 --}}
    @else
        @foreach ($group->conversation as $conversation)
            @if ($conversation->user_id == Auth::id())
                {{-- ユーザー側のコメント --}}
                <div class="container mx-auto m-4 w-1/2 py-4 px-8 text-right bg-white rounded dark:bg-gray-800">
                    <span
                        class="px-0 w-full my-auto mx-1 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-black dark:placeholder-gray-400">
                        {{ $conversation->comment }}
                    </span>
                </div>
            @else
                {{-- 相手側のコメント --}}
                <div class="container mx-auto flex m-4 w-1/2 py-4 px-8 bg-white rounded dark:bg-gray-800">
                    <div class="bg-white">
                        <a href="{{ route('friend.show', $conversation->user->id) }}">
                            <img src="{{ asset('icon/' . $conversation->user->icon) }}" style="max-height:40px;">
                        </a>
                    </div>
                    <span
                        class="px-0 w-full my-auto mx-1 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-black dark:placeholder-gray-400">
                        {{ $conversation->comment }}
                    </span>
                </div>
            @endif
        @endforeach
    @endif
    {{-- トーク投稿 --}}
    <form method="POST" action={{ route('conversation.store', ['group_id' => $group->id]) }}>
        @csrf
        <div id="container">
            <div class="content">
                <div class="message-area you">
                    <div class="user-image" style="background-image: url(img.jpg);"></div>
                </div>
            </div>
        </div>
        <div class="container flex mx-auto m-4 w-1/2 py-4 px-8 bg-amber-300 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
            <div class="py-4 px-8 bg-white rounded dark:bg-gray-800">
                {{-- テキスト --}}
                <textarea name="comment" rows="2" cols="100" class="px-0 w-full text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-black dark:placeholder-gray-400" placeholder="Write a message"></textarea>
                {{-- 画像添付ボタン --}}
                    <label class="cursor-pointer border-solid border-3 border-gray-100 rounded-full bg-gray-100" for="image">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                            <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                            <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                        </svg>
                        <input type="file" name="image" id="image" class="hidden" accept='image/*' onchange="previewImage(this);">
                    </label>
                {{-- 画像プレビュー表示 --}}
                    @if($filepath != null)
                        <img id="img_prv" class="img-thumbnail h-25 w-25 mb-3" src="/resources/storage/app/public{{ $filepath }}">
                    @endif
            </div>
            {{-- 送信ボタン --}}
            <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-0 px-4 my-0 mx-2 rounded">send</button>
        </div>
    </form>
    {{-- <script>
        const timer = 5000 // ミリ秒で間隔の時間を指定
        window.addEventListener('load', function() {
            setInterval('location.reload()', timer);
        });
    </script> --}}
    <!-- 以下Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>
            // 画像プレビュー処理
            // 画像が選択される度に、この中の処理が走る
            $('#image').on('click', function (ev) {
                // このFileReaderが画像を読み込む上で大切
                const reader = new FileReader();
                // ファイル名を取得
                const fileName = ev.target.files[0].name;
                // 画像が読み込まれた時の動作を記述
                reader.onload = function (ev) {
                    $('#img_prv').attr('src', ev.target.result).css('width', '100px').css('height', '100px');
                }
                reader.readAsDataURL(this.files[0]);
            })
        </script>
    <!-- Scriptsここまで -->
</x-app-layout>
