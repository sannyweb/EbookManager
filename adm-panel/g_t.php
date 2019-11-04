<?php 
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="author" content="Ruan Barroso" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="nav.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="corpo-simple.css" />
    <link rel="icon" href="../img/icon.png">
    <title>Novo G/T</title>
<?php 
include "../php/conexao.php";
if($_SESSION['tipo']){
    if($_SESSION['tipo']!="ADMINISTRADOR"){
        header("Location: ../");        
    }
}else{
    header("Location: ../");
}
$btnGenero = filter_input(INPUT_POST,"btnConfir",FILTER_SANITIZE_STRING);
if($btnGenero){
    $genero = $_POST['genero'];
    if(!empty($genero)){
        $result = mysqli_query($link,"select generos from Generos where generos='$genero'");
        if(mysqli_num_rows($result)>0){
            $erro = "Genero já cadastrado!";
        }else if(strlen($genero)<3){
            $erro = "Nome de gênero muito curto!";
        }else{
            mysqli_query($link,"INSERT INTO Generos(idGeneros,generos) values (null,'$genero')");
            $erro = "Gênero adicionado no seu website =D!";
        }
    }else{
        $erro = "Escreva um genero!";
    }
}

$btnTag = filter_input(INPUT_POST,"btnConfirmar",FILTER_SANITIZE_STRING); //kk
if($btnTag){
    $tag = $_POST['tag'];
    if(!empty($tag)){
        $result = mysqli_query($link,"select tags from tags where tags='$tag'");
        if(mysqli_num_rows($result)>0){
            $erro = "Tag já cadastrada!";
        }else if(strlen($tag)<3){
            $erro = "Nome de tag muito curto!";
        }else{
            mysqli_query($link,"INSERT INTO tags (idTags,tags) values (null,'$tag')");
            $erro = "Tag adicionada no seu website =D!";
        }
    }else{
        $erro = "Escreva uma tag!";
    }
}
?>
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
        <h1>Novo Genero/Nova Tag</h1>
    </div>
    <div class="corpo">
        <?php 
        if(isset($erro)){
            echo "<p class=\"error\">".$erro."</p>";
            unset($erro);
        }
        ?>
        <form action="" method="POST">
            <label for="genero">Genero: </label>
            <input id="genero" name="genero" type="text" placeholder="Novo genero aqui">
            <input type="submit" name="btnConfir" value="Confirmar!">
        </form>
        <form action="" method="POST">
            <label for="tag">Tag: </label>
            <input id="tag" name="tag" type="text" placeholder="Nova tag aqui">
            <input type="submit" name="btnConfirmar" value="Confirmar!">
        </form>
    </div>
</main>
<!--Ruan Barroso-->
</body>
<script>
window.onload = function(){
    first = document.getElementById("genero");
    console.log(first);
    first.focus();
}
</script>
</html>