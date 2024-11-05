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
            background-image: url('{{ asset('backpanel/assets/images/bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            /* filter: blur(5px); */
            /* Apply blur to the body */
        }

        .container-form {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            /* Position relative to enable absolute positioning of the overlay */
        }

        .form-overlay {
            position: absolute;
            /* Make the overlay cover the entire screen */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            backdrop-filter: blur(5px);
            /* Adjust this value to increase or decrease the blur */
            z-index: 0;
            /* Place the overlay behind the form */
        }

        form {
            width: 400px;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            border: 1px solid black;
            border-radius: 0.5rem;
            gap: 2rem;
            padding: 1rem 3rem;
            background: rgba(224, 237, 246, 0.9);
            /* Semi-transparent background for the form */
            position: relative;
            /* Ensure the form is positioned above the overlay */
            z-index: 1;
            /* Bring the form above the overlay */
        }

        input {
            width: 100%;
            padding: 0.6rem 0.8rem;
            border-radius: 0.2rem;
            border: none;
            background-color: #bdc3c7;
            outline: none;
        }

        button {
            width: 100%;
            padding: 0.6rem 0.8rem;
            border-radius: 0.2rem;
            border: none;
            background: green;
            color: white;
        }
    </style>
</head>

<body>

    <div class="container-form">
        <div class="form-overlay"></div>

        <form action="{{ route('admin.check') }}" method="POST">
            @if (session('error'))
                <div class="alert alert-danger" id="errorMessage">
                    {{ session('error') }}
                </div>
            @endif
            @csrf
            <h1>Login</h1>
            <input type="email" name="email" placeholder="Enter your email...">
            <input type="password" name="password" placeholder="Enter your password...">
            <button type="submit">Login</button>
        </form>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Set timeout to remove the alert after 3 seconds (3000ms)
    setTimeout(function() {
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');
        if (successMessage) successMessage.style.display = 'none';
        if (errorMessage) errorMessage.style.display = 'none';
    }, 3000);
</script>


</html>
