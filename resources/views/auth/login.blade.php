<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Perpustakaan Digital</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            background: #e9ecef;
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: #fff;
            padding: 32px 32px 24px 32px;
            border-radius: 12px;
            box-shadow: 0 0 16px rgba(0,0,0,0.08);
            min-width: 350px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 18px;
        }
        label {
            color: #555;
            font-weight: 500;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin: 8px 0 18px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1em;
        }
        button {
            width: 100%;
            background: #007bff;
            color: #fff;
            padding: 11px;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover {
            background: #0056b3;
        }
        #errorMessage {
            text-align: center;
            margin-top: 14px;
            color: #e53935;
            min-height: 24px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form id="loginForm">
            @csrf
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required />
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required />
            <button type="submit">Login</button>
        </form>
        <p id="errorMessage"></p>
    </div>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const token = document.querySelector('input[name="_token"]').value;

            axios.post("{{ route('login.post') }}", {
                email: email,
                password: password,
                _token: token
            })
            .then(response => {
                if (response.data.success) {
                    window.location.href = response.data.redirect_url;
                } else {
                    document.getElementById('errorMessage').innerText = response.data.message || 'Login gagal';
                }
            })
            .catch(error => {
                if (error.response && error.response.data && error.response.data.message) {
                    document.getElementById('errorMessage').innerText = error.response.data.message;
                } else {
                    document.getElementById('errorMessage').innerText = 'Terjadi kesalahan pada server.';
                }
            });
        });
    </script>
</body>
</html>
