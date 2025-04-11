<!DOCTYPE html>
<html>
<head>
    <title>Newsletter Signup</title>
</head>
<body>

    <h2>Newsletter Signup</h2>
    <form method="POST" action="newsletterSignupAction.php">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Sign Up</button>
    </form>

</body>
</html>

