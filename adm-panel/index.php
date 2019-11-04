<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php 
include "../php/conexao.php";
if($_SESSION['tipo']){
    if($_SESSION['tipo']!="ADMINISTRADOR"){
        header("Location: ../");        
    }
}else{
    header("Location: ../");
}
?>
    <meta charset="utf-8" />
    <meta name="author" content="Ruan Barroso" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="nav.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="corpo.css" />
    <link rel="icon" href="../img/icon.png">
    <script src="corpo.js"></script>
    <title>Painel</title>
</head>
<body>
<header>
    <nav>
        <a href="" class="item">Novo Livro</a>
        <a href="g_t.php" class="item">Novo G/T</a>
        <a href="comentarios.php" class="item">Comentários</a>    
        <a href="../" class="item">Voltar</a>
    </nav>
</header>
<main>
    <div class="title">
        <h1>Novo Livro</h1>
    </div>
    <div class="bloco">
        <?php 
        if(isset($_SESSION['msg'])){
            echo "<p class=\"error\">".$_SESSION['msg']."</p>";
            unset($_SESSION['msg']);
        }
        ?>
        <div class="cont">
            <form action="cadastroLivro.php" method="POST" enctype="multipart/form-data">
                <article>
                    <label>Titulo:</label>
                    <input type="text" oninput="pri_mai(this)" id="first" name="titulo">
                </article>
                <article>
                    <label>Titulo Original:</label>
                    <input type="text" oninput="pri_mai(this)" name="tituloOriginal">
                </article>
                <article>
                    <label>Gêneros:</label>
                    <select name="generos">
                    <?php 
                    $result = mysqli_query($link,"select idGeneros,generos from Generos");
                    while($ln = mysqli_fetch_assoc($result)){
                    ?>
                    <option value="<?=$ln['idGeneros']?>"><?=$ln['generos']?></option>
                    <?php }?>
                    </select>
                </article>
                <article>
                    <label>Capa:</label>
                    <label for="input" class="here">Clique aqui para escolher a capa</label>
                    <input type="file" id="input" onchange="changeImg()" name="cover" accept="image/*">
                    <img alt="lol" src="" id="img">
                </article>
                <article>
                    <label>Editora:</label>
                    <input type="text" oninput="pri_mai(this)" name="editora">
                </article>
                <article>
                    <label>Autor:</label>
                    <input type="text" oninput="pri_mai(this)" name="autor">
                </article>
                <article>
                    <label>Ano de publicação:</label>
                    <input type="text" oninput="only_num(this)" name="anoPublicacao">
                </article>
                <article>
                    <label>Páginas</label>
                    <input type="text" oninput="only_num(this)" name="paginas">
                </article>
                <article>
                    <label>Sinopse:</label>
                    <textarea name="sinopse" oninput="pri_mai(this)" type="text" cols="100" rows="4"></textarea>
                </article> 
                <article>
                    <label>Sobre o autor:</label>
                    <textarea name="aboutAutor" oninput="pri_mai(this)" type="text" cols="100" rows="4"></textarea>
                </article> 
                <article>
                <label style="margin-bottom: 5px;">Tags:</label>
                <div class="tags">
                    <?php 
                    $result = mysqli_query($link,"select idTags,tags from Tags");
                    while($ln = mysqli_fetch_assoc($result)){
                    ?>
                    <input type="checkbox" name="tags[]" id="<?=$ln['idTags']?>" value="<?=$ln['idTags']?>">
                    <label for="<?=$ln['idTags']?>"><?=$ln['tags']?></label>
                    <?php 
                    }
                    ?>
                </div>
                </article>
                <article class="last">
                <input type="submit" name="sendlivro" value="Adicionar livro em nossa estante =D">
                </article>
            </form>
        </div>
    </div>
</main>
<!--Ruan Barroso-->
</body>
</html>