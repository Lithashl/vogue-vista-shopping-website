@extends('layouts.auth')

@section('title', 'Create Account')

@section('panel-quote', 'Clothes mean nothing until someone lives in them.')
@section('panel-cite', 'Marc Jacobs')

@section('form-content')

  <p class="auth-form-title">Create account</p>
  <p class="auth-form-sub">Join VogueVista and start shopping the latest trends.</p>

  <form method="POST" action="{{ route('register') }}">
    @csrf

    {{-- Name --}}
    <div class="auth-input-group">
      <label class="auth-label" for="name">Full Name</label>
      <input
        id="name"
        type="text"
        name="name"
        class="auth-input @error('name') is-invalid @enderror"
        value="{{ old('name') }}"
        required
        autocomplete="name"
        autofocus
        placeholder="Your full name"
      >
      @error('name')
        <div class="auth-error"><i class="fa fa-exclamation-circle me-1"></i>{{ $message }}</div>
      @enderror
    </div>

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
        placeholder="you@example.com"
      >
      @error('email')
        <div class="auth-error"><i class="fa fa-exclamation-circle me-1"></i>{{ $message }}</div>
      @enderror
    </div>

    {{-- Password --}}
    <div class="auth-input-group">
      <label class="auth-label" for="password">Password</label>
      <input
        id="password"
        type="password"
        name="password"
        class="auth-input @error('password') is-invalid @enderror"
        required
        autocomplete="new-password"
        placeholder="At least 8 characters"
      >
      @error('password')
        <div class="auth-error"><i class="fa fa-exclamation-circle me-1"></i>{{ $message }}</div>
      @enderror
    </div>

    {{-- Confirm password --}}
    <div class="auth-input-group" style="margin-bottom:24px;">
      <label class="auth-label" for="password-confirm">Confirm Password</label>
      <input
        id="password-confirm"
        type="password"
        name="password_confirmation"
        class="auth-input"
        required
        autocomplete="new-password"
        placeholder="Repeat your password"
      >
    </div>

    <button type="submit" class="auth-btn">Create Account</button>
  </form>

  <div class="auth-link-row">
    Already have an account? <a href="{{ route('login') }}">Sign in</a>
  </div>

@endsection
