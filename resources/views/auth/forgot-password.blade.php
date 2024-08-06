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
                    <div class="card-body">
                        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </div>
                        @if(session()->has('message'))
                        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400" style="color:red">
                            {{ session('message') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('admin.password.email') }}">
                            @csrf

                            <!-- Email Address -->
                            <div>

                                <div class="mb-3">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" type="email" name="email" requiired
                                        :value="old('email')" placeholder="Enter your email" autofocus />
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">
                                    {{ __('Email Password Reset Link') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

</x-guest-layout>
