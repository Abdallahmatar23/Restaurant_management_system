<x-guest-layout>
    <p class="login-box-msg">Sign in to start your session</p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group mb-3 has-validation">
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Email" required autofocus autocomplete="username" />
            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group mb-3 has-validation">
            <input id="password" type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Password" required autocomplete="current-password" />
            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-8">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me" />
                    <label class="form-check-label" for="remember_me">Remember Me</label>
                </div>
            </div>
            <div class="col-4">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
            </div>
        </div>
    </form>

    @if (Route::has('password.request'))
        <p class="mb-0 mt-3">
            <a href="{{ route('password.request') }}">I forgot my password</a>
        </p>
    @endif
</x-guest-layout>
