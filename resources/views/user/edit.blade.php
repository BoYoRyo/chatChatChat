<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex">
            {{ __('プロフィール') }}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
        </h2>
    </x-slot>

    {{-- プロフィール --}}
    <div class="py-12">

        @if (Session::has('message'))
            <div class="max-w-6xl mx-auto border px-4 py-3 rounded relative bg-amber-100 border-amber-400 text-amber-700">
                {{ session('message') }}
            </div>
        @endif

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex">
                        {{-- 画像 --}}
                                        <script>
                                            document.getElementById('preview').style.display="none";
                                            function previewImage(obj) {
                                                var fileReader = new FileReader();
                                                fileReader.onload = (function() {
                                                    originIcon.style.display ="none";
                                                    document.getElementById('preview').src = fileReader.result;
                                                });
                                                fileReader.readAsDataURL(obj.files[0]);
                                            }
                                        </script>
                        <div class="flex justify-center p-2 bg-white m-10">
                            <div class="relative">
                                {{-- 元々のicon --}}
                                <img src="{{ asset('icon/' . $user->icon) }}" style="max-height:240px;" id="originIcon">
                                {{-- アップロード後 --}}
                                <img id="preview"
                                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                style="max-height:240px;"
                                class="rounded-full w-60 h-60 object-cover ">
                                {{-- アップロードボタン --}}
                                <div class="flex p-2 absolute top-60 right-0">
                                    <label
                                        class="cursor-pointer border-solid border-3 border-gray-100 rounded-full bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                        </svg>
                                        <input type="file" name="icon" class="hidden" accept='image/*'
                                            onchange="previewImage(this);">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="flex-initial">
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
                            <button type="submit" class="bg-amber-300 hover:bg-amber-500 text-gray-800 rounded px-4 py-2 w-40">変更</button>
                            <button type="button" onclick="history.back()" class="bg-gray-500 hover:bg-gray-700 text-white rounded px-4 py-2 w-40">戻る</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
