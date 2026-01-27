
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Livre d’or du restaurant</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>
    <header>
        <div class="header-container">
            <a href="accueil.php">
                <div class="logo">
                <img src="../images/logo.png" alt="Logo du restaurant">
                <span>Le Bistrot Français</span>
            </a>
        </div>
            <nav>
                <a href="accueil.php">Accueil</a>
                <a href="guestbook.php">Livre d’or</a>
                <?php 
                if(!empty($_SESSION['id'])){
                    echo '
                    <a href="profil.php">Modification</a>
                    <a href="deconnexion.php">Deconnexion</a>';
                } else{
                    echo '
                    <a href="inscription.php">Inscription</a>
                    <a href="connexion.php">Connexion</a>';
                }
                ?>
                <form action="" method="POST">
                    <input type="search" name="search" placeholder="Mots-clés" value="<?php if(!empty($_POST['search'])){echo htmlspecialchars($_POST['search'])}; ?>">
                    <input type="submit" value="Rechercher">
                </form>
            </nav>
        </div>
    </header>
