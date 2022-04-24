<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>

	<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <h1> 路由、中间件</h1>
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">

            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-6">
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/demo/index"  target="_blank" class="underline text-gray-900 dark:text-white">/demo/index 解析到DemoController index</a>
                    </div>
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/demo/1"  target="_blank" class="underline text-gray-900 dark:text-white">/demo/{id} 解析到闭包函数 id 是数值</a>
                    </div>
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/demo/a"  target="_blank" class="underline text-gray-900 dark:text-white">/demo/{id} 解析到闭包函数 id 不是数值</a>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                    <h2>/posts/{post}/comments/{comment} 解析到闭包函数</h2>

                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/posts/1/comments/2"  target="_blank" class="underline text-gray-900 dark:text-white">/posts/1/comments/2</a>
                    </div>
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/posts/1/comments/b"  target="_blank" class="underline text-gray-900 dark:text-white">/posts/1/comments/b</a>
                    </div>
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/posts/a/comments/2"  target="_blank" class="underline text-gray-900 dark:text-white">/posts/a/comments/2</a>
                    </div>
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/posts/a/comments/b"  target="_blank" class="underline text-gray-900 dark:text-white">/posts/a/comments/b</a>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    <h2>/userTest/{name} 正则表达式约束</h2>

                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/userTest/11"  target="_blank" class="underline text-gray-900 dark:text-white">/userTest/11</a>
                    </div>
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/userTest/aa"  target="_blank" class="underline text-gray-900 dark:text-white">/userTest/aa></a>
                    </div>
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/userTest/22"  target="_blank" class="underline text-gray-900 dark:text-white">/userTest/22</a>
                    </div>
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/userTest/bb"  target="_blank" class="underline text-gray-900 dark:text-white">/userTest/bb</a>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                    <h2>/userTest/{id}/{name} 正则表达式约束</h2>

                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/userTest/11/66"  target="_blank" class="underline text-gray-900 dark:text-white">/userTest/11/66</a>
                    </div>
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/userTest/22/99"  target="_blank" class="underline text-gray-900 dark:text-white">/userTest/22/99</a>
                    </div>
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/userTest/33/aa"  target="_blank" class="underline text-gray-900 dark:text-white">/userTest/33/aa</a>
                    </div>
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/userTest/44/bb"  target="_blank" class="underline text-gray-900 dark:text-white">/userTest/44/bb</a>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/health"  target="_blank" class="underline text-gray-900 dark:text-white">心跳检测</a>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                    <h2>中间件</h2>
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/middleware/index"  target="_blank" class="underline text-gray-900 dark:text-white">/middleware/index base special_auth 中间件</a>
                    </div>
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <a href="/middleware/detail"  target="_blank" class="underline text-gray-900 dark:text-white">/middleware/detail base special_handle 中间件</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
            <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </div>

    </div>
</x-app-layout>

