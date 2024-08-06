<x-guest-layout>

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-header d-flex justify-content-center">
                        <a href="/admin/dashboard" class="app-brand-link">
                            <span class="app-brand-logo demo">
                                <img src="{{ asset('logo.png') }}" class="img-fluid" width="140">
                            </span>
                        </a>
                    </div>

                    @if (session()->has('message'))
                        {{ session('message') }}
                    @endif

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.password.store') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Address -->

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" type="email" name="email" requiired
                                    value="{{ old('email', $request->email) }}" placeholder="Enter your email"
                                    autofocus />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" requiired
                                    placeholder="Password" autofocus />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" requiired
                                    placeholder="Confirm Password" autofocus />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    {{-- <form method="POST" action="{{ route('admin.password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form> --}}
</x-guest-layout>
