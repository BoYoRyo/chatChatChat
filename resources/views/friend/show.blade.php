<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex">
            <div class="bg-white">
                <img src="{{ asset('icon/' . $friend->icon) }}" style="max-height:50px;" class="rounded-full">
            </div>
            <div class="ml-3 my-auto">
                {{ $friend->name }}
            </div>

        </h2>
    </x-slot>

    {{-- プロフィール --}}
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-1">
            <div class=" bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- 画像 --}}
                <div class="flex justify-center p-2 bg-white">
                    <img src="{{ asset('icon/' . $friend->icon) }}" style="max-height:240px;">
                </div>
                {{-- 名前 --}}
                <div class="flex justify-center font-semibold text-l text-gray-800 leading-tight p-2">
                    <div class="mb-1">
                        <label class="block mb-0 text-sm font-medium text-gray-500">名前</label>
                        {{ $friend->name }}
                    </div>
                </div>

                {{-- 一言 --}}
                <div class="flex justify-center font-semibold text-l text-gray-800 leading-tight p-2">
                    <div class="mb-1">
                        <label class="block mb-0 text-sm font-medium text-gray-500">ひとこと</label>
                        {{ $friend->introduction }}
                    </div>
                </div>

                {{-- トークボタン --}}
                <div class="flex justify-center mb-2">
                    <form method="GET" action="{{ route('talk.store', $friend->id) }}">
                        @csrf
                        <button type="submit"
                            class="bg-amber-300 hover:bg-amber-400 text-gray-500 hover:text-gray-700 font-semibold rounded px-4 py-2 w-40">トーク
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>