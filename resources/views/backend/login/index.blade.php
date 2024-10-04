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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Show error message
    function showErrorMessage(message) {
        var messageDiv = $('<div></div>')
            .text(message)
            .css({
                'position': 'fixed',
                'top': '20px',
                'right': '20px',
                'padding': '10px 20px',
                'background-color': '#dc3545',
                'color': '#fff',
                'border-radius': '5px',
                'z-index': '9999',
                'display': 'none',
                'box-shadow': '0 4px 8px rgba(0, 0, 0, 0.2)'
            });
        $('body').append(messageDiv);
        messageDiv.fadeIn(300).delay(3000).fadeOut(300, function() {
            $(this).remove();
        });
        // Listen for form submit event
        $('#login-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting the default way

            var formData = $(this).serialize(); // Serialize the form data

            $.ajax({
                url: "{{ route('admin.check') }}", // The form action URL
                method: "POST", // The HTTP method
                data: formData, // The form data
                success: function(response) {
                    // If the login is successful, show the success message
                    showSuccessMessage('Login successful! Redirecting...');
                    // Optionally, redirect after successful login
                    setTimeout(function() {
                        window.location.href =
                            "{{ route('admin.dashboard') }}"; // Change this to your dashboard route
                    }, 2000);
                },
                error: function(xhr) {
                    // If an error occurs, show the error message
                    var errorMessage = xhr.responseJSON ? xhr.responseJSON.message :
                        'Login failed. Please try again.';
                    showErrorMessage(errorMessage);
                }
            });
        });

        // Show success message
        function showSuccessMessage(message) {
            var messageDiv = $('<div></div>')
                .text(message)
                .css({
                    'position': 'fixed',
                    'top': '20px',
                    'right': '20px',
                    'padding': '10px 20px',
                    'background-color': '#28a745',
                    'color': '#fff',
                    'border-radius': '5px',
                    'z-index': '9999',
                    'display': 'none',
                    'box-shadow': '0 4px 8px rgba(0, 0, 0, 0.2)'
                });
            $('body').append(messageDiv);
            messageDiv.fadeIn(300).delay(3000).fadeOut(300, function() {
                $(this).remove();
            });
        }

    }
</script>


</html>
