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
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" type="email" name="email" requiired
                                    :value="old('email')" placeholder="Enter your email" autofocus />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label for="email" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" required
                                        autocomplete="current-password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <a href="{{ route('admin.password.request') }}">
                                    <small>Forgot Password?</small>
                                </a>
                            </div>
                            <div class="mb-3">
                                <button class="btn d-grid w-100" type="submit"
                                    style="background: #0EA7C1; color:white">{{ __('Log in') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

</x-guest-layout>
