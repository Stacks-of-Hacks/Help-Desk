<?php
session_start();

// Admin credentials
$admin_username = 'August';
$admin_password = '889123';

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    if ($_POST['username'] === $admin_username && $_POST['password'] === $admin_password) {
        $_SESSION['logged_in'] = true;
        header('Location: admin.php');
        exit();
    } else {
        $login_error = 'Invalid username or password';
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit();
}

// Redirect if not logged in
if (!isset($_SESSION['logged_in'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Admin Login</title>
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
                position: relative;
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
            <h1>Admin Login</h1>
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
    <?php
    exit();
}

$tickets = file_exists('tickets.json') ? json_decode(file_get_contents('tickets.json'), true) : [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_index'])) {
    $index = (int)$_POST['delete_index'];
    if (isset($tickets[$index])) {
        array_splice($tickets, $index, 1);
        file_put_contents('tickets.json', json_encode($tickets, JSON_PRETTY_PRINT));
        header('Location: admin.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - View Tickets</title>
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
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        .ticket {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            background: #fefefe;
            position: relative;
        }

        .delete-ticket {
            position: absolute;
            top: 10px;
            right: 10px;
            color: red;
            font-weight: bold;
            cursor: pointer;
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
        <h1>Admin - Submitted Tickets</h1>
        <?php if (empty($tickets)): ?>
            <p>No tickets submitted yet.</p>
        <?php else: ?>
            <?php foreach ($tickets as $index => $ticket): ?>
                <div class="ticket">
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="delete_index" value="<?= $index ?>">
                        <button type="submit" class="delete-ticket">&times;</button>
                    </form>
                    <p><strong>Name:</strong> <?= htmlspecialchars($ticket['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($ticket['email']) ?></p>
                    <p><strong>Subject:</strong> <?= htmlspecialchars($ticket['subject']) ?></p>
                    <p><strong>Description:</strong> <?= htmlspecialchars($ticket['description']) ?></p>
                    <p><small><strong>Submitted on:</strong> <?= htmlspecialchars($ticket['created_at']) ?></small></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>

</html>

