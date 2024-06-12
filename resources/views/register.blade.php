<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Registration</title>
    <!-- Include CSS frameworks here -->
</head>
<body>
    <h1>Clinic Registration</h1>
    <form method="POST" action="{{ route('clinic.register') }}">
        @csrf
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br>

        <label for="specialty">Specialty:</label>
        <input type="text" id="specialty" name="specialty" required><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="pass">Password:</label>
        <input type="password" id="pass" name="pass" required><br>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
