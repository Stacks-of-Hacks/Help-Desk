<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $description = htmlspecialchars($_POST['description']);
    
    $ticket = [
        "name" => $name,
        "email" => $email,
        "subject" => $subject,
        "description" => $description,
        "created_at" => date("Y-m-d H:i:s")
    ];

    $file = 'tickets.json';
    $tickets = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $tickets[] = $ticket;

    file_put_contents($file, json_encode($tickets, JSON_PRETTY_PRINT));

    header("Location: index.html");
    exit();
}
?>
