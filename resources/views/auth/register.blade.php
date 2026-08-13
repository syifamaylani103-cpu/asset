<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Asset Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            padding: 2.5rem;
            width: 100%;
            max-width: 480px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <div class="login-card my-5">
        <div class="login-header">
            <h1>Create an Account</h1>
            <p>Join us to start managing your assets</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger" style="border-radius: 8px; font-size: 0.9rem;">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Password</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Min. 8 characters">
            </div>
            
            <div class="mb-4">
                <label for="password_confirmation" class="form-label text-muted fw-semibold" style="font-size: 0.85rem;">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Confirm your password">
            </div>

            <button type="submit" class="btn btn-primary">Sign Up</button>
            
            <div class="text-center mt-4">
                <p class="text-muted" style="font-size: 0.9rem;">
                    Already have an account? <a href="{{ route('login') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Sign In here</a>
                </p>
            </div>
        </form>
    </div>

</body>
</html>
