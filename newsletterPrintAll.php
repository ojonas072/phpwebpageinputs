<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Access</title>
</head>
<body>
    <h2>Admin Access: Print All Newsletter Data</h2>
    <p>Please provide your credentials to accessl user data:</p>
    <form action="newsletterPrintAllTable.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <label for="secret_code">Secret Code:</label>
        <input type="text" name="secret_code" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>

