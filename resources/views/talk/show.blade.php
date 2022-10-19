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
                    @if($conversation->image != null)
                        <img src={{ asset( 'storage/img/' . $conversation->image ) }} style="width:150px;" >
                    @endif
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
                    @if($conversation->image != null)
                        <img src={{ asset( 'storage/img/'.$conversation->image ) }} style="width:150px;" >
                    @endif
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
                        </button>
                        
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
                        </button>
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
    {{-- トーク投稿 --}}
    <form method="POST" action={{ route('conversation.store', ['group_id' => $group->id]) }} enctype="multipart/form-data">
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
                <textarea name="comment" rows="2" cols="100" class="px-0 w-full text-sm text-gray-900 bg-gray-200 border-0 dark:bg-gray-200 focus:ring-0 dark:text-black dark:placeholder-gray-400 rounded-sm" placeholder="Write a message"></textarea>
                {{-- 画像プレビュー --}}
                <label for="image">
                    <input type="file" name="image" id="image" class="hidden">
                    <img id="preview" style="width:100px;">
                    {{-- 画像添付ボタン --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                        <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                        <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                    </svg>
                </label>
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
            $(function(){
            $("[name='image']").on('change', function (e) {
                
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $("#preview").attr('src', e.target.result);
                }

                reader.readAsDataURL(e.target.files[0]);   

            });
            });

        </script>
    <!-- Scriptsここまで -->
</x-app-layout>
