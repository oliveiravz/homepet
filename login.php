<?php
session_start();
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
require_once __DIR__ . '/src/conn.php'; 


if(!empty($_POST)){
    $conn = Conn();
    $dados = $_POST;

    if(trim($dados['email']) === ""){
        $erro['msg'] = 'Informe o E-mail<br/>';
    }

    if(trim($dados['senha']) === ""){
        $erro['msg'] .= 'Informe sua senha<br/>';
    }

    $sql = "SELECT *
            FROM login l 
            JOIN usuario u ON u.email = l.email
            WHERE l.email = :email
            LIMIT 1";

    $sql_stmt = $conn->prepare($sql);
    $sql_stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
    
    $sql_stmt->execute();
    
    if($sql_stmt->rowCount() > 0){
        $linha = $sql_stmt->fetch(PDO::FETCH_ASSOC);
        if(password_verify($dados['senha'], $linha['senha']) && $linha['email'] === $dados['email']){
            $_SESSION['id'] = $linha['id'];
            $_SESSION['nome'] = $linha['nome'];
            header("Location: index.php");
        }   
    }else{
        $erro['msg'] = 'Usuário ou senha inválida';
    }
}
?>
<main>
    <div class="container">
        <form action="#" method="post" class="form-login">
            <div class="container">
                <div class="title">
                    <h1>Login</h1>
                </div>
                <?php if(isset($erro['msg'])){ ?>
                    <div class="alert-error">
                        <?= $erro['msg'] ?>
                        <?php unset($erro['msg']) ?>
                    </div>  
                <?php } ?>  
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
			    </div>
                <div class="text">
                    <p>ou use seu e-mail</p>
                </div>
                <input type="text" name="email" id="email" placeholder="E-mail"> 
                <input type="password" name="senha" id="senha" placeholder="Senha">
            </div>
            <div class="text">
                <a href="">Esqueceu sua senha?</a>
            </div>
            <div class="btn-container">
                <input type="submit" value="Entrar" class="btn btn-login">
            </div>
            <br>
            <div class="text">
                <a href="cadastre.php">Não tem uma conta? cadastre-se</a>
            </div>
        </form>
    </div>
</main>

<?php 
    include __DIR__ . '/includes/footer.php';
?>