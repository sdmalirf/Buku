@extends('main')
@section("container")

<section id="registerModal" class="w-full fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50" aria-hidden="true">
    <div class="bg-white rounded-xl w-3/4 px-12 py-8 relative overflow-hidden">

        <div class="w-full justify-between flex">
            <div class="flex flex-col gap-2">
                <h2 class="text-5xl font-bold">Register</h2>
                <p class="text-xl mb-4">Create your account!</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="flex w-1/2 flex-col gap-4">
                @csrf
                <input
                    type="text"
                    name="name"
                    :value="old('name')"
                    required autofocus autocomplete="name"
                    class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                    placeholder="Your Name">

                <input
                    type="email"
                    name="email"
                    :value="old('email')"
                    required autocomplete="username"
                    class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                    placeholder="Your Email">

                <input
                    type="password"
                    name="password"
                    required autocomplete="new-password"
                    class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                    placeholder="Your Password">

                <input
                    type="password"
                    name="password_confirmation"
                    required autocomplete="new-password"
                    class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2"
                    placeholder="Confirm Password">

                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                <div class="flex gap-2">
                    <button class="bg-blue-400 w-fit px-12 py-3 rounded-full text-white font-medium" type="submit">{{ __('Register') }}</button>
                    <a class="border-2 text-gray-500 px-6 py-2 rounded-full font-semibold" href="/login">{{ __('Already registered?') }}</a>
                </div>
            </form>
        </div>
        <img src="{{ asset('images/double-star.png') }}" alt="Logo" class="w-1/3 absolute -bottom-40 -left-10 z-40" />
    </div>
</section>

@endsection