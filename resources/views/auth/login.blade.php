@extends('layouts.auth')

@section('title', 'Sign In')

@section('panel-quote', 'Style is a way to say who you are without having to speak.')
@section('panel-cite', 'Rachel Zoe')

@section('form-content')

  <p class="auth-form-title">Welcome back</p>
  <p class="auth-form-sub">Sign in to your VogueVista account to continue.</p>

  {{-- Success from registration --}}
  @if (session('registered'))
    <div class="auth-alert-success">
      <i class="fa fa-check-circle me-2"></i>
      Account created! Please sign in to continue.
    </div>
  @endif

  {{-- Generic status --}}
  @if (session('status'))
    <div class="auth-alert-success">
      <i class="fa fa-check-circle me-2"></i>
      {{ session('status') }}
    </div>
  @endif

  {{-- Global error (e.g. too many attempts) --}}
  @error('email')
    @if ($message !== 'These credentials do not match our records.')
      <div class="auth-alert-error">
        <i class="fa fa-exclamation-circle me-2"></i>{{ $message }}
      </div>
    @endif
  @enderror

  <form method="POST" action="{{ route('login') }}">
    @csrf

    {{-- Email --}}
    <div class="auth-input-group">
      <label class="auth-label" for="email">Email Address</label>
      <input
        id="email"
        type="email"
        name="email"
        class="auth-input @error('email') is-invalid @enderror"
        value="{{ old('email') }}"
        required
        autocomplete="email"
        autofocus
        placeholder="you@example.com"
      >
      @error('email')
        <div class="auth-error"><i class="fa fa-exclamation-circle me-1"></i>{{ $message }}</div>
      @enderror
    </div>

    {{-- Password --}}
    <div class="auth-input-group">
      <div class="d-flex justify-content-between align-items-center" style="margin-bottom:6px;">
        <label class="auth-label mb-0" for="password">Password</label>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="auth-forgot">Forgot password?</a>
        @endif
      </div>
      <input
        id="password"
        type="password"
        name="password"
        class="auth-input @error('password') is-invalid @enderror"
        required
        autocomplete="current-password"
        placeholder="••••••••"
      >
      @error('password')
        <div class="auth-error"><i class="fa fa-exclamation-circle me-1"></i>{{ $message }}</div>
      @enderror
    </div>

    {{-- Remember me --}}
    <div class="auth-check-wrap">
      <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
      <label for="remember">Keep me signed in</label>
    </div>

    <button type="submit" class="auth-btn">Sign In</button>
  </form>

  <div class="auth-link-row">
    Don't have an account? <a href="{{ route('register') }}">Create one</a>
  </div>

@endsection
