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


$perPage = 12;
if(isset($_GET['page'])){
    $currentPage = (int)$_GET['page'];
} else {
    $currentPage = 1;
}
if ($currentPage < 1){
    $currentPage = 1;
}
$first = $perPage * ($currentPage - 1);
if (!empty($_GET['search'])) {
    $search = trim($_GET['search']);
    $messages = search_messages($pdo, $search, $perPage, $first);
    $number_messages = count_search_messages($pdo, $search);
    $pages = ceil($number_messages / $perPage);

} else {
    $number_messages = count_message($pdo);
    $pages = ceil($number_messages / $perPage);
    if ($currentPage > $pages) {
        $currentPage = $pages;
    }
    $messages = get_all($pdo, $first, $perPage);
}



?>

<main>
    <h2>Livre d’or du restaurant</h2>
    <section class="search">
        <form action="" method="GET">
            <input type="search" name="search" placeholder="Mots-clés" value="<?php if(!empty($_GET['search'])){echo htmlspecialchars($_GET['search'])}; ?>">
            <input type="submit" value="Rechercher">
        </form>
    </section>
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
    <?php
    if(!empty($_GET['search'])){
        $searchParam = '&search=' . urlencode($_GET['search']);
    }
    ?>
    <nav>
        <ul class="pagination">
            <?php 
            if($currentPage > 1){
                echo '<li class="page-item">
                    <a href="./?page=' . ($currentPage - 1) . $searchParam . '" class="page-link">Précédente</a>
                    </li>';
            }
            ?>

            <?php
            for($page = 1; $page <= $pages; $page++){
                echo '<li class="page-item">
                    <a href="./?page=' . $page . $searchParam . '" class="page-link">' . $page . '</a>
                    </li>';
            }
            ?>

            <?php 
            if($currentPage < $pages){
                echo '<li class="page-item">
                    <a href="./?page=' . ($currentPage + 1) . $searchParam . '" class="page-link">Suivante</a>
                    </li>';
            }
            ?>
        </ul>
    </nav>
</main>