<?php
session_start();

if (isset($_SESSION['userEmail'])) {
    header("Location: newsletterUserHome.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Newsletter Lab</title>
</head>
<body>


    <h1>Welcome to the Lab!</h1>
    <p>Login below.</p>

    <form action="newsletterUserHome.php" method="POST">
        <h2>Login</h2>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>

    <br>


    <p>Don't have an account? <a href="newsletterSignup.php">Sign up here</a>.</p>

</body>
</html>

