@extends('main')
@section("container")



<section id="taskModal" class=" w-full fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50" aria-hidden="true">
    <div class="bg-white rounded-xl w-3/4 px-12 py-8 relative overflow-hidden">

        <div class="w-full justify-between flex">
            <div class="flex flex-col gap-2">
                <h2 class="text-5xl font-bold">Login</h2>
                <p class="text-xl mb-4">Fill your account please!</p>
            </div>


            <form method="POST" action="{{ route('login') }}" class="flex w-1/2 flex-col gap-4">
                @csrf
                <input
                    type="text"
                    name="email"
                    :value="old('email')"
                    required autofocus autocomplete="username"
                    class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                    placeholder="Your Email">

                <input
                    type="password"
                    name="password"
                    required autocomplete="current-password"
                    class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                    placeholder="Subject or Topic">

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />



                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                @if (Route::has('password.request'))
                <a class="underline text-sm text-black hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif


                <div class="flex gap-2">
                    <button class="bg-blue-400 w-fit px-12 py-3 rounded-full text-white font-medium" type="submit">{{ __('Log in') }}</button>
                    <a class="border-2 text-gray-500 px-6 py-2 rounded-full font-semibold" href="/register" type="submit">Register</a>
                </div>
            </form>
        </div>
        <img src="{{ asset('images/double-star.png') }}" alt="Logo" class="w-1/3 absolute -bottom-40 -left-10 z-40" />
    </div>
</section>




@endsection