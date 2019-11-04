<?php 
    session_start();
?>
<!DOCTYPE html>
<html>
<head lang="pt-br">
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Resenhas</title>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.29/browser.min.js"></script>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css" />
   <link rel="stylesheet" type="text/css" media="screen" href="../css/book.css" />
   <link rel="stylesheet" type="text/css" media="screen" href="../css/resenha.css" />
   <link rel="icon" href="../img/icon.png">
   <script src="../js/main.js" async></script>
<?php
include "../php/conexao.php";
include "../php/logout.php";
include "../php/antiSql.php";

if(isset($_GET['livros'])){ // Verifica se tem um livro no parametro da URL
    $idLivros = $_GET['livros'];
}else{
    header("Location: ../");
}
if(!isset($_SESSION['username'])){ // Verifica o disabled no botão de enviar resenha
    $cool = "disabled";
}else{
    $cool = ""; 
}
$btn = filter_input(INPUT_POST,"sendResenha",FILTER_SANITIZE_STRING);
$erro = false;
if($btn){ // Faz o Insert em resenhas e validações
    if(isset($_SESSION['username'])){
        $dados_rc = filter_input_array(INPUT_POST,FILTER_DEFAULT);
        $dados_tg = array_map("strip_tags",$dados_rc);
        $dados = array_map("trim",$dados_tg);

        if(in_array("",$dados)){
            $erro = true;
            $msg = "Sem campos vazios!";
        }else if(antiSql($dados['titulo-resenha'])){
            $erro = true;
            $msg = "No way to your bad Actions!!";
        }

        if(!$erro){
            $diretorio = "arquivos/";
            $tmpNome = tempnam("arquivos/","now");
            //echo $tmpNome;
            if(file_exists("arquivos/resenha.txt")){
                $i = 0;
                while(file_exists("arquivos/resenha[".$i."].txt")){
                    $i++;
                }
                $novoNome = $diretorio."resenha[".$i."].txt";
                $nomeBd = "resenha[".$i."].txt";
                rename($tmpNome,$novoNome);
            }else{
                $novoNome = "arquivos/resenha.txt";
                rename($tmpNome,$novoNome);              
            }
            $arquivo = fopen("arquivos/$nomeBd","w");
            fwrite($arquivo,$dados['texto-resenha']);
            fclose($arquivo);

            $sql = "INSERT INTO Resenhas (idUsuarios,idLivros,titulo,texto,datepost) values (
            '".$_SESSION['idUsuarios']."',
            '$idLivros',
            '".$dados['titulo-resenha']."',
            '$nomeBd',
            now()
            )";
            $result = mysqli_query($link,$sql);
            if($result){
                $msg = "Parece que temos uma resenha nova em nosso Banco de dados =D!";
            }else{
                $msg = "Houve algum problema, nos desculpe =(";
            }

        }
    }else{
        $_SESSION['msg'] = "Você precisa estar logado amiguinho!";
        echo "<meta http-equiv='refresh' content='0 URL=../'>";
    }
}
?>
</head>
<body>
   <!-- Todo o conteúdo -->
   <div class="container">

      <!-- Header principal -->
      <header class="header">
         <h1><a href="../index.php">Ebook-Manager</a></h1>

      <!-- Menu horizontal -->
      <nav class="menu">
         <a href="index.php"><div class="btn-home" id="btn-home"></div></a>
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
            <div class="back-btn">
                  <div class="home"><a href="../index.php">&#171; Home</a></div>
                  <div class="last-page" onclick="window.history.back();">&lsaquo; Página anterior</div>
            </div>

         <div class="main-content">
               <div class="resenhas" id="resenhas">
                    <?php 
                    $result = mysqli_query($link,"select caminhoCover,titulo,autor from Livros where idLivros=$idLivros");
                    $info = mysqli_fetch_array($result);
                    ?>
                    <?php 
                    if(isset($msg)){
                    echo "<p class=\"alert\" style=\"width: 100%;\">".$msg."</p>";
                    unset($erro);
                    }
                    ?>
                    <h3>Resenhas sobre "<?=$info['titulo']?>"</h3>

                    <div class="livro">
                        <img src="../img/capas/<?=$info['caminhoCover']?>" alt="<?=$info['titulo']?>">

                        <div class="titulo-livro"><?=$info['titulo']?> - <?=$info['autor']?></div>

                        <button id="btn-add-resenha">Adicionar resenha</button>
                     </div>

                     <!-- Modal para escrever resenhas -->
                     <div class="modal-adicionar-resenha">
                        <span class="btn-fechar">&#10006;</span>

                        <div class="form-resenha">
                              <div class="titulo-livro"><?=$info['titulo']?> - <?=$info['autor']?></div>
                              <form action="" method="POST">
                                    <div class="input-group">
                                          <label for="titulo-resenha">Título da resenha</label>
                                          <input type="text" name="titulo-resenha" id="titulo-resenha">
                                    </div>

                                    <div class="input-group">
                                          <label for="texto-resenha">Escreva sua opinião sobre o livro</label>
                                          <textarea name="texto-resenha" id="texto-resenha" cols="" rows="10"></textarea>
                                    </div>
                                    <div class="input-group">
                                          <input type="submit" name="sendResenha" value="Enviar" <?=$cool?>>
                                    </div>
                              </form>
                        </div>
                     </div>
      
                     <div class="boxes">
                        <!-- Box para cada resenha -->
                        <?php 
                        $result = mysqli_query($link,"select r.titulo,u.username,r.datepost,r.texto from Livros l join Resenhas r on l.idLivros=r.idLivros join Usuarios u on r.idUsuarios=u.idUsuarios where l.idLivros=$idLivros
                        ");
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
                                $arquivo = fopen("arquivos/$diretorio","r");
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
                    <?php }?>
                     </div>
                     <!-- <a href="#" class="ver-mais-resenhas">Ver mais</a> -->
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
               echo $_SESSION['msg'];
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
                        $result = mysqli_query($link,"select titulo,caminhoCover,autor,titulo,idLivros from Livros order by visitas desc limit 4");
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
                     $result = mysqli_query($link,"select t.tags, l.titulo from tags t join Livros_Tags lt on lt.idTags=t.idTags join Livros l on lt.idLivros=l.idLivros where l.idLivros=$idLivros");
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
            const btnShow = document.querySelector("#btn-add-resenha");
            const modal = document.querySelector(".modal-adicionar-resenha");
            const fechar = document.querySelector(".btn-fechar");
         
            btnShow.onclick = () => {
                  modal.style.display = "block";
            }

            modal.onclick = (e) => {
                  if(e.target === modal || e.target === fechar){
                        modal.style.display = "none";
                  }
            }

        window.onload = () => {
            document.body.style.backgroundImage = "linear-gradient(to bottom, transparent, #f0f0f0, #f0f0f0, #f0f0f0, #f0f0f0, #f0f0f0), url(../img/res-head.jpg)";
        }
      </script>
</body>
</html>