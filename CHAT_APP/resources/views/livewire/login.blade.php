<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('assets/wallpaper3.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .content-wrapper {
            flex: 1;
        }
        .login-container {
            max-width: 900px;
            margin: 50px auto;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: auto;
            background-color: #fff;
        }
        .left-section {
            flex: 1;
            background-color: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .left-section img {
            max-width: 100%;
            height: auto;
        }
        .right-section {
            flex: 1;
            background-color: #2279d6;
            color: #fff;
            padding: 40px;
        }
        .right-section h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-control {
            border-radius: 25px;
            padding: 15px;
        }
        .btn-primary {
            background-color: #1256bc;
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #0b3c8b;
        }
        .forgot-password {
            text-decoration: none;
            color: #fff;
            font-size: 14px;
            display: block;
            text-align: center;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
        .navbar {
            background: linear-gradient(to right, #ffffff, #d3d3d3); /* Gradient from white to grey */
            color: black; 
            padding: 0.3rem 1rem;
        }
        .footer {
            background: linear-gradient(to right, #d3d3d3, #ffffff); /* Gradient from white to grey */
            color: #6c757d; /* Dark text color */
            text-align: center;
            padding:0.4rem 1rem;
            margin-top: auto;
        }
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
            }
            .left-section, .right-section {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <nav class="navbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/Logo.png') }}" alt="SLT Logo" width="80">
                </a>
            </div>
        </nav>
        <div class="login-container">
            <div class="left-section">
                <img src="{{ asset('assets/slt_logo.png') }}" alt="SLT Logo">
            </div>
            <div class="right-section">
                <h2>Login</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="emp_id" class="form-label">Username</label>
                        <input type="text" id="emp_id" class="form-control" name="emp_id" value="{{ old('emp_id') }}" placeholder="Enter your username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="mb-3">
                        <a href="#" class="forgot-password" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Forgot your Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                @if ($errors->has('emp_id'))
                <div class="alert alert-danger mt-3">
                    {{ $errors->first('emp_id') }}
                </div>
            @endif
            @if ($errors->has('password'))
                <div class="alert alert-danger mt-3">
                    {{ $errors->first('password') }}
                </div>
            @endif
            </div>
        </div>
    </div>

    <div class="footer">
        {{ date('Y') }} SLT. All rights reserved.
    </div>

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title fw-bold" id="forgotPasswordModalLabel">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="forgotEmail" class="form-label">Enter your email</label>
                            <input type="email" id="forgotEmail" class="form-control" placeholder="Email address" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
