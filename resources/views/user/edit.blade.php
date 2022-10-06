<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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
        @if (isset($message))
            <div class="border px-4 py-3 rounded relative bg-green-100 border-green-400 text-green-700">
                {{ $message }}
            </div>
        @endif
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="post" action="{{ route('user.update', $user) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    {{-- 画像 --}}
                    <div class="flex justify-center p-2 bg-white">
                        <div class="relative">
                            <img src="{{ asset('icon/' . $user->icon) }}" style="max-height:240px;">
                            {{-- アップロードボタン --}}
                            <div class="flex p-2 absolute bottom-0 right-0">
                                <label
                                    class="cursor-pointer border-solid border-3 border-gray-100 rounded-full bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                    </svg>
                                    <input type="file" class="hidden">
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- 名前 --}}
                    <div class="flex justify-center font-semibold text-l text-gray-800 leading-tight p-2">
                        <div class="mb-1">
                            <label for="name" class="block mb-0 text-sm font-medium text-gray-500">名前</label>
                            <input type="text" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-amber-400 focus:border-amber-400 block w-full p-2.5"
                                placeholder="名前" value="{{ $user->name }}">
                        </div>
                    </div>

                    {{-- 一言 --}}
                    <div class="flex justify-center font-semibold text-l text-gray-800 leading-tight p-2">
                        <div class="mb-1">
                            <label for="introduction" class="block mb-0 text-sm font-medium text-gray-500">ひとこと</label>
                            <input type="text" id="introduction"
                                class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-amber-400 focus:border-amber-400 block w-full p-2.5"
                                placeholder="ひとこと" value="{{ $user->introduction }}">
                        </div>
                    </div>

                    {{-- メール --}}
                    <div class="flex justify-center font-semibold text-l text-gray-800 leading-tight p-2">
                        <div class="mb-1">
                            <label for="email" class="block mb-0 text-sm font-medium text-gray-500">メールアドレス</label>
                            <input type="text" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-amber-400 focus:border-amber-400 block w-full p-2.5"
                                placeholder="メールアドレス" value="{{ $user->email }}">
                        </div>
                    </div>

                    {{-- ID --}}
                    <div class="flex justify-center font-semibold text-l text-gray-800 leading-tight p-2">
                        <div class="mb-1">
                            <label for="acountId" class="block mb-0 text-sm font-medium text-gray-500">アカウントID</label>
                            <input type="text" id="acountId"
                                class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-amber-400 focus:border-amber-400 block w-full p-2.5"
                                placeholder="アカウントID" value="{{ $user->email }}">
                        </div>
                    </div>

                    {{-- 変更ボタン --}}
                    <button type="submit">変更</button>
                    <button type="button" onclick="history.back()">戻る</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
