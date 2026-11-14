<x-guest-layout>
    <p class="login-box-msg">
        You forgot your password? Enter your email and we'll send you a reset link.
    </p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="input-group mb-3 has-validation">
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Email" required autofocus />
            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Send reset link</button>
        </div>
    </form>

    <p class="mt-3 mb-0">
        <a href="{{ route('login') }}">Back to login</a>
    </p>
</x-guest-layout>
