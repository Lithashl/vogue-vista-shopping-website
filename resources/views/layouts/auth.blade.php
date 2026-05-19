<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>VogueVista — @yield('title')</title>
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800|Playfair+Display:700,700i" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body { height: 100%; margin: 0; }
    body { font-family: 'Nunito', sans-serif; background: #fff; }

    .auth-wrap {
      display: flex;
      min-height: 100vh;
    }

    /* ── Left panel ── */
    .auth-panel {
      flex: 0 0 42%;
      background: #1a1a1a;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 48px 52px;
      position: relative;
      overflow: hidden;
    }
    .auth-panel::before {
      content: '';
      position: absolute;
      inset: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400"><circle cx="320" cy="80" r="200" fill="none" stroke="rgba(255,255,255,0.04)" stroke-width="80"/><circle cx="60" cy="340" r="160" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="60"/></svg>') no-repeat center/cover;
      pointer-events: none;
    }
    .auth-brand {
      font-family: 'Playfair Display', serif;
      font-size: 26px;
      font-weight: 700;
      color: #fff;
      letter-spacing: 1px;
      text-decoration: none;
    }
    .auth-brand:hover { color: #e8e8e8; }
    .auth-panel-quote {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 40px 0;
    }
    .auth-panel-quote blockquote {
      margin: 0;
      font-family: 'Playfair Display', serif;
      font-size: 28px;
      font-style: italic;
      color: #fff;
      line-height: 1.4;
      border: none;
      padding: 0;
    }
    .auth-panel-quote blockquote::before {
      content: '\201C';
      font-size: 60px;
      color: rgba(255,255,255,0.18);
      display: block;
      line-height: 1;
      margin-bottom: -12px;
    }
    .auth-panel-quote cite {
      display: block;
      margin-top: 20px;
      font-size: 11px;
      font-weight: 800;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: rgba(255,255,255,0.45);
      font-style: normal;
    }
    .auth-panel-footer {
      font-size: 12px;
      color: rgba(255,255,255,0.3);
      letter-spacing: 0.5px;
    }

    /* ── Right form area ── */
    .auth-form-area {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 48px 40px;
      background: #fff;
    }
    .auth-form-inner {
      width: 100%;
      max-width: 400px;
    }
    .auth-form-title {
      font-family: 'Playfair Display', serif;
      font-size: 30px;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 6px;
    }
    .auth-form-sub {
      font-size: 13px;
      color: #6b7280;
      margin-bottom: 32px;
    }

    /* Inputs */
    .auth-input-group { margin-bottom: 20px; }
    .auth-label {
      display: block;
      font-size: 11px;
      font-weight: 800;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: #1a1a1a;
      margin-bottom: 6px;
    }
    .auth-input {
      display: block;
      width: 100%;
      padding: 12px 14px;
      font-size: 14px;
      font-family: 'Nunito', sans-serif;
      color: #1a1a1a;
      background: #fff;
      border: 1.5px solid #e8e8e8;
      border-radius: 0;
      outline: none;
      transition: border-color 0.2s;
    }
    .auth-input:focus { border-color: #1a1a1a; }
    .auth-input.is-invalid { border-color: #dc2626; }
    .auth-error {
      font-size: 12px;
      color: #dc2626;
      margin-top: 5px;
    }

    /* Checkbox */
    .auth-check-wrap {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 24px;
    }
    .auth-check-wrap input[type=checkbox] {
      width: 16px;
      height: 16px;
      accent-color: #1a1a1a;
      cursor: pointer;
      flex-shrink: 0;
    }
    .auth-check-wrap label {
      font-size: 13px;
      color: #6b7280;
      cursor: pointer;
      margin: 0;
    }

    /* Submit button */
    .auth-btn {
      display: block;
      width: 100%;
      padding: 13px;
      background: #1a1a1a;
      color: #fff;
      font-size: 12px;
      font-weight: 800;
      letter-spacing: 2px;
      text-transform: uppercase;
      border: none;
      border-radius: 0;
      cursor: pointer;
      transition: background 0.2s;
      font-family: 'Nunito', sans-serif;
    }
    .auth-btn:hover { background: #333; }
    .auth-btn:disabled { opacity: 0.6; cursor: not-allowed; }

    /* Divider */
    .auth-divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 24px 0;
      color: #e8e8e8;
      font-size: 12px;
    }
    .auth-divider::before, .auth-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #e8e8e8;
    }
    .auth-divider span { color: #9ca3af; white-space: nowrap; }

    /* Links */
    .auth-link-row {
      text-align: center;
      font-size: 13px;
      color: #6b7280;
      margin-top: 20px;
    }
    .auth-link-row a {
      color: #1a1a1a;
      font-weight: 800;
      text-decoration: none;
      border-bottom: 1.5px solid #1a1a1a;
      padding-bottom: 1px;
    }
    .auth-link-row a:hover { color: #444; border-color: #444; }

    /* Forgot link */
    .auth-forgot {
      font-size: 12px;
      color: #6b7280;
      text-decoration: none;
      border-bottom: 1px solid #d1d5db;
      padding-bottom: 1px;
    }
    .auth-forgot:hover { color: #1a1a1a; border-color: #1a1a1a; }

    /* Alert */
    .auth-alert-success {
      background: #f0fdf4;
      border: 1.5px solid #bbf7d0;
      padding: 12px 16px;
      font-size: 13px;
      color: #166534;
      margin-bottom: 24px;
    }
    .auth-alert-error {
      background: #fff1f2;
      border: 1.5px solid #fecdd3;
      padding: 12px 16px;
      font-size: 13px;
      color: #9f1239;
      margin-bottom: 24px;
    }

    /* Mobile: hide left panel, show mini brand header */
    .auth-mobile-brand {
      display: none;
      text-align: center;
      padding: 28px 24px 0;
    }
    .auth-mobile-brand a {
      font-family: 'Playfair Display', serif;
      font-size: 24px;
      font-weight: 700;
      color: #1a1a1a;
      text-decoration: none;
    }

    @media (max-width: 768px) {
      .auth-panel { display: none; }
      .auth-mobile-brand { display: block; }
      .auth-wrap { flex-direction: column; }
      .auth-form-area {
        padding: 28px 24px 48px;
        align-items: flex-start;
      }
      .auth-form-title { font-size: 26px; }
    }
  </style>
</head>
<body>
  <div class="auth-wrap">

    {{-- Left brand panel --}}
    <div class="auth-panel">
      <a href="/" class="auth-brand">VogueVista</a>
      <div class="auth-panel-quote">
        <blockquote>
          @yield('panel-quote', 'Fashion is the armor to survive the reality of everyday life.')
        </blockquote>
        <cite>@yield('panel-cite', 'Bill Cunningham')</cite>
      </div>
      <div class="auth-panel-footer">&copy; {{ date('Y') }} VogueVista. All rights reserved.</div>
    </div>

    {{-- Right form area --}}
    <div class="auth-form-area">
      <div class="auth-mobile-brand">
        <a href="/">VogueVista</a>
      </div>
      <div class="auth-form-inner">
        @yield('form-content')
      </div>
    </div>

  </div>

  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" defer></script>
</body>
</html>
