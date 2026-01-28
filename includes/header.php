
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Livre d’or du restaurant</title>
    <?php
    if(isset($_GET['page']) || isset($_GET['search'])){
        echo '<link rel="stylesheet" href="../../css/style.css">';
    } else{
        echo '<link rel="stylesheet" href="../css/style.css">';
    }
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <?php
                if(isset($_GET['page']) || isset($_GET['search'])){
                    echo '<img src="../../images/logo.png" alt="Logo du restaurant">';
                } else{
                    echo '<img src="../images/logo.png" alt="Logo du restaurant">';
                }
                ?>
                <span>Le Bistrot Français</span>
            </div>
            <?php
            if(isset($_GET['page'])){
                echo '
                <nav>
                <a href="../accueil.php">Accueil</a>
                <a href="../guestbook.php">Livre d’or</a>';
                if(!empty($_SESSION['id'])){
                    echo '
                    <a href="../profil.php">Modification</a>
                    <a href="../messages.php">Ajouter un message</a>
                    <a href="../deconnexion.php">Deconnexion</a>';
                } else{
                    echo '
                    <a href="../inscription.php">Inscription</a>
                    <a href="../connexion.php">Connexion</a>';
                }
                echo '</nav>';
            } else{
                echo '
                <nav>
                <a href="accueil.php">Accueil</a>
                <a href="guestbook.php">Livre d’or</a>';
                if(!empty($_SESSION['id'])){
                    echo '
                    <a href="profil.php">Modification</a>
                    <a href="messages.php">Ajouter un message</a>
                    <a href="deconnexion.php">Deconnexion</a>';
                } else{
                    echo '
                    <a href="inscription.php">Inscription</a>
                    <a href="connexion.php">Connexion</a>';
                }
                echo '</nav>';
            }
            ?>
        </div>
    </header>
