<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $groupName }}
        </h2>
    </x-slot>
    @if($group->conversation->isEmpty())
    @else
        @foreach ($group->conversation as $conversation)
            @if ($conversation->user_id == Auth::id())
            {{-- ユーザー側のコメント --}}
            <div class="container mx-auto m-4 w-1/2 py-4 px-8 text-right bg-white rounded dark:bg-gray-800">
                <span
                    class="px-0 w-full text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-black dark:placeholder-gray-400">
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
                class="px-0 w-full text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-black dark:placeholder-gray-400">
                    {{ $conversation->comment }}
                </span>
            </div>
            @endif
        @endforeach
    @endif
    <form method="POST" action={{ route('conversation.store', ['group_id' => $group->id]) }}>
        @csrf
        <div id="container">
            <div class="content">
                <div class="message-area you">
                    <div class="user-image" style="background-image: url(img.jpg);"></div>
                </div>
            </div>
        </div>
        <div class="container mx-auto flex-center m-4 w-1/2 py-4 px-8 bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
            <div class="py-4 px-8 bg-white rounded dark:bg-gray-800">
                <textarea name="comment" rows="4" class="px-0 w-full text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-black dark:placeholder-gray-400" placeholder="Write a message"></textarea>
            </div>
                <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 my-2 rounded">送信</button>
        </div>
    </form>
    {{-- <script>
        const timer = 5000 // ミリ秒で間隔の時間を指定
        window.addEventListener('load', function() {
            setInterval('location.reload()', timer);
        });
    </script> --}}
</x-app-layout>
