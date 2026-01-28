<?php
include '../includes/config.php';
include '../includes/header.php';
include '../includes/tools.php';

if (!isset($_SESSION['id']) || empty($_GET['id'])) {
    header('Location: guestbook.php');
    exit;
}

$id = (int) $_GET['id'];
$values = get_information_message($pdo, $id, $_SESSION['id']);

if (!$values) {
    header('Location: guestbook.php');
    exit;
}

$error = "";
if (!empty($_POST) && !empty($_POST["message"])) {
    if (edit_message($pdo, $id, $_POST['message'], date("Y-m-d H:i:s"), $_SESSION['id'])) {
        header('Location: guestbook.php');
        exit;
    }
    $error = "Erreur lors de la modification";
}
?>


<main>
    <section class="container-form">
        <h2>Modifier votre message</h2>
        <?php 
        if (!empty($error)){
            echo '<p class="form-error">' . htmlspecialchars($error) .  '</p>';
        }
        ?>
        <form method="POST" action="">
            <label for="message">Votre nouveau message</label>
            <textarea type="text" id="message" name="message" maxlength="450" rows="5" cols="33"><?php echo htmlspecialchars($values['message']); ?></textarea>
            <input type="submit" value="Republier mon message">
        </form>
    </section>
</main>


<?php include '../includes/footer.php'; ?>