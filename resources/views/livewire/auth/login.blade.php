<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<!-- Trik CSS untuk membobol container parent auth layout -->
<div class="fixed inset-0 z-50 min-h-screen w-screen flex flex-col md:flex-row bg-gray-100 overflow-y-auto">
    <!-- Left Branding Section (Red Side) -->
    <div class="w-full md:w-5/12 bg-[#E52B1E] text-white p-8 md:p-12 flex flex-col justify-between">
        <div>
            <!-- Header / Logo -->
            <div class="flex items-center space-x-2 font-bold text-xl tracking-wider uppercase mb-12">
                <span class="inline-block w-4 h-4 bg-white"></span>
                <span>Kantin Teknik</span>
            </div>

            <!-- Headline -->
            <h1 class="text-3xl md:text-5xl font-black leading-tight mb-6">
                Satu kantin.<br>
                Banyak dapur.<br>
                Satu sistem.
            </h1>
            <p class="text-sm opacity-90">
                Portal tenant & pengelola — Universitas Nusantara
            </p>
        </div>

        <!-- Badges Footer -->
        <div class="mt-8 md:mt-12 text-xs font-semibold tracking-widest text-white/80">
            MULTI-TENANT • QRIS • REAL-TIME
        </div>
    </div>

    <!-- Right Form Section (White Side) -->
    <div class="w-full md:w-7/12 bg-gray-50 p-8 md:p-16 flex items-center justify-center">
        <div class="w-full max-w-md space-y-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Masuk</h2>
                <p class="text-sm text-gray-600 mt-1">Gunakan akun tenant atau pengelola Anda.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <form wire:submit="login" class="space-y-4">
                <!-- Surel (Email) -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Surel</label>
                    <input wire:model="email" id="email" type="email" name="email" required autofocus
                        class="mt-1 block w-full px-3 py-2 border border-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-red-600 text-gray-900"
                        placeholder="[email protected]">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kata Sandi -->
                <div x-data="{ show: false }">
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata sandi</label>
                    <div class="relative mt-1">
                        <input :type="show ? 'text' : 'password'" wire:model="password" id="password" name="password" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-red-600 text-gray-900">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs text-gray-500 hover:text-gray-700">
                            <span x-text="show ? 'Sembunyikan' : 'Tampilkan'"></span>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rate Limiting Notice -->
                <p class="text-xs text-gray-500 leading-relaxed">
                    5x gagal dalam 10 menit → akun terkunci 15 menit. Sesi berakhir setelah 8 jam tidak aktif.
                </p>

                <!-- Tombol Masuk -->
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#E52B1E] hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Masuk →
                    </button>
                </div>

                <!-- Lupa Kata Sandi -->
                <div class="text-left pt-2">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-[#E52B1E] hover:underline">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>