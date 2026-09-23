@extends('layouts.app')

@section('title', 'Login - HoneyBee Market')

@section('content')
<div class="min-h-[calc(100vh-80px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-950">
    <div class="w-full max-w-md space-y-6">
        
        {{-- Header Section --}}
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">
                Welcome <span class="text-amber-400">Back</span>
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                Log in to manage your listings and messages
            </p>
        </div>

        {{-- Card Body --}}
        <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 sm:p-8 shadow-2xl shadow-black/60">
            
            @if (session('status'))
                <div class="mb-5 p-3 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs text-center font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email Field --}}
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                        Email Address
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                        placeholder="you@example.com"
                        class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700/80 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none transition-all placeholder-gray-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                            Password
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-amber-400 hover:text-amber-300 font-medium transition-colors">
                                Forgot?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required 
                        placeholder="••••••••"
                        class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-3 border border-gray-700/80 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none transition-all placeholder-gray-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember_me" class="w-4 h-4 rounded border-gray-700 bg-gray-800 text-amber-500 focus:ring-amber-500/30 focus:ring-offset-gray-900 cursor-pointer">
                    <label for="remember_me" class="ml-2.5 text-sm text-gray-400 cursor-pointer select-none">Remember me</label>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-gray-950 font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-amber-500/20 hover:shadow-amber-500/35 transition-all text-sm active:scale-[0.98]">
                    Log In
                </button>
            </form>

            {{-- Footer Register Redirect --}}
            <div class="mt-8 pt-6 border-t border-gray-800/80 text-center">
                <p class="text-sm text-gray-400">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-amber-400 hover:text-amber-300 font-semibold transition-colors ml-1">
                        Sign up for free →
                    </a>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection