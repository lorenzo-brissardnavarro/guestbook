
<?php
include '../includes/config.php';
include '../includes/header.php';
include '../includes/tools.php';


if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit;
}

$error = "";

if (!empty($_POST)) {
    $result = message_process($pdo, $_POST, $_POST["message"], $_SESSION['id'], date("Y-m-d H:i:s"));
    if ($result === true) {
        header("Location: accueil.php");
        exit;
    } else {
        $error = $result;
    }
}


?>

<main>
    <section class="container-form">
        <?php 
        if (!empty($error)){
            echo '<p class="form-error">' . htmlspecialchars($error) .  '</p>';
        }
        ?>
        <form method="POST" action="">
            <label for="message">Votre message</label>
            <textarea id="message" name="message" maxlength="450" rows="5" cols="33"></textarea>
            <input type="submit" value="Publier mon message">
        </form>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
