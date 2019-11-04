<?php
      session_start(); //Inicia as sessões
?>
<!DOCTYPE html>
<html>
<head lang="pt-br">
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>E-Book Manager</title>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.29/browser.min.js"></script>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
   <link rel="icon" href="img/icon.png">
   <script src="js/main.js" async></script>
<?php 
include "php/conexao.php"; // Includo a conexão no arquivo
include "php/logout.php";


//echo cal_days_in_month(CAL_GREGORIAN,9,2018); Retorna o dias do mês 9;
$dataHoje = date("Y-m-d"); 
if(!mysqli_query($link,"select idLivros from Livros")){   
      echo "<p class=\"error\">"."Houve um erro ao executar a query: ".mysqli_error($link)."</p>";
}else{
      $result = mysqli_query($link,"select idLivros from Livros");
      $qtdLivro = mysqli_num_rows($result); // Pega quantidade de linhas totais de livros
      $randomLivro = random_int(1,$qtdLivro);

      $dest = "select idLivros,dataTrocar from Destaques";
      $resultado = mysqli_query($link,$dest);
      $destaques = mysqli_fetch_array($resultado);
      $idDestaques = $destaques['idLivros'];

      if($destaques['dataTrocar']==$dataHoje){
            $dataNova = strftime("%Y-%m-%d",strtotime("+7days"));
            $query = "UPDATE Destaques SET idLivros='".$randomLivro."' where idDestaques=1";
            $resultado = mysqli_query($link,$query);
            $query = "UPDATE Destaques SET dataTrocar='".$dataNova."' where idDestaques=1";
            $resultado = mysqli_query($link,$query);
      }
?>
</head>
<body>
   <!-- Todo o conteúdo -->
   <div class="container">

      <!-- Header principal -->
      <header class="header">
         <h1><a href="index.php">Ebook-Manager</a></h1>

      <!-- Menu horizontal -->
      <nav class="menu">
         <a href="index.php"><div class="btn-home" id="btn-home"></div></a>
         <div class="show-menu-items" id="show-menu-items"></div>

           <!--  <span>EBM</span> -->

         <div class="menu-items">
            <div class="mobile-search"><form action="search/">
                  <div class="input-group">
                     <input type="search" name="search" id="m-search" placeholder="Procurar livros">
                     <button type="submit"></button>
                  </div>
               </form>
            </div>
            <a href="#destaque">Destaque</a>
            <?php 
            if(!isset($_SESSION['idUsuarios']) and !isset($_SESSION['username'])){
            ?>
            <a href="#cadastro">Cadastro</a>
            <?php }?>
            <a href="#categorias">Categorias</a>
            <a href="#tags">Tags</a>
            <a href="#mais-visitados">Mais visitados</a>
         </div>
         
      </nav>
      </header>

      <!-- Conteúdo principal -->
      <main class="main">

         <div class="main-content">
            <!-- Livro de destaque -->
            <?php 
            $result = mysqli_query($link,"select l.titulo,l.caminhoCover,l.autor,l.aboutAutor,l.anoPublicacao,l.paginas,l.editora,l.tituloOriginal,l.sinopse,g.generos from Livros l join Generos g on l.idGeneros=g.idGeneros where idLivros='$idDestaques'");
            $LivroDestaque = mysqli_fetch_array($result);
            ?>
            <div class="destaque" id="destaque">
               <div class="destaque-capa"><img src="img/capas/<?=$LivroDestaque['caminhoCover']?>" alt="Capa"></div>

               <div class="detalhes">
                  <h3>Destaque</h3>

                  <table>
                     <tr>
                        <th>Título</th>
                        <td><?=$LivroDestaque['titulo']?></td>
                     </tr>

                     <tr>
                        <th>Título Original</th>
                        <td><?=$LivroDestaque['tituloOriginal']?></td>
                     </tr>

                     <tr>
                        <th>Editora</th>
                        <td><?=$LivroDestaque['editora']?></td>
                     </tr>

                     <tr>
                        <th>Gênero</th>
                        <td><?=$LivroDestaque['generos']?></td>
                     </tr>

                     <tr>
                        <th>Autor</th>
                        <td><?=$LivroDestaque['autor']?></td>
                     </tr>

                     <tr>
                        <th>Ano de lançamento</th>
                        <td><?=$LivroDestaque['anoPublicacao']?></td>
                     </tr>

                     <tr>
                        <th>Número de páginas</th>
                        <td><?=$LivroDestaque['paginas']?></td>
                     </tr>
                  </table>

                  <h4>Sinopse</h4>

                  <p class="sinopse">
                  <?=$LivroDestaque['sinopse']?>
                  <div class="blur">
                     <a href="book/?livros=<?=$idDestaques?>">Detalhes</a>
                  </div>
               </div>
            </div>

            <!-- 6 ultimos livros adicionados -->
            <div class="recentes">

               <h2>Adicionados recentemente</h2>
                <?php 
                $result = mysqli_query($link,"select l.idLivros,l.titulo,l.caminhoCover,l.autor,g.generos from Livros l join Generos g on l.idGeneros=g.idGeneros order by l.idLivros desc limit 6");
                while($ultimos = mysqli_fetch_array($result)){
                ?>
               <a href="book/?livros=<?=$ultimos['idLivros']?>">
                  <div class="recentes-item">
                     <img src="img/capas/<?=$ultimos['caminhoCover']?>" alt="Capa de <?$ultimos['l.titulo']=?>">
   
                     <div class="recentes-info">
                        <div class="recentes-item-titulo"><?=$ultimos['titulo']?></div>
                        <div class="recentes-item-autor"><?=$ultimos['autor']?></div>
                        <div class="recentes-item-genero"><?=$ultimos['generos']?></div>
                     </div>
                  </div>
               </a>
                <?php }?>


               <div class="btn-ver-mais">
                  <a href="search/?search=tudo">Ver mais</a>
               </div>
            </div>
         </div>
      </main>



      <!-- Categorias e pesquisa -->
      <aside class="aside">
         <div class="aside-content">
            <!-- Campo de pesquisa -->
            <div class="search">
            <form action="search/">
                  <div class="input-group">
                  <input type="search" name="search" id="" placeholder="Procurar livros" required>
                  <button type="submit"></button>
                  </div>
            </form>
            </div>
            <?php 
            if(!isset($_SESSION['idUsuarios']) and !isset($_SESSION['username'])){
            /*Se as sessões derem vazias*/
            ?>
            <!-- Campo de cadastro e login -->
            <div class="cadastro" id="cadastro">
               <h4>Cadastro / Login</h4>
               <?php 
               if(isset($_SESSION['msg'])){
                  echo $_SESSION['msg'];
                  unset($_SESSION['msg']);
               } 
               ?>
               <form action="php/EntrarOuCadastrar.php" method="POST">
                  <div class="input-group">
                     <input type="text" name="username" id="username" placeholder="Username">
                     <span class="ico-user"></span>
                  </div>

                  <div class="input-group">
                     <input type="password" name="password" id="password" placeholder="Senha">
                     <span class="ico-pass"></span>
                  </div>
   
                  <div class="input-group">
                     <input type="email" name="email" id="email" placeholder="E-mail">
                     <span class="ico-email"></span>
                  </div>

                  <input type="submit" name="btnCadastro" value="Confirmar">

               </form>
            </div>

            <!-- Card usuário logado -->
            <?php 
            }else if(isset($_SESSION['idUsuarios']) and isset($_SESSION['username'])){
            /*Se as sessões não derem vazias */
            ?>
            <div class="user-info">
                  <div class="user-info-name"><?=$_SESSION['username']?> <a href="?sair=logout" class="logout" title="Logout"></a></div>
                  <!-- Decidir o que vai mostrar de info do usuário -->
                  <a href="user-panel/index.php">Gerenciar</a>
            </div>
            <?php }?>


            <!-- Menu de categorias -->
            <div class="menu-categorias" id="categorias">
                <h4>Categorias</h4>
                <!--Container categorias-->
                <ul>
                    <?php 
                    $result = mysqli_query($link,"select generos from Generos");
                    while($ln = mysqli_fetch_array($result)){
                    ?>
                    <li><a href="search/?generos=<?=$ln['generos']?>"><?=$ln['generos']?></a></li>
                    <?php }?>
                </ul>
            </div>

            <!-- Mais visitados -->
            <div class="mais-visitados" id="mais-visitados">
                    <h4>Mais visitados</h4>
                    <!--Container Visitados-->
                    <div class="livros">
                        <?php 
                        $result = mysqli_query($link,"select idLivros,autor,caminhoCover,titulo from Livros order by visitas desc limit 4");
                        while($ln = mysqli_fetch_array($result)){
                        ?>
                        <div class="livros-item">
                              <img src="img/capas/<?=$ln['caminhoCover']?>" alt="">
                              <span><?=$ln['titulo']?> - <?=$ln['autor']?></span>
                              <a href="book/?livros=<?=$ln['idLivros']?>">Detalhes</a>
                        </div>
                        <?php }?>
                  </div>
            </div>

            <!-- Campo de tags -->
            <div class="tags" id="tags">
               <h4>Tags</h4>

               <div class="container-tags">
                    <?php 
                    $cont = mysqli_query($link,"select idTags from Tags");
                    $total = mysqli_num_rows($cont);
                    $random = random_int(1,$total);
                    $result = mysqli_query($link,"select tags from tags limit $random,6");
                    while($ln = mysqli_fetch_array($result)){
                    ?>
                    <span class="tag-item"><a href="search/?tags=<?=$ln['tags']?>"><?=$ln['tags']?></a></span>
                    <?php }?>
                </div>

            </div>

         </div>
      </aside>


      <!-- Rodapé -->
      <footer class="footer">
            <div class="footer-titulo">Desenvolvido por</div>

            <div class="contato">
                  <h3>Alysson Lopes</h3>

                  <a href="https://www.facebook.com/profile.php?id=100008472224581" target="_blank" data-descr="Alysson Lopes"><div class="contato-item face"></div></a>
                  <a href="https://www.instagram.com/nexusaf/" target="_blank" data-descr="Nexusaf"><div class="contato-item instagram"></div></a>
                  <a href="mailto:nexus.af@gmail.com" target="_top" data-descr="nexus.af@gmail.com"><div class="contato-item at"></div></a>
                  <span class="no-link" data-descr="(92) 99272-8451"><div class="contato-item wpp"></div></span>
            </div>
            <div class="contato">
                  <h3>Ruan Barroso</h3>

                  <a href="#" target="_blank" data-descr="Ruan Barroso"><div class="contato-item face"></div></a>
                  <a href="#" target="_blank" data-descr="Ruanx14"><div class="contato-item instagram"></div></a>
                  <a href="mailto:ruanx14@gmail.com" target="_blank" data-descr="ruanx14@gmail.com"><div class="contato-item at"></div></a>
                  <span class="no-link" data-descr="(00) 00000-0000"><div class="contato-item wpp"></div></span>
            </div>

            <div class="da42">&copy; Copyright AR 2018. Alunos da Fundação Paulo Feitosa. Projeto Final</div>
      </footer>

            </div>
      <script>
            window.onload = () => {
                  document.body.style.backgroundImage = "linear-gradient(to bottom, transparent, #f0f0f0, #f0f0f0, #f0f0f0, #f0f0f0, #f0f0f0), url(img/head.jpg)";
            }
      </script>
<?php }?>
</body>
</html>