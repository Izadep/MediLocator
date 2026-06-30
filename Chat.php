<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - MediLocator</title>
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="Chat.css">
</head>

<body>
    <?php include("navbar.php") ?>

    <main class="page-content">

        <div class="chat-container">

            <div class="chat-header">
                <h1>💬 Chat</h1>
            </div>

            <div class="chat-body">
                <p>No chat history available.</p>
            </div>

        </div>

    </main>

    <?php include("footer.php") ?>

    <script>
        window.addEventListener('scroll', function () {
            var navbar = document.getElementById('navbar');

            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>