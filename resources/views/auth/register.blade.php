<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        background-color: #111;
        color: #fff;
        font-family: Arial, sans-serif;
    }
    .register-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
    }
    .register-card {
        background: #1c1c1c;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0,0,0,0.6);
        display: flex;
        flex-direction: row;
        max-width: 1000px;
        width: 100%;
    }
    .register-left {
        flex: 1;
        min-height: 250px;
    }
    .register-left img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* menjaga proporsi */
        display: block;
    }
    .register-right {
        flex: 1;
        padding: 40px;
    }
    .register-right h2 {
        font-weight: bold;
        margin-bottom: 20px;
        color: #fff;
    }
    .form-control, select {
        background-color: #2c2c2c;
        border: none;
        color: #fff;
    }
    .form-control:focus, select:focus {
        background-color: #333;
        color: #fff;
        border-color: #ff6600;
        box-shadow: none;
    }
    .btn-register {
        background-color: #ff6600;
        border: none;
        font-weight: bold;
        width: 100%;
    }
    .btn-register:hover {
        background-color: #e65c00;
    }
    .login-link {
        margin-top: 15px;
        font-size: 0.9rem;
        color: #bbb;
    }
    .login-link a {
        color: #ff6600;
        font-weight: bold;
        text-decoration: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .register-card {
            flex-direction: column;
        }
        .register-left {
            min-height: 180px;
        }
        .register-right {
            padding: 25px;
        }
    }

    @media (max-width: 480px) {
        .register-right h2 {
            font-size: 1.5rem;
        }
    }
  </style>
</head>
<body>
<div class="container register-container">
  <div class="register-card">
    <!-- Left Side Image (Responsive) -->
    <div class="register-left">
      <img src="{{ asset('img/j96.jpg') }}" alt="Register Image" class="img-fluid">
    </div>

    <!-- Right Side Form -->
    <div class="register-right">
      <h2>Register</h2>

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
          <label for="name" class="form-label">Name:</label>
          <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="form-control">
          @error('name')
              <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-control">
          @error('email')
              <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <!-- Role -->
        <div class="mb-3">
          <label for="role" class="form-label">Daftar Sebagai:</label>
          <select id="role" name="role" class="form-control" required>
              <option value="">-- Pilih Role --</option>
              <option value="pelanggan" {{ old('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
              <option value="pegawai" {{ old('role') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
              <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
          </select>
          @error('role')
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

        <!-- Confirm Password -->
        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirm Password:</label>
          <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control">
          @error('password_confirmation')
              <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <button type="submit" class="btn btn-register btn-lg">Register</button>
      </form>

      <!-- Login Link -->
      <div class="text-center login-link">
        Already registered? <a href="{{ route('login') }}">Login here</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
