<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            background: #ecf0f1;
            background-image: url();
        }

        .container-form {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {
            width: 400px;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            border: 1px solid black;
            border-radius: 1rem;
            gap: 2rem;
            padding: 1rem 3rem;
            background: #bdc3c7;
        }

        input {
            width: 100%;
            padding: 0.6rem 0.8rem;
            border-radius: 0.6rem;
            border: none
        }

        button {
            width: 100%;
            padding: 0.6rem 0.8rem;
            border-radius: 0.6rem;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container-form">
        <form action="{{ route('admin.check') }}" method="POST">
            @csrf
            <h1>Login</h1>
            <input type="email" name="email" placeholder="Enter your email...">
            <input type="password" name="password" placeholder="Enter your password...">
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>
