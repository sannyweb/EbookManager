<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php 
include "../php/conexao.php";
if($_SESSION['tipo']){
    if($_SESSION['tipo']!="ADMINISTRADOR"){
        header("Location: ../");        
    }
}else{
    header("Location: ../");
}
$btn = filter_input(INPUT_POST,"btn",FILTER_SANITIZE_STRING);
if($btn){
    $dados = filter_input_array(INPUT_POST,FILTER_DEFAULT);
    $up = "UPDATE Comentarios SET aceito='".$dados['aceito']."' where idComentarios='".$dados['id']."'";
    $resp = mysqli_query($link,$up);
    if($resp && $dados['aceito']=="SIM"){
        $erro = "Comentário aceito =D";
    }else if($resp){
        $erro = "Comentário negado =(";
    }
}
?>
<head>
    <meta charset="utf-8" />
    <meta name="author" content="Ruan Barroso" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="nav.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="corpo-coment.css" />
    <link rel="icon" href="../img/icon.png">
    <title>Comentários</title>
</head>
<body>
    <header>
        <nav>
            <a href="index.php" class="item">Novo Livro</a>
            <a href="g_t.php" class="item">Novo G/T</a>
            <a href="comentarios.php" class="item">Comentários</a>
            <a href="../" class="item">Voltar</a>
        </nav>
    </header>
<main>
<div class="title">
    <h1>Comentários</h1>
</div>
<div class="corpo">
    <?php
    if(isset($erro)){
        echo "<p class=\"error\">".$erro."</p>";
        unset($erro);
    }
    $init = 0;
    $top = mysqli_query($link,"select * from Comentarios where aceito='Espera'");
    $lines = mysqli_num_rows($top);
    $pag = round($lines/5)+1;
    if(!isset($_GET['op'])){
        $sql = "SELECT * FROM Comentarios c join Usuarios u on c.idUsuarios=u.idUsuarios where aceito='Espera' limit $init,5";
    }else{
        $init = $_GET['op'];
        $sql = "SELECT * FROM Comentarios c join Usuarios u on c.idUsuarios=u.idUsuarios where aceito='Espera' limit $init,5";
    }
    $result = mysqli_query($link,$sql);
    while($info = mysqli_fetch_array($result)){
    ?>
    <div class="element">
        <article><strong><?=$info['username']?></strong><label><?=$info['data']?></label></article>
        <p><?=$info['texto']?></p>
        <form action="" method="POST">
            <label>Aceito: </label>
            <select name="aceito" id="<?=$info['idComentarios']?>">
            <option value="SIM">SIM</option>
            <option value="NAO">NAO</option>
            </select>
            <input type="submit" name="btn" value="Aceitar/Negar">
            <input type="text" name="id" style="visibility: hidden" value="<?=$info['idComentarios']?>">
        </form>
    </div>    
    <?php } ?>
</div>
<div class="pag">
    <?php 
    $tt = 0;
    $i = 1;
    if($pag>1){
    while($i<=$pag){
        echo "<a href=\"?op=$tt\">$i</a>";
    $tt+=4;
    $i++;
    }
    }
    ?>
</div>
</main>  
<!--Ruan Barroso-->
</body>
</html>