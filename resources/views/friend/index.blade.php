<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <div class="flex">
                <div class="flex-initial">
                    {{ __('フレンド') }}
                </div>
                <div class="flex-initial">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <div class="flex-initial">
                    <form class="w-full max-w-sm">
                        <div class="flex items-center border-b border-fuchsia-600 py-2">
                            <input
                                class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none  placeholder-gray-400"
                                type="text" placeholder="アカウントID  名前" aria-label="Full name">
                            <button
                                class="flex-shrink-0 bg-fuchsia-600 hover:bg-fuchsia-700 border-fuchsia-600 hover:border-fuchsia-700 text-sm border-4 text-white py-1 px-2 rounded"
                                type="button">
                                検索
                            </button>
                            <input type="reset" value="キャンセル"
                                class="flex-shrink-0 border-transparent border-4 text-fuchsia-600 hover:text-fuchsia-800 text-sm py-1 px-2 rounded"
                            >
                            <!-- <button
                                class="flex-shrink-0 border-transparent border-4 text-fuchsia-600 hover:text-fuchsia-800 text-sm py-1 px-2 rounded"
                                type="button">
                                キャンセル
                            </button> -->
                        </div>
                    </form>
                </div>
            </div>
        </h2>
    </x-slot>

    {{-- 友達一覧 --}}
    <div class="py-12">
        @foreach ($friends as $friend)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex">
                    {{-- 画像 --}}
                    <div class="p-6 bg-white border-b border-gray-200">
                        <a href=""><img src="{{ asset('icon/' . $friend->user->icon) }}"
                                style="max-height:70px;"></a>
                    </div>
                    {{-- 名前 --}}
                    <div class="ml-1 mt-11 bg-white flex-initial text: left; text-xl ">
                        {{ $friend->user->name }}
                    </div>
                    {{-- ひとこと --}}
                    <div class="ml-20 mt-11 bg-white flex-initial text: left; text-xl text-gray-500">
                        {{ $friend->user->introduction }}
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</x-app-layout>
