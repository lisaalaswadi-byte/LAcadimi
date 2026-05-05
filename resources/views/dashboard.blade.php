<html>
        <link rel="icon" href="{{asset('image/ai.png')}}" type="image/x-icon">
<head>
<style>
    .body{
        background-image:url("{{asset('image/l.png')}}");
    }
    #nav{
        display :flex;
        justify-content:space-between;
        align-items:center;
        padding:50px;
       
    
    }
    a:hover{
        background-color:lightgray;
        border-radius:20px;
    }
</style>

</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <nav id="nav">
        <a href="{{route('publish')}}" target="_blank">publish Tutorials</a><br>
         <a href="{{route('news')}}" target="_blank">publish news</a>

    </nav>
    <body class="body">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
</body>
</html>