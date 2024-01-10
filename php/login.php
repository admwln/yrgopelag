<?php

require_once(__DIR__ . '/../autoload.php');

// Unset roomId session variable
unset($_SESSION['roomId']);

// Check if user is logged in
if (isset($_SESSION['loggedIn'])) {
    // User IS logged in
    // Redirect to admin.php
    header('Location: admin.php');
}


?>

<?php
$ROOT = '../';
require __DIR__ . '/header.php';
?>
<section class="update-message-container">
    <?php
    if (isset($_SESSION['login-error'])) { ?>
        <p class="update-message error">
            <?= $_SESSION['login-error']; ?>
        </p>
    <?php
        unset($_SESSION['login-error']);
    }
    ?>
</section>

<main class="success">

    <h2>Login</h2>

    <form action="verify.php" method="post">
        <div>
            <input type="text" name="username" id="username" placeholder="Username" required>
        </div>
        <div>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <input type="submit" value="Login">
    </form>
</main>
<?php require __DIR__ . '/footer.php'; ?>