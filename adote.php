<?php
session_start();
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
require_once __DIR__ . '/src/conn.php'; 

if(count($_SESSION) == 0){
    header('Location: login.php');
}

$id = $_GET['id'];
$conn = Conn();
$sql = "SELECT a.*, u.nome, u.email, e.cidade, e.estado, r.raca
        FROM animal a
        JOIN usuario u ON a.usuario_id = u.id
        JOIN raca r ON r.id = a.raca_id
        JOIN endereco e ON u.id = e.usuario_id
        WHERE a.id_animal = $id";
$sql_stmt = $conn->prepare($sql);
$sql_stmt->bindParam(':id', $id, PDO::PARAM_INT);
$sql_stmt->execute();
    
if($sql_stmt->rowCount() > 0){
    $linha =  $sql_stmt->fetch(PDO::FETCH_ASSOC);
    $nome_animal = $linha['nome_animal'];
    $nome        = $linha['nome'];  
    $porte       = $linha['porte'];
    $raca        = $linha['raca'];
    $descricao   = $linha['descricao'];
    $peso        = $linha['peso'];
    $cidade      = $linha['cidade'];
    $estado      = $linha['estado'];

}
?>

<main>
    <div class="container">
        <div class="div-container">
            <div class="dog-picture">
                <?php if(file_exists("img/{$linha['usuario_id']}/{$linha['imagem']}")){ ?>
                    <img src='<?="img/{$linha['usuario_id']}/{$linha['imagem']}"?>' alt="">
                <?php } ?>
            </div>
        </div>
        <div class="div-container-x">  
            <div class="container">
                <h1><?=$nome_animal?></h1>
                <h4>Postado por: <?=$nome?></h4>
                <div class="info-dog">
                    <h5>Raça: <?=$raca?></h5>
                    <h5>Porte: <?=$porte?></h5>
                    <h5>Peso: <?=$peso?>Kg (Valor aproximado)</h5>
                    <h5>Está em: <?=$cidade?> - <?=$estado?></h5>
                </div>  
                <br>
                <h5>Sobre: </h5>
                <p><?=$descricao?></p>
                <div>
                    <a href="" class="btn-adote">Quero adotar o <?=$nome_animal?></a>
                </div>
            </div>
        </div>  
    </div>
</main>

<?php 
include __DIR__ . '/includes/footer.php';
?>