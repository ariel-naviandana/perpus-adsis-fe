<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Perpustakaan Digital</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <h1>Login</h1>
    <form id="loginForm">
        @csrf
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />
        <br />
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />
        <br />
        <button type="submit">Login</button>
    </form>
    <p id="errorMessage" style="color:red;"></p>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const token = document.querySelector('input[name="_token"]').value;

            axios.post("{{ route('login') }}", {
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
