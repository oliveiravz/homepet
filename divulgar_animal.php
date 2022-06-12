<?php
session_start();
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
require_once __DIR__ . '/src/conn.php'; 

if(count($_SESSION) == 0){
    header('Location: login.php');
}

unset($erro);
$erro = array();

$conn = Conn();
$sql = $conn->prepare("SELECT * FROM raca");
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

if(!empty($_POST)){
    if(trim($_POST['nome_animal']) === ""){
        $erro['msg'] = 'Nome do animal é obrigatório<br/>';
    }
    if(trim($_POST['peso']) == ""){
        $erro['msg'] .= 'Peso do animal é obrigatório<br/>';
    }

    if(!isset($_POST['raca'])){
        $erro['msg'] .= 'Raça do animal é obrigatório<br/>';
    }
    if(!isset($_POST['porte'])){
        $erro['msg'] .= 'Porte do animal é obrigatório<br/>';
    }
    
    if(empty($erro['msg'])){
        $imagem = $_FILES['imagem'];
        $dados = $_POST;
        $dados = array_map('trim', $dados);
        $tutor = $_SESSION['id'];
        $extensoes_permitidas = array('.jpg', '.gif', '.png');
        $extensao = strrchr($_FILES['imagem']['name'], '.');

        if(!in_array($extensao, $extensoes_permitidas)){
            $erro['msg'] .= 'Por favor, envie arquivos com as seguintes extensões: jpg, gif ou png.<br/>';
        }

        $sql = "INSERT INTO animal(nome_animal, peso, porte, descricao, usuario_id, raca_id, imagem, created) VALUES (:nome_animal,:peso,:porte,:descricao,:usuario_id,:raca_id,:imagem, NOW())";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':nome_animal', $dados['nome_animal'], PDO::PARAM_STR);
        $stmt->bindParam(':peso', $dados['peso'], PDO::PARAM_INT);
        $stmt->bindParam(':porte', $dados['porte'], PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $dados['descricao'], PDO::PARAM_STR);
        $stmt->bindParam(':usuario_id', $tutor, PDO::PARAM_INT);
        $stmt->bindParam(':raca_id', $dados['raca'], PDO::PARAM_INT);
        $stmt->bindParam(':imagem', $imagem['name'], PDO::PARAM_STR);
        
        $stmt->execute();

        if($stmt->rowCount()){
            if(isset($imagem['name']) && (!empty($imagem['name']))){
                $dir = "img/{$_SESSION['id']}/";
                mkdir($dir, 0755);

                $nome_imagem = $imagem['name'];
                move_uploaded_file($imagem['tmp_name'], $dir . $nome_imagem);
            }
            $_SESSION['msg_success'] = 'Animal cadastrado com sucesso';
        }
        
        if(isset($erro['msg'])){
            $erro['msg'] = 'Erro ao cadastrar animal';
        }
    }
}
?>

<main>
    <div class="container">
        <form action="#" class="form-cadastre" method="post" enctype="multipart/form-data">
            <?php if(isset($erro['msg'])){ ?>
                <div class="alert-error">
                    <?= $erro['msg'] ?>
                    <?php unset($erro['msg']) ?>
                </div>  
            <?php } ?>
            <?php if(isset($_SESSION['msg_success'])){ ?>
                <div class="alert-success">
                    <?= $_SESSION['msg_success'] ?>
                    <?php unset($_SESSION['msg_success']) ?>
                </div>  
            <?php } ?>  
            <br>
            <div class="title">
                <h1>Divulgue um animal para adoção</h1>
            </div>
            <div class="form-group">                
                <input type="text" name="nome_animal" id="nome_animal" placeholder="Nome do animal" value="<?=$_POST['nome_animal'] ?? null?>">
            </div>
            <div class="form-group">                
                <input type="text" name="peso" id="peso" placeholder="Peso" value="<?=$_POST['peso'] ?? null?>">
                <select name="raca" id="raca">
                    <option value="raca" disabled selected>Raça</option>
                    <?php foreach ($result as $key => $value) {?>
                        <option value="<?=$value['id']?>"><?=$value['raca']?></option>
                    <?php } ?>  
                </select>
                <select name="porte" id="porte">
                    <option value="porte" disabled selected>Porte</option>
                    <option value="pequeno">Pequeno</option>
                    <option value="medio">Médio</option>
                    <option value="grande">Grande</option>
                </select>
            </div>
            <div class="form-group">                
                <input type="file" name="imagem" id="imagem">
            </div>
            <div class="form-group">                
                <textarea name="descricao" id="descricao" cols="600" rows="30" placeholder="Adicione uma breve descrição sobre o animal" value="<?=$_POST['descricao'] ?? null?>"></textarea>
            </div>
            <br>
            <div class="btn-container">
                <input type="submit" value="Cadastrar" class="btn btn-login">
            </div>
        </form>

    </div>
</main>
<script>
    $(document).ready(function() {
        $("#peso").mask("999");
    });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>