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
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- 画像 --}}
                <div class="justify-center p-2 bg-white m-10">
                    <img src="{{ asset('icon/' . $friend->icon) }}" style="max-height:240px;" id="originIcon">
                </div>
                {{-- 名前 --}}
                <div class="font-semibold text-l text-gray-800 leading-tight p-2">
                    <div class="mb-1">
                        <label for="name" class="block mb-0 text-sm font-medium text-gray-500">名前</label>
                        {{ $friend->name }}
                    </div>
                </div>

                {{-- 一言 --}}
                <div class="font-semibold text-l text-gray-800 leading-tight p-2">
                    <div class="mb-1">
                        <label for="introduction" class="block mb-0 text-sm font-medium text-gray-500">ひとこと</label>
                        {{ $friend->introduction }}
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
                @csrf
            </form>
        </div>
    </div>
    </div>
</x-app-layout>
