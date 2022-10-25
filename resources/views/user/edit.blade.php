<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex">
            <div class="my-auto">
                {{ __('プロフィール') }}
            </div>
            <div class="my-auto p-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </div>
        </h2>
    </x-slot>

    {{-- プロフィール --}}
    <div class="py-12">

        @if (Session::has('message'))
            <div
                class="max-w-6xl mx-auto border px-4 py-3 my-3 rounded relative bg-amber-100 border-amber-400 text-amber-700">
                {{ session('message') }}
            </div>
        @endif

        <div class="max-w-4xl max-h-8xl mx-auto sm:px-6 lg:px-8 py-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex">
                        {{-- 画像 --}}
                        <div class="flex justify-center p-2 bg-white m-10">
                            <div class="relative">
                                {{-- 元々のicon --}}
                                <img src="{{ asset('icon/' . $user->icon) }}" style="max-height:240px;"
                                    class="rounded-full w-60 h-60 object-cover" id="originIcon" alt="">
                                <div class="flex p-2 absolute top-60 right-0">
                                    <label class="cursor-pointer border-solid border-white rounded-full bg-white">
                                        {{-- アップロードするための空のファイル --}}
                                        <input type="file" name="icon" class="hidden" accept='image/*'
                                            onchange="previewImage(this);">
                                        {{-- アップロードボタン --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>

                                    </label>
                                </div>
                            </div>
                        </div>
                        <div>
                            {{-- 名前 --}}
                            <div class="font-semibold text-l text-gray-800 leading-tight p-2">
                                <div class="mb-1">
                                    <label for="name"
                                        class="block mb-0 text-sm font-medium text-gray-500">名前</label>
                                    <input type="text" id="name" name="name"
                                        class="@error('name') is-invalid @enderror bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-amber-400 focus:border-amber-400 block w-full p-2.5"
                                        placeholder="名前" value="{{ $user->name }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- 一言 --}}
                            <div class="font-semibold text-l text-gray-800 leading-tight p-2">
                                <div class="mb-1">
                                    <label for="introduction"
                                        class="block mb-0 text-sm font-medium text-gray-500">ひとこと</label>
                                    <input type="text" id="introduction" name="introduction"
                                        class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-amber-400 focus:border-amber-400 block w-full p-2.5"
                                        placeholder="ひとこと" value="{{ $user->introduction }}">
                                </div>
                            </div>

                            {{-- メール --}}
                            <div class="font-semibold text-l text-gray-800 leading-tight p-2">
                                <div class="mb-1">
                                    <label for="email"
                                        class="block mb-0 text-sm font-medium text-gray-500">メールアドレス</label>
                                    <input type="text" id="email" name="email"
                                        class="@error('email') is-invalid @enderror bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-amber-400 focus:border-amber-400 block w-full p-2.5"
                                        placeholder="メールアドレス" value="{{ $user->email }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- ID --}}
                            <div class="font-semibold text-l text-gray-800 leading-tight p-2">
                                <div class="mb-1">
                                    <label for="accountId"
                                        class="block mb-0 text-sm font-medium text-gray-500">アカウントID</label>
                                    <input type="text" id="accountId" name="accountId"
                                        class="@error('accountId') is-invalid @enderror bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-amber-400 focus:border-amber-400 block w-full p-2.5"
                                        placeholder="アカウントID" value="{{ $user->account_id }}">
                                    @error('accountId')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            {{-- 変更ボタン --}}
                            <button type="submit"
                                class="bg-amber-300 hover:bg-amber-400 text-gray-800 font-semibold rounded px-4 py-2 w-40 m-4">変更</button>
                            <button type="button" onclick="history.back()"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-semibold rounded px-4 py-2 w-40 m-4">戻る</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 以下Scripts 画像プレビューに使用するイベント -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        // 画像プレビュー処理
        // 画像が選択される度に、この中の処理が走る
        $(function() {
            $("[name='icon']").on('change', function(e) {

                var reader = new FileReader();

                reader.onload = function(e) {
                    $("#originIcon").attr('src', e.target.result);
                }

                reader.readAsDataURL(e.target.files[0]);

            });
        });
    </script>
    <!-- Scriptsここまで -->
</x-app-layout>
