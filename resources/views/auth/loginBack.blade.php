{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>เข้าสู่ระบบ | SRICHANDxBamBam</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/srichan.css') }}?v={{ time() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/jpeg" href="{{ url('img/srichand/cropped-logo-srichand-1-192x192.jpeg') }}" />
  <style>
    body {
      background: linear-gradient(to bottom right, #4d0000, #1a0000);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
    }

    .login-card {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      color: #333;
      padding: 30px;
      width: 100%;
      max-width: 480px;
    }

    .header-logo {
      text-align: center;
      margin-bottom: 20px;
    }

    .header-logo img {
      height: 60px;
    }

    .btn-primary {
      background-color: #004aad;
      border: none;
    }

    .btn-primary:hover {
      background-color: #003a91;
    }

    .form-check-label {
      color: #555;
    }
  </style>
</head>
<body>

  <div class="login-card">

    <h4 class="text-center mb-4">เข้าสู่ระบบ</h4>
    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
        @error('username')
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
               name="password" required autocomplete="current-password">
        @error('password')
          <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
      </div>

      <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember"
               {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="remember">จำฉันไว้</label>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
      </div>
    </form>
  </div>

</body>
</html>
