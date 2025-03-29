<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['logged_in'])) {
    header('Location: admin.php');
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Account Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: #f9f9f9;
            color: #333;
        }

        .navbar {
            background: #3498db;
            padding: 15px;
            display: flex;
            justify-content: space-around;
            color: white;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .navbar a:hover {
            background: #2980b9;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #2c3e50;
        }

        .logout-btn {
            padding: 10px 20px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: #c0392b;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <a href="index.html">Home</a>
        <a href="index.html">File a Ticket</a>
        <a href="admin.php">Admin</a>
        <a href="index.html">About</a>
        <a href="account.php">Account</a>
    </div>

    <div class="container">
        <h1>Welcome to Your Account</h1>
        <p>Logged in as: <strong>Admin</strong></p>
        <a href="?logout=1" class="logout-btn">Logout</a>
    </div>

</body>

</html>
