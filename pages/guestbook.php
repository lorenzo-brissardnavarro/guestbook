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


$perPage = 9;
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
    <section class="guestbook-search">
        <h2>Livre d’or du restaurant</h2>
        <section class="search">
            <form action="guestbook.php" method="GET">
                <input type="search" name="search" placeholder="Mots-clés">
                <input type="submit" value="Rechercher">
            </form>
        </section>
    </section>
    <section class="messages">
    <?php
        foreach ($messages as $message) {
            $date=date_create_from_format("Y-m-d H:i:s", htmlspecialchars($message['date']));
            echo '
            <article class="message">
                <div>
                    <p class="meta">Posté par ' . htmlspecialchars($message['login']) . ' le ' . date_format($date,'j-M-Y') . '</p>
                    <p class="content">' . htmlspecialchars($message['message']) . '</p>
                </div>';
                if(isset($_SESSION['id']) && $_SESSION['id'] === $message['id_user']){
                    echo '
                    <div class="options-container">
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
    } else{
        $searchParam = '';
    }
    ?>
    <nav class="nav-pagination">
        <ul class="pagination">
            <?php 
            if($currentPage > 1){
                echo '<li class="page-item">
                    <a href="?page=' . ($currentPage - 1) . $searchParam . '" class="page-link">Précédente</a>
                    </li>';
            }
            ?>

            <?php
            for($page = 1; $page <= $pages; $page++){
                echo '<li class="page-item">
                    <a href="?page=' . $page . $searchParam . '" class="page-link">' . $page . '</a>
                    </li>';
            }
            ?>

            <?php 
            if($currentPage < $pages){
                echo '<li class="page-item">
                    <a href="?page=' . ($currentPage + 1) . $searchParam . '" class="page-link">Suivante</a>
                    </li>';
            }
            ?>
        </ul>
    </nav>
</main>

<?php include '../includes/footer.php'; ?>