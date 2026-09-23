@extends('layouts.app')

@section('title', 'Register - HoneyBee Market')

@section('content')
<div class="min-h-[calc(100vh-80px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-950">
    <div class="w-full max-w-md space-y-6">
        
        {{-- Header Section --}}
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">
                Create Your <span class="text-amber-400">Account</span>
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                Join thousands of buyers and sellers today
            </p>
        </div>

        {{-- Card Body --}}
        <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 sm:p-8 shadow-2xl shadow-black/60">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- Full Name --}}
                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-1.5">
                        Full Name
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                        placeholder="John Doe"
                        class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-2.5 border border-gray-700/80 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none transition-all placeholder-gray-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Address --}}
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-1.5">
                        Email Address
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                        placeholder="you@example.com"
                        class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-2.5 border border-gray-700/80 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none transition-all placeholder-gray-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-1.5">
                        Password
                    </label>
                    <input id="password" type="password" name="password" required 
                        placeholder="Minimum 8 characters"
                        class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-2.5 border border-gray-700/80 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none transition-all placeholder-gray-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-1.5">
                        Confirm Password
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required 
                        placeholder="Re-enter password"
                        class="w-full bg-gray-800/80 text-gray-100 text-sm rounded-xl px-4 py-2.5 border border-gray-700/80 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none transition-all placeholder-gray-500">
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-gray-950 font-bold py-3 px-4 rounded-xl shadow-lg shadow-amber-500/20 hover:shadow-amber-500/35 transition-all text-sm mt-3 active:scale-[0.98]">
                    Create Account
                </button>
            </form>

            {{-- Footer Login Redirect --}}
            <div class="mt-6 pt-5 border-t border-gray-800/80 text-center">
                <p class="text-sm text-gray-400">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-amber-400 hover:text-amber-300 font-semibold transition-colors ml-1">
                        Log in here →
                    </a>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection