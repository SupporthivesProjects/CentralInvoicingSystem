<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 40px; max-width: 400px; margin: auto;">

    <h2>Login</h2>

    @if(session('success'))
        <div style="color: green; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <div style="margin-bottom: 15px;">
            <label>Email:</label><br>
            <input type="email" name="email" required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Password:</label><br>
            <input type="password" name="password" required style="width: 100%; padding: 8px;">
        </div>

        <button type="submit" style="padding: 10px 20px;">Login</button>
    </form>

</body>
</html>
