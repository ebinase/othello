<!DOCTYPE html>
<html lang="ja">
    <head>
        @include('layouts.head')
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="fixed top-0 right-0 px-6 py-4 sm:block">
                <a href="{{ route('top') }}" class="text-sm text-gray-700 underline">Top</a>
{{--                <a href="{{ '' }}" class="text-sm text-gray-700 underline">Log in</a>--}}
{{--                <a href="{{ '' }}" class="ml-4 text-sm text-gray-700 underline">Register</a>--}}
            </div>

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" style="width: 100%">
                @yield('CONTENTS')
            </div>
        </div>
    </body>
</html>
