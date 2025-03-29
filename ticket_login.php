<?php
session_start();

// User credentials (you can expand this for multiple users)
$user_credentials = [
    'user' => 'user123',
    'guest' => 'guest123'
];

// Handle user login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($user_credentials[$username]) && $user_credentials[$username] === $password) {
        $_SESSION['user_logged_in'] = true;
        header('Location: ticket.php');
        exit();
    } else {
        $login_error = 'Invalid username or password';
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ticket_login.php');
    exit();
}

// Redirect if already logged in
if (isset($_SESSION['user_logged_in'])) {
    header('Location: ticket.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ticket System Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        input {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button {
            padding: 10px 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .error {
            color: red;
        }

        .back-arrow {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 30px;
            text-decoration: none;
            color: grey;
            padding: 10px;
            border: 2px solid grey;
            border-radius: 8px;
        }

        .back-arrow:hover {
            color: #555;
            border-color: #555;
        }
    </style>
</head>

<body>
    <a href="index.html" class="back-arrow">&larr;</a>
    <div class="login-container">
        <h1>Ticket System Login</h1>
        <?php if (isset($login_error)): ?>
            <p class="error"> <?= htmlspecialchars($login_error) ?> </p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>

</html>
