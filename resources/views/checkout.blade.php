<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Order!</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
        }

        h1 {
            margin: 0;
            color: #333;
        }
        p{
            color: #FF6F61;
        }



        .thank-you, .discount-code, .cta {
            margin-bottom: 20px;
        }

        .discount-code {
            text-align: center;
        }

        .code-box {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 10px 0;
        }

        .code-box img {
            max-width: 200px;
            height: auto;
        }

        .cta {
            text-align: center;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            padding: 10px;
            border-top: 1px solid #ddd;
            font-size: 14px;
        }
    </style>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    @vite(['resources/js/app.js','resources/css/home.css'])
</head>
<body>

<div class="container">
    <header>
        <h1>Thank You for Your Order!</h1>
        <p>We appreciate your business and hope you enjoyed your experience with us.</p>
    </header>
    <main>

        <section class="discount-code ">
            <p>As a token of our appreciation, please use the following code for a discount on your next purchase:</p>
            <div class="code-box">
                <strong>
                    @if (isset($qrCodePath))
                        <img src="{{ asset($qrCodePath) }}" alt="QR Code">
                    @endif
                </strong>
            </div>
            <p>Thank you for dining with us! We look forward to serving you again soon.</p>
        </section>
        <section class="cta">
            <a href="/" class="button" id="orderMoreButton">Order More</a>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Our Restaurant. All rights reserved.</p>
    </footer>
</div>
<script>
    document.getElementById('orderMoreButton').addEventListener('click', function(event) {
        // Clear the cart items from localStorage
        localStorage.removeItem('cartItems');

        // Redirect to the menu page
        window.location.href = "{{ url('/menu') }}";
    });
</script>

</body>
</html>
