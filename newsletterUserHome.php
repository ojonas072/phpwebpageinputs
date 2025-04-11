<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT password, salt, isAdmin, name FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_password, $db_salt, $isAdmin, $userName);
        $stmt->fetch();


        $hashedPassword = hash('sha256', $db_salt . $password . 'COMPIT420');
        

        if ($hashedPassword == $db_password) {
            $_SESSION['userEmail'] = $email;
            $_SESSION['userName'] = $userName;
            $_SESSION['isAdmin'] = $isAdmin;
        } else {
            header("Location: newsletterHome.php");
            exit();
        }
    } else {
        header("Location: newsletterHome.php");
        exit();
    }
}


$userEmail = $_SESSION['userEmail'];
$stmt = $conn->prepare("SELECT n.id, n.name, u.email FROM newsletters n LEFT JOIN user_newsletters un ON n.id = un.newsletter_id LEFT JOIN users u ON u.email = un.user_email WHERE u.email = ?");
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
$newsletters = [];
while ($row = $result->fetch_assoc()) {
    $newsletters[] = $row;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_subscriptions'])) {
    foreach ($newsletters as $newsletter) {
        $newsletterId = $newsletter['id'];
        $isSubscribed = isset($_POST['newsletter_' . $newsletterId]) ? 1 : 0;


        if ($isSubscribed) {
            $stmt = $conn->prepare("INSERT INTO user_newsletters (user_email, newsletter_id) VALUES (?, ?)");
            $stmt->bind_param("si", $userEmail, $newsletterId);
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("DELETE FROM user_newsletters WHERE user_email = ? AND newsletter_id = ?");
            $stmt->bind_param("si", $userEmail, $newsletterId);
            $stmt->execute();
        }
    }

    header("Location: newsletterUserHome.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome, <?= htmlspecialchars($userName) ?> - Newsletter Subscriptions</title>
</head>
<body>
    <h2>Welcome, <?= htmlspecialchars($userName) ?></h2>
    
    <form method="POST" action="newsletterUserHome.php">
        <h3>Select your newsletters:</h3>
        <?php foreach ($newsletters as $newsletter): ?>
            <label>
                <input type="checkbox" name="newsletter_<?= $newsletter['id'] ?>" <?= $newsletter['email'] ? 'checked' : '' ?>>
                <?= htmlspecialchars($newsletter['name']) ?>
            </label><br>
        <?php endforeach; ?>
        
        <button type="submit" name="update_subscriptions">Update Subscriptions</button>
    </form>

    <br><br>

    <a href="newsletterChangePassword.php">Change Password</a><br>
    <a href="newsletterUnsubscribe.php">Unsubscribe</a><br>
    
    <?php if ($_SESSION['isAdmin'] == 1): ?>
        <a href="newsletterPrintAll.php">Print All Subscriptions</a><br>
    <?php endif; ?>
</body>
</html>

<?php $conn->close(); ?>

