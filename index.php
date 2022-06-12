<?php 
session_start();
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
require_once __DIR__ . '/src/conn.php'; 

$conn = Conn();
$sql = $conn->prepare("SELECT DISTINCT * FROM animal a JOIN raca r ON r.id = a.raca_id");
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <div class="container">
        <div class="title">
            <h1>Encontre seu novo amigo aqui</h1>
        </div>
        <div class="card-container">
            <?php foreach ($result as $key => $value) { ?>
                <div class="card">
                    <a href="adote.php?id=<?=$value['id_animal']?>">
                        <div class="card-img">
                            <?php if(file_exists("img/{$value['usuario_id']}/{$value['imagem']}")) {    ?>
                                <img src='<?="img/{$value['usuario_id']}/{$value['imagem']}"?>' alt="">
                            <?php } ?>
                        </div>
                        <h2 class="card-title">
                            <?=$value['nome_animal']?>
                        </h2>
                        <p><?=$value['raca']?></p>
                        <div class="card-desc">
                            <?= $value['descricao']?>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

<?php
    include __DIR__ . '/includes/footer.php';
?>