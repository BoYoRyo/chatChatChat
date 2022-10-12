<x-app-layout>
    <x-slot name="header">
        <span>[{{$addFriendName}}]</span>
        <span class="pl-6">さんと友達になりました！</span>
        <br>
        <a class="mt-12"  href="{{route('add.index')}}">一覧に戻る</a>
    </x-slot>
   
</x-app-layout>
