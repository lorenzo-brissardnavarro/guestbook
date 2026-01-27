<?php 
include '../includes/config.php';
include '../includes/header.php';
include '../includes/tools.php';



$error = "";
// Suppression message
if (!empty($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];
    if (!message_deletion($pdo, $delete_id, $_SESSION['id'])) {
        $error = "Impossible de supprimer ce message.";
    } else {
        header("Location: guestbook.php");
        exit;
    }
}


$number_messages = count_message($pdo);

// Déterminer page actuelle
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int)$_GET['page'];
}else{
    $currentPage = 1;
}
if ($currentPage < 1){
    $currentPage = 1;
} elseif ($currentPage > $pages) {
    $currentPage = $pages;
}

// On détermine le nombre de messages par page
$perPage = 12;

// On calcule le nombre de pages au total
$pages = ceil($number_messages / $perPage);

$first = $perPage * ($currentPage - 1);
$messages = get_all($pdo, $first, $perPage);




?>

<main>
    <h2>Livre d’or du restaurant</h2>
    <section class="messages">
    <?php
        foreach ($messages as $message) {
            echo '
            <article class="message">
                <p class="meta">Posté par ' . htmlspecialchars($message['login']) . ' le ' . htmlspecialchars($message['date']) . '</p>
                <p class="content">' . htmlspecialchars($message['message']) . '</p>';
                if(isset($_SESSION['id']) && $_SESSION['id'] === $message['id_user']){
                    echo '
                    <div>
                        <a href="modification.php?id=' . $message['id'] . '">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form method="POST" action="">
                            <input type="hidden" name="delete_id" value="' . htmlspecialchars($message['id']) . '">
                            <button type="submit">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>';
                }
            echo '</article>';
        }
    ?>
    </section>
    <nav>
        <ul class="pagination">
            <?php 
            if($currentPage > 1){
                echo '<li class="page-item">
                    <a href="./?page=' . ($currentPage - 1) . '" class="page-link">Précédente</a>
                    </li>';
            }
            ?>
            <?php
            for($page = 1; $page <= $pages; $page++){
                echo '<li class="page-item">
                    <a href="./?page=' . $page . '" class="page-link">' . $page . '</a>
                    </li>';
            }
            ?>
            <?php 
            if($currentPage < $pages){
                echo '<li class="page-item">
                    <a href="./?page=' . ($currentPage + 1) . '" class="page-link">Suivante</a>
                    </li>';
            }
            ?>
        </ul>
    </nav>
</main>