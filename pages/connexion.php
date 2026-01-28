
<?php
include '../includes/config.php';
include '../includes/header.php';
include '../includes/tools.php';


$error = "";

if (!empty($_POST)) {
    $result = login_process($pdo, $_POST);
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
            echo '<p class="form-error">' . $error .  '</p>';
        }
        ?>
        <form action="" method="POST">
            <label for="login">Login</label>
            <input type="text" name="login" id="login" placeholder="Votre identifiant">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" placeholder="Votre mot de passe">
            <input type="submit" value="Se connecter">
        </form>
    </section>
</main>


<?php include '../includes/footer.php'; ?>
