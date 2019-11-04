<?php 
    session_start();
?>
<?php 
include "../php/conexao.php";
include "../php/logout.php";
include "../php/antiSql.php";
/*******************************/
if(!isset($_GET['livros'])){ // Verifica se tem um livro no parametro da URL
    header("Location: ../");
}else{
    $idLivros = $_GET['livros'];
    mysqli_query($link,"update Livros set visitas=(visitas+1) where idLivros=$idLivros");
    $result = mysqli_query($link,"select titulo from Livros where idLivros=$idLivros limit 1");
    $titulo = mysqli_fetch_array($result);
}
/*******************************/
?>
<!DOCTYPE html>
<html>
<head lang="pt-br">
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title><?=$titulo['titulo']?></title>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.29/browser.min.js"></script>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css" />
   <link rel="stylesheet" type="text/css" media="screen" href="../css/book.css" />
   <link rel="icon" href="../img/icon.png">
   <script src="../js/main.js" async></script>
</head>
<?php 
if(!isset($_SESSION['username'])){ // Verifica o disabled dos botoes de comentario
    $cool = "disabled";
    $text = "Você precisa estar logado para deixar um comentário!";
}else{
    $cool = ""; 
    $text = "Tenha moderação nas palavras, ".$_SESSION['username'];
}
/*******************************/
$btn = filter_input(INPUT_POST,"sendComment",FILTER_SANITIZE_STRING);
$erro = false;
if($btn){ // Faz o Insert em comentário e validações
    if(isset($_SESSION['username'])){
        $dados_rc = filter_input_array(INPUT_POST,FILTER_DEFAULT);
        $dados_tg = array_map("strip_tags",$dados_rc);
        $dados = array_map("trim",$dados_tg);
    
        if(in_array("",$dados)){
            $erro = true;
            $msg = "Sem campos vazios!";
        }else if(stristr($dados['msg'],"'") || stristr($dados['msg'],";") ){
            $erro = true;
            $msg = "Sem ; ou ' !";
        }else if(antiSql($dados['msg'])){
            $erro = true;
            $msg = "No way to your bad actions!";
        }
        if(!$erro){
        $sql = "INSERT INTO Comentarios (idUsuarios,idLivros,texto,data,aceito) values ( 
        '".$_SESSION['idUsuarios']."',
        $idLivros,
        '".$dados['msg']."',
        now(),
        'Espera'        
        )";
        $result = mysqli_query($link,$sql);
            if($result){
                $msg = "Comentário esperando aprovação da moderação!";
            }else{
                $msg = "Houve algum problema no seu comentário!";
            }
        }
    }else{
        $_SESSION['msg'] = "Você precisa estar logado amiguinho!";
        echo "<meta http-equiv='refresh' content='0 URL=../'>";
    }
}

?>
<body>
   <!-- Todo o conteúdo -->
   <div class="container">

      <!-- Header principal -->
      <header class="header">
         <h1><a href="../">Ebook-Manager</a></h1>

      <!-- Menu horizontal -->
      <nav class="menu">
         <a href="../index.php"><div class="btn-home" id="btn-home"></div></a>
         
        <!--  <span>EBM</span> -->

         <div class="show-menu-items" id="show-menu-items"></div>
         <div class="menu-items">
            <div class="mobile-search"><form action="../search/">
                  <div class="input-group">
                     <input type="search" name="search" id="m-search" placeholder="Procurar livros">
   
                     <button type="submit"></button>
                  </div>
               </form>
            </div>
            <?php 
            if(!isset($_SESSION['idUsuarios']) and !isset($_SESSION['username'])){
            ?>
            <a href="#cadastro">Cadastro</a>
            <?php }?>
            <a href="#categorias">Categorias</a>
            <a href="#tags">Tags</a>
            <a href="#resenhas">Resenhas</a>
            <a href="#comentarios">Comentários</a>
            <a href="#mais-visitados">Mais visitados</a>
         </div>
         
      </nav>
      </header>

      <!-- Conteúdo principal -->
      <main class="main">
            <div class="back-btn">
                  <div class="home"><a href="../index.php">&#171; Home</a></div>
                  <div class="last-page" onclick="window.history.back();">&lsaquo; Página anterior</div>
            </div>

         <!-- Detalhes sobre o livrossss -->
         <div class="main-content">
           
            <!-- Seção sobre o livro -->
            <?php
            $result = mysqli_query($link,"select l.titulo,l.autor,l.sinopse,l.caminhoCover,l.anoPublicacao,l.tituloOriginal,l.editora,g.generos,l.paginas,l.aboutAutor from Livros l join Generos g on l.idGeneros=g.idGeneros where l.idLivros=$idLivros");
            $info = mysqli_fetch_array($result);
            ?>
            <div class="livro-info-container">
               <img src="../img/capas/<?=$info['caminhoCover']?>" alt="Capa do livro <?=$info['titulo']?>">

               <h4 class="titulo-livro"><?=$info['titulo']?></h4>

               <p><?=$info['sinopse']?></p>

               <h4 class="sobre">Sobre o Autor</h4>

               <p><span class="nome-do-autor"><?=$info['autor']?>: </span><?=$info['aboutAutor']?></p>

               <div class="informacoes-livro">
                  <h4>Informações técnicas</h4>
   
                  <table>
                        <tr>
                           <th>Título</th>
                           <td><?=$info['titulo']?></td>
                        </tr>
   
                        <tr>
                           <th>Título Original</th>
                           <td><?=$info['tituloOriginal']?></td>
                        </tr>
   
                        <tr>
                           <th>Editora</th>
                           <td><?=$info['editora']?></td>
                        </tr>
   
                        <tr>
                           <th>Gênero</th>
                           <td><?=$info['generos']?></td>
                        </tr>
   
                        <tr>
                           <th>Autor</th>
                           <td><?=$info['autor']?></td>
                        </tr>
   
                        <tr>
                           <th>Ano de lançamento</th>
                           <td><?=$info['anoPublicacao']?></td>
                        </tr>
   
                        <tr>
                           <th>Número de páginas</th>
                           <td><?=$info['paginas']?></td>
                        </tr>
                     </table>
               </div>
            
               <input type="checkbox" name="download" id="download">
               <label for="download" class="btn-dowload">Arquivos</label>
               <div class="files">
                    <div class="item-download">
                        <table>
                            <tr>
                                <th>Tamanho</th>
                                <th>Nome</th>
                                <th>Enviado por</th>
                                <th>Download</th>
                            </tr>
                            <?php 
                            $titulo = $info['titulo'];
                            $autor = $info['autor'];
                            $result = mysqli_query($link,"select m.caminhoEpub,u.username,m.tamanhoEpub from Managers m join Usuarios u on m.idUsuarios=u.idUsuarios where m.titulo like '%$titulo%' and m.autor like '%$autor%' and m.nivel='publico'");
                            if(isset($_SESSION['idUsuarios'])){
                                if(mysqli_num_rows($result)>0){
                                    while($info = mysqli_fetch_array($result)){
                            ?>
                            <tr>
                                <td><?=$info['tamanhoEpub']?></td>
                                <td><?=$info['caminhoEpub']?></td>
                                <td><?=$info['username']?></td>
                                <td><a href="../user-panel/epubs/<?=$info['caminhoEpub']?>">Download</a></td>
                            </tr>
                            <?php 
                                    }
                                }else{
                                    echo "<p class=\"error\">"."Este livro não possui downloads"."</p>";
                                }
                            }else{
                                echo "<p class=\"error\">"."Você precisa estar logado para ver os downloads"."</p>";
                            }
                            ?>
                        </table>
                    </div>
               </div>
            
            
            </div>


            <!-- Resenhas -->
            <div class="resenhas" id="resenhas">
               <h3>Resenhas</h3>

               <!-- Box para cada resenha -->
               <?php 
                        $result = mysqli_query($link,"select r.titulo,u.username,r.datepost,r.texto from Livros l join Resenhas r on l.idLivros=r.idLivros join Usuarios u on r.idUsuarios=u.idUsuarios where l.idLivros=$idLivros
                        ");
                        if(mysqli_num_rows($result)>0){
                            while($info = mysqli_fetch_array($result)){
                        ?>
                        <div class="box-resenha">
                           <div class="user-info left">
                              <span class="nick-name"><?=$info['username']?></span>
                              <span class="data-resenha"><?=$info['datepost']?></span>
                           </div>

                           <div class="right">
                              <h4 class="titulo-resenha"><?=$info['titulo']?></h4>
            
                              <div class="corpo-resenha">
                                <p>
                                    <?php 
                                    $array = [];
                                    $diretorio = $info['texto'];
                                    $arquivo = fopen("../resenhas/arquivos/$diretorio","r");
                                    while(!feof($arquivo)){
                                    $linha = fgetcsv($arquivo,null,"\n");
                                    array_push($array,$linha[0]);
                                    //or echo $linha[0];
                                    }
                                    fclose($arquivo);
                                    $texto = implode(" ",$array);
                                    strip_tags($texto);
                                    echo $texto; 
                                    ?>
                                </p>                 
                              </div>
                           </div>
                        </div>
                        <?php 
                            }
                        }else{
                            echo "<p class=\"error\">"."Este livro não possui resenhas"."</p>";
                        }
                        ?>




               <a href="../resenhas/?livros=<?=$idLivros?>" class="ver-mais-resenhas">Escreva uma/Leia Mais</a>
            </div>

            <!-- Comentários sobre o livro -->
            <div class="comentarios" id="comentarios">
                <h3>Comentários</h3>

                <!-- Deixe o seu comentário -->
                <div class="deixar-comentario">
                  <form action="" method="POST">
                        <textarea name="msg" id="msg" placeholder="Deixe seu comentário sobre esse livro" <?=$cool?> title="<?=$text?>"></textarea>
                        <input type="submit" value="Postar" name="sendComment" <?=$cool?> title="<?=$text?>">
                  </form>
                </div>
                <?php 
                if(isset($msg)){
                    echo "<p style=\"text-align: center; background-color: grey; color: white;\">".$msg."</p>";
                    unset($erro);
                }
                ?>
               <!-- Comentário individual -->
               <?php 
               $result = mysqli_query($link,"select c.data, u.username, c.texto from Comentarios c join Usuarios u on u.idUsuarios=c.idUsuarios where idLivros=$idLivros and aceito='SIM'");
                if(mysqli_num_rows($result)>0){
                    while($info = mysqli_fetch_assoc($result)){
               ?>
               <div class="box-comentario">
                  <div class="user-info">
                     <span class="nick-name"><?=$info['username']?></span>
                  </div>

                  <div class="corpo-comentario">
                     <p><?=$info['texto']?></p>
                     <p><span class="data-comentario"><?=$info['data']?></span></p>
                  </div>
               </div>
               <?php 
                    }
                }else{
                    echo "<p class=\"error\">"."Este livro não possui comentários"."</p>";
                }
                ?>
            </div>
         </div>
      </main>



      <!-- Categorias e pesquisa -->
      <aside class="aside">
         <div class="aside-content">
            <!-- Campo de pesquisa -->
            <div class="search">
            <form action="../search/">
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
                echo "<p class=\"error\">".$_SESSION['msg']."</p>";
                unset($_SESSION['msg']);
               }
               ?>
               <form action="../php/EntrarOuCadastrar.php" method="POST">
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
                  <div class="user-info-name"><?=$_SESSION['username']?><a href="?livros=<?=$idLivros?>&sair=logout" class="logout" title="Logout"></a></div>
                  <!-- Decidir o que vai mostrar de info do usuário -->
                  <a href="../user-panel/index.php">Gerenciar</a>
            </div>
            <?php }?>


            <!-- Menu de categorias -->
            <div class="menu-categorias" id="categorias">
               <h4>Categorias</h4>
               <ul>
                    <?php 
                    $result = mysqli_query($link,"select generos from Generos");
                    while($ln = mysqli_fetch_array($result)){
                    ?>
                    <li><a href="../search/?generos=<?=$ln['generos']?>"><?=$ln['generos']?></a></li>
                    <?php }?>
                </ul>
            </div>


            <!-- Mais visitados -->
            <div class="mais-visitados" id="mais-visitados">
                  <h4>Mais visitados</h4>
                   <div class="livros">
                        <?php 
                        $result = mysqli_query($link,"select idLivros,autor,caminhoCover,titulo from Livros order by visitas desc limit 4");
                        while($ln = mysqli_fetch_array($result)){
                        ?>
                        <div class="livros-item">
                              <img src="../img/capas/<?=$ln['caminhoCover']?>" alt="">
                              <span><?=$ln['titulo']?> - <?=$ln['autor']?></span>
                              <a href="../book/?livros=<?=$ln['idLivros']?>">Detalhes</a>
                        </div>
                        <?php }?>
                  </div>
            </div>

            <!-- Campo de tags -->
            <div class="tags" id="tags">
               <h4>Tags</h4>
               <div class="container-tags">
                    <?php 
                    $result = mysqli_query($link,"select t.tags, l.titulo from Tags t join Livros_Tags lt on lt.idTags=t.idTags join Livros l on lt.idLivros=l.idLivros where l.idLivros=$idLivros");
                    while($ln = mysqli_fetch_array($result)){
                    ?>
                    <span class="tag-item"><a href="../search/?tags=<?=$ln['tags']?>"><?=$ln['tags']?></a></span>
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

      </footer>

   </div>
   <script>
        window.onload = () => {
            document.body.style.backgroundImage = "linear-gradient(to bottom, transparent, #f0f0f0, #f0f0f0, #f0f0f0, #f0f0f0, #f0f0f0), url(../img/book-head.jpg)";
        }
    </script>
</body>
</html>