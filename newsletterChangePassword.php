<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
    <h2>Change Password</h2>
    <form action="newsletterChangePasswordAction.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="oldPassword">Old Password:</label>
        <input type="password" name="oldPassword" required><br><br>

        <label for="newPassword">New Password:</label>
        <input type="password" name="newPassword" required><br><br>

        <button type="submit">Change Password</button>
    </form>
</body>
</html>

