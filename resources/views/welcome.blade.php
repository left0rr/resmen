<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Restaurant</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/css/home.css'])
    <style>
        .table-selection-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 2rem 0;
        }

        .table-selection-container label {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .table-selection-container select {
            width: 50%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            font-size: 1rem;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            transition: border-color 0.3s ease;
        }

        .table-selection-container select:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .table-selection-container button {
            background-color: #4CAF50;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .table-selection-container button:hover {
            background-color: palevioletred;
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <h1>Welcome to Our Restaurant</h1>
        <p>Experience the best dining with us!</p>
    </header>
    <main>
        <section class="intro">
            <h2>Delicious Meals</h2>
            <p>We offer a variety of dishes that are sure to satisfy your taste buds.</p>
        </section>
        <section class="cta">
            <div class="table-selection-container">
                <form id="tableForm">
                    <label for="tableNumber">Select your table:</label>
                    <select id="tableNumber" name="tableNumber" required>
                        <option value="">Select a table</option>
                        @for ($i = 1; $i <= 20; $i++)
                            <option value="{{ $i }}">Table {{ $i }}</option>
                        @endfor
                    </select>
                    <button type="submit">Compose Your Order</button>
                </form>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Our Restaurant. All rights reserved.</p>
    </footer>
</div>
<script>
    document.getElementById('tableForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const tableNumber = document.getElementById('tableNumber').value;
        if (tableNumber) {
            localStorage.setItem('tableNumber', tableNumber);
            window.location.href = "{{ url('/menu') }}";
        } else {
            alert('Please select a table number.');
        }
    });
</script>
</body>
</html>
