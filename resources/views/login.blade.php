<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dmamah | Login</title>
    <link rel="stylesheet" href="{{ asset('css/Loginstyle.css') }}" />
</head>

<body>

    <div class="login-container">
        <h1>LOGIN</h1>
        <form action="login" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Username</label>
                <input type="text" id="name" name="name" required />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required />
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger" style="width: 100%; max-width: 400px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    </div>
</body>

</html>