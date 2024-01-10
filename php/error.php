<?php

require_once(__DIR__ . '/../autoload.php');
?>

<?php
$ROOT = '../';
require __DIR__ . '/header.php';
?>
<main class="success">

    <h2>Something Went Wrong</h2>
    <?php
    if (isset($_SESSION['user-error'])) { ?>
        <p class="error-message"><?= $_SESSION['user-error']; ?></p>
    <?php
        unset($_SESSION['user-error']);
    }
    ?>
    <p>Please try again.</p>
    <a href="../index.php"><i class="fa-solid fa-house"></i> Go back to homepage</a>
</main>
<?php require __DIR__ . '/footer.php'; ?>