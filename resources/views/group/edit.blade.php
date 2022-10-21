<x-app-layout>
    <x-slot name="header">
        
    </x-slot>
        <!-- Modal -->
            <div class="py-12" id="modal-content" data-toggle="modal" data-target="#modal-content">
                {{-- 友達一覧 --}}
                @foreach ($wantAddFriends as $wantAddFriend)
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-1">
                    <div class="py-3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="flex items-center my-auto">
                            <input name="memberId[]" id="{{ $wantAddFriend->user->id }}" type="checkbox"
                                value="{{ $wantAddFriend->user->id }}"
                                class="w-4 h-4 ml-3 my-auto text-amber-600 bg-gray-100 rounded border-gray-300 focus:ring-amber-500">
                            <label for="{{ $wantAddFriend->user->id }}" class="flex ml-3 text-sm font-medium text-gray-900">
                                {{-- 画像 --}}
                                <div class="my-auto bg-white">
                                    <img src="{{ asset('icon/' . $wantAddFriend->user->icon) }}" style="max-height:50px;">
                                </div>
                                {{-- 名前 --}}
                                <div class="ml-1 my-auto bg-white text: left; text-xl ">
                                    {{ $wantAddFriend->user->name }}
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- ボタンたち --}}
                <div class="">
                    <button type="submit"
                    class="bg-amber-300 hover:bg-amber-400 text-gray-800 font-semibold rounded px-4 py-2 w-40 m-2">追加</button>
                    <button type="button" onclick="history.back()"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-semibold rounded px-4 py-2 w-40 m-2">戻る</button>
                </div>
            </div>
        {{-- scriptここから --}}
        <script>
        window.onload = function() {
            $('#SampleModal').on('shown.bs.modal', function (event) {
                var button = $(event.relatedTarget);//モーダルを呼び出すときに使われたボタンを取得
                // var title = button.data('title');//data-titleの値を取得
                // var url = button.data('url');//data-urlの値を取得
                var modal = $(this);//モーダルを取得
    
                // //Ajaxの処理はここに
                // //modal-bodyのpタグにtextメソッド内を表示
                // modal.find('.modal-body p').eq(0);
                // //formタグのaction属性にurlのデータ渡す
                // modal.find('form').attr('action',url);
            });
        }
        </script>
        {{-- scriptここまで --}}
</x-app-layout>