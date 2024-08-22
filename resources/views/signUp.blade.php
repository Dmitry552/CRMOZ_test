<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @vite('resources/css/app.css')
    </head>
    <body class="antialiased">
        <script>
            if (localStorage.getItem('token')) window.location.href = '/';
        </script>
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div
                class="w-full bg-white rounded-lg shadow-md dark:border md:mt-0 sm:max-w-md xl:p-0"
            >
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-500">
                        Register a new account
                    </h1>
                    <div
                        class="space-y-4 md:space-y-6 flex w-auto justify-center gap-4"
                    >
                        <button
                            type="button"
                            onclick="window.location='{{route('redirect')}}'"
                            class="inline-block rounded px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white
                                      shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg
                                      focus:outline-none focus:ring-0 active:shadow-lg"
                            style="background-color: white"
                        >
                            <img src="zoho.png" alt="zoho" class="w-40">
                        </button>
                    </div>
                    <p class="text-sm font-light text-gray-500">
                        Already have an account?
                        <a class="font-medium text-primary-600 hover:underline" href={{route('login')}}>Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
