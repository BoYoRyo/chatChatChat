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
        <div class="container flex mx-auto m-4 w-1/2 py-4 px-8 bg-amber-300 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
            <div class="py-4 px-8 bg-white rounded dark:bg-gray-800">
                <textarea name="comment" rows="2" cols="100" class="px-0 w-full text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-black dark:placeholder-gray-400" placeholder="Write a message"></textarea>
                <label class="cursor-pointer border-solid border-3 border-gray-100 rounded-full bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                        <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                        <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                    </svg>
                    <input type="file" name="icon" class="hidden" accept='image/*' onchange="previewImage(this);">
                </label>
            </div>
            <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-0 px-4 my-0 mx-2 rounded">send</button>
        </div>
    </form>
    {{-- <script>
        const timer = 5000 // ミリ秒で間隔の時間を指定
        window.addEventListener('load', function() {
            setInterval('location.reload()', timer);
        });
    </script> --}}
</x-app-layout>
