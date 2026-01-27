<?php 

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

// Modification message
if (!empty($_POST['edit'])) {
    if (!edit_message($pdo, $edit_id, $_POST["message"], date("Y-m-d"), $_SESSION['id'])) {
        $error = "Impossible de modifier ce message.";
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

// On détermine le nombre de messages par page
$perPage = 12;

// On calcule le nombre de pages au total
$pages = ceil($number_messages / $perPage);

$first = $perPage * ($currentPage - 1);
$messages = get_all($pdo, $first, $perPage);




?>

<main>
    <?php
    if(!empty($_POST["edit_id"])){
        if (!empty($error)){
            echo '<p class="form-error">' . htmlspecialchars($error) .  '</p>';
        }
        echo '<form method="POST" action="">
            <label for="edit">Remplacement du message</label>
            <input type="text" id="edit" name="edit" maxlength="450">
            <input type="submit" value="Republier mon message">
        </form>
        ';
    } else{
        foreach ($messages as $message) {
            echo '
            <article>
                <h3>Posté par' . htmlspecialchars($message['login']) . 'le ' . htmlspecialchars($message['date']) . '</h3>';
                if(isset($_SESSION['id']) && $_SESSION['id'] === $message['id_user']){
                    echo '
                    <section>
                        <form method="POST" action="">
                            <input type="hidden" name="edit_id" value="' . htmlspecialchars($message['id']) . '">
                            <button type="submit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </form>
                        <form method="POST" action="">
                            <input type="hidden" name="delete_id" value="' . htmlspecialchars($message['id']) . '">
                            <button type="submit">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    <section>';
                }
            echo '</article>';
        }
    }
    ?>
    <nav>
        <ul class="pagination">
            <?php 
            if($currentPage > 1){
                echo '<li class="page-item>
                    <a href="./?page=' . echo ($currentPage - 1) . '" class="page-link">Précédente</a>
                    </li>';
            }
            ?>
            <?php
            for($page = 1; $page <= $pages; $page++){
                echo '<li class="page-item">
                    <a href="./?page=' . echo $page . '" class="page-link">' . echo $page . '</a>
                    </li>';
            }
            ?>
            <?php 
            if($currentPage < $pages){
                echo '<li class="page-item>
                    <a href="./?page=' . echo ($currentPage + 1) . '" class="page-link">Précédente</a>
                    </li>';
            }
            ?>
        </ul>
    </nav>
</main>