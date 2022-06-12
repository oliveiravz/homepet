<?php
session_start();
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
require_once __DIR__ . '/src/conn.php'; 

unset($erro);
$erro = array();

if(!empty($_POST)){
    $dados =  $_POST;

    if(trim($dados['nome']) === ""){
        $erro['msg'] = 'Nome é obrigatório<br/>';
    }

    if(trim($dados['senha']) === ""){
        $erro['msg'] .= 'Senha é obrigatório<br/>';
    }

    if(trim($dados['confirme_senha']) === ""){
        $erro['msg'] .= 'Confirme a senha<br/>';
    }   

    if(trim($dados['telefone']) === "" || trim($dados['whatsapp']) === ""){
        $erro['msg'] .= 'Informe algum contato<br/>';
    }

    if(trim($dados['confirme_senha']) != trim($dados['senha'])){
        $erro['msg'] .= 'Senhas não são iguais';
    }


    if(empty($erro['msg'])){
        $conn = Conn();
        $dados = array_map('trim', $dados);
        
        $sql_login = 'INSERT INTO login(email, senha) VALUES(:email, :senha)';
        $senha = password_hash($dados['senha'], PASSWORD_BCRYPT);
        
        $sql_usuario = 'INSERT INTO usuario(nome, email) VALUES(:nome, :email)';

        $sql_endereco = 'INSERT INTO endereco(estado, cidade) VALUES(:estado, :cidade)';
        $stmt = $conn->prepare($sql_login);
        $stmt2 = $conn->prepare($sql_usuario);
        $stmt3 = $conn->prepare($sql_endereco);
    
        $stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt2->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $stmt2->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $stmt3->bindParam(':estado', $dados['estado'], PDO::PARAM_STR);
        $stmt3->bindParam(':cidade', $dados['cidade'], PDO::PARAM_STR);

        $insert1 = $stmt->execute();
        $insert2 = $stmt2->execute();
        $insert3 = $stmt3->execute();

        if($insert1 && $insert2 && $insert3){
            $_SESSION['msg_success'] = 'Cadastro realizado com sucesso';
        }

        if(isset($erro['msg'])){
            $erro['msg'] = 'Erro ao cadastrar';
        }
    }   
}

?>

<main>
    <div class="container">
        <form action="#" class="form-cadastre" method="post">
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
            <div class="title">
                <h1>Cadastre-se</h1>
            </div>
            <div class="form-group">                
                <input type="text" name="nome" id="nome" placeholder="Nome" value="<?=$_POST['nome'] ?? null?>">
            </div>
            <div class="form-group">                
                <input type="text" name="email" id="email" placeholder="E-mail" value="<?=$_POST['email'] ?? null?>">
                <input type="password" name="senha" id="senha" placeholder="Senha">
                <input type="password" name="confirme_senha" id="confirme_senha" placeholder="Confirme sua senha">
            </div>
            <div class="form-group">                
                <input type="text" name="cidade" id="cidade" placeholder="Cidade" value="<?=$_POST['cidade'] ?? null?>">
                <input type="text" name="estado" id="estado" placeholder="Estado" value="<?=$_POST['estado'] ?? null?>">
            </div>
            <div class="form-group">                
                <input type="text" name="telefone" id="telefone" placeholder="Telefone" value="<?=$_POST['telefone'] ?? null?>">
                <input type="text" name="whatsapp" id="whatsapp" placeholder="Whatsapp" value="<?=$_POST['whatsapp'] ?? null?>">
            </div>
            <br>
            <div class="text">
                <a href="login.php">Já possui uma conta? Faça login</a>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn btn-login" name="cadastre">Cadastre-se</button>
            </div>
        </form>

    </div>
</main>
<script>
    $(document).ready(function() {
        $("#telefone").mask("(99) 9999-9999");
        $("#whatsapp").mask("(99) 99999-9999");
    });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>