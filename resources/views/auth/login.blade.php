<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        background-color: #111;
        color: #fff;
        font-family: Arial, sans-serif;
    }
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
    }
    .login-card {
        background: #1c1c1c;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0,0,0,0.6);
        display: flex;
        flex-direction: row;
        max-width: 900px;
        width: 100%;
    }
    .login-left img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* biar tetap proporsional */
        display: block;
    }
    .login-left {
        flex: 1;
        min-height: 250px;
    }
    .login-right {
        flex: 1;
        padding: 40px;
    }
    .login-right h2 {
        font-weight: bold;
        margin-bottom: 20px;
        color: #fff;
    }
    .form-control {
        background-color: #2c2c2c;
        border: none;
        color: #fff;
    }
    .form-control:focus {
        background-color: #333;
        color: #fff;
        border-color: #ff6600;
        box-shadow: none;
    }
    .btn-login {
        background-color: #ff6600;
        border: none;
        font-weight: bold;
        width: 100%;
    }
    .btn-login:hover {
        background-color: #e65c00;
    }
    .social-btn {
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        margin: 0 8px;
    }
    .social-btn img {
        width: 20px;
        height: 20px;
    }
    .register-link {
        margin-top: 15px;
        font-size: 0.9rem;
        color: #bbb;
    }
    .register-link a {
        color: #ff6600;
        font-weight: bold;
        text-decoration: none;
    }

    /* === Responsive Breakpoints === */
    @media (max-width: 768px) {
        .login-card {
            flex-direction: column;
        }
        .login-left {
            min-height: 180px;
        }
        .login-right {
            padding: 25px;
        }
        .btn-login {
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .login-right h2 {
            font-size: 1.5rem;
        }
        .social-btn {
            width: 40px;
            height: 40px;
            margin: 0 5px;
        }
    }
  </style>
</head>
<body>
<div class="container login-container">
  <div class="login-card">
    <!-- Left Side Image (Responsive) -->
    <div class="login-left">
      <img src="{{ asset('img/j96.jpg') }}" alt="Login Image" class="img-fluid">
    </div>

    <!-- Right Side Form -->
    <div class="login-right">
      <h2>Login</h2>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control">
          @error('email')
              <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label for="password" class="form-label">Password:</label>
          <input id="password" type="password" name="password" required class="form-control">
          @error('password')
              <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="d-flex justify-content-between mb-3 flex-wrap">
          <div>
            <input type="checkbox" name="remember" id="remember_me">
            <label for="remember_me">Remember me</label>
          </div>
          @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="text-warning">Forgot Password?</a>
          @endif
        </div>

        <button type="submit" class="btn btn-login btn-lg">Sign in</button>
      </form>

      <!-- Social Login -->
      <div class="text-center mt-4">
        <p>or continue with</p>
        <div class="d-flex justify-content-center flex-wrap">
          <a href="#" class="social-btn"><img src="{{ asset('img/google.png') }}" alt="Google"></a>
          <a href="#" class="social-btn"><img src="{{ asset('img/github.png') }}" alt="Github"></a>
          <a href="#" class="social-btn"><img src="{{ asset('img/facebook.png') }}" alt="Facebook"></a>
        </div>
      </div>

      <!-- Register -->
      <div class="text-center register-link">
        Don’t have an account yet? <a href="{{ route('register') }}">Register for free</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
