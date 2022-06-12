<nav>
    <a href="index.php" class="logo">homepet  </a>
    <ul class="nav-list">
        <?php if(count($_SESSION) > 0){?>
            <li><a href="index.php">Home</a></li>
        <?php } ?> 
        <li><a href="">Adote</a></li>
        <li><a href="">Apadrinhamento</a></li>
        <li><a href="divulgar_animal.php">Divulgar animal</a></li>
        <?php if(count($_SESSION) > 0){?>
            <li><a href="">Minha Conta</a></li>
            <li class="nav-btn"><a href="sair.php">Sair</a></li>
        <?php }else{ ?>
        <li class="nav-btn"><a href="login.php">Entrar</a></li>
        <li class="nav-btn"><a href="cadastre.php">Cadastre-se</a></li>
        <?php } ?>
    </ul>
</nav>