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
                <!-- いいねが既に押されていたら -->
                @if(in_array($conversation->id,$gooded))
                    <form action="{{route('good.destroy',['conversationId'=>$conversation->id,'groupId'=>$group->id])}}" method="POST">
                        @csrf
                        <!-- <input type="hidden" name="conversation" value="conversation"> -->
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                                class="w-6 h-6 bg-yellow-200">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                            </svg>
                        </botton>
                        
                    </form>
                    <!-- $goodCountを初期化(次のループで0にするため) -->
                    <input type="hidden" value="{{ $goodCount = 0}}">
                    @foreach($conversation->goods as $good)
                        <!-- いいねの数をgoodsテーブルの該当conversation_idの数だけインクリメント -->
                        <input type="hidden" value="{{ $goodCount = $loop->count}}">
                    @endforeach
                    <span>
                        {{$goodCount}}
                    </span>
                <!-- いいねが押されていなかったら -->
                @else
                <form action="{{route('good.create',['groupId'=>$group->id,'conversationId'=>$conversation->id])}}" method="POST">
                    @csrf
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                                class="w-6 h-6 ">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                            </svg>
                        </botton>
                    </form>
                    <!-- $goodCountを初期化(次のループで0にするため) -->
                    <input type="hidden" value="{{ $goodCount = 0}}">
                    @foreach($conversation->goods as $good)
                        <!-- いいねの数をgoodsテーブルの該当conversation_idの数だけインクリメント -->
                        <input type="hidden" value="{{ $goodCount = $loop->count}}">
                    @endforeach
                    <span>
                        {{$goodCount}}
                    </span>
                @endif

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
        <div class="container mx-auto flex-center m-4 w-1/2 py-4 px-8 bg-amber-300 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
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
