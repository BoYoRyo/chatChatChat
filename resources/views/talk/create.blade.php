<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('トーク画面(送信先の友達の名前)') }} 
        </h2>
    </x-slot>
    <form method="POST" action={{ route('talk.store') }}>
        <div id="container">
            <div class="content">
                <div class="message-area you">
                    <div class="user-image" style="background-image: url(img.jpg);"></div>
                </div>
            </div>
        </div>
        <div class="container mx-auto flex-center m-4 w-1/2 py-4 px-8 bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
            <div class="py-4 px-8 bg-white rounded dark:bg-gray-800">
                <label for="comment" class="sr-only">Your comment</label>
                <textarea id="comment" rows="4" class="px-0 w-full text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-black dark:placeholder-gray-400" placeholder="Write a message"></textarea>
            </div>
            <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 my-2 rounded">送信</button>
        </div>
    </form>
</x-app-layout>