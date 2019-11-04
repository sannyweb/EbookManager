<?php 
  session_start();
?>
<!DOCTYPE html>
<html>
<head lang="pt-br">
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Painel</title>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.29/browser.min.js"></script>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css" />
   <link rel="stylesheet" type="text/css" media="screen" href="../css/user-panel.css" />
   <script src="../js/main.js" async></script>
<?php
include "../php/conexao.php";
if(!isset($_SESSION['idUsuarios']) and !isset($_SESSION['username'])){
  header("Location: ../");
}else{
  $tipo = $_SESSION['tipo'];
}
?>
</head>
<body>
   <!-- Todo o conteúdo -->
   <div class="container user-panel">

      <!-- Header principal -->
      <header class="header">
         <h1><a href="../index.php">Ebook-Manager</a></h1>

         <!-- Menu horizontal -->
        <!--  <nav class="menu">
            <a href="../index.php"><div class="btn-home" id="btn-home"></div></a>

            <span>EBM</span>

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
               <a href="#cadastro">Cadastro</a>
               <a href="#categorias">Categorias</a>
               <a href="#tags">Tags</a>
            </div>
         </nav> -->
      </header>

      <!-- Conteúdo principal -->
      <main class="main">

         <div class="back-btn">
            <div class="home"><a href="../index.php">&#171; Home</a></div>
            <div class="last-page" onclick="window.history.back();">&lsaquo; Página anterior</div>

            <?php 
            if($tipo=="ADMINISTRADOR"){
            ?>
            <a class="adm" href="../adm-panel/">Painel Administrativo</a>
            <?php
            }
            ?>
         </div>

         <div class="main-content">
            <h3>Meus arquivos</h3>
            <?php 
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <div class="arquivos">
               <table>
                  <tr>
                     <th>Arquivo.epub</th>
                     <th>Tamanho(KB)</th>
                     <th>Título</th>
                     <th>Autor</th>
                  </tr>
                <?php 
                $result = mysqli_query($link,"select m.caminhoEpub,m.tamanhoEpub,m.titulo,m.autor from Managers m join Usuarios u on m.idUsuarios=u.idUsuarios where u.idUsuarios='".$_SESSION['idUsuarios']."' limit 10");
                while($ln = mysqli_fetch_array($result)){
                ?>
                  <tr>
                     <td><a href="epubs/"><?=$ln['caminhoEpub']?></a></td>
                     <td><?=$ln['tamanhoEpub']?></td>
                     <td><?=$ln['titulo']?></td>
                     <td><?=$ln['autor']?></td>
                  </tr>
                <?php
                }?>

               </table>
            </div>

         </div>

         <div class="enviar">
            <h3>Enviar arquivo</h3>
            <form action="enviarLivro.php" method="POST" enctype="multipart/form-data">

               <div class="input-group">
                  <input type="text" name="titulo" id="titulo-arquivo" placeholder="Título">
                  <input type="text" name="autor" id="autor-arquivo" placeholder="Autor">
               </div>

               <div class="input-group">
                  <label class="btn-arquivo">Escolher arquivo
                     <input type="file" name="livro" accept=".epub" id="arquivo" onchange="mostrarNome(this)">
                  </label>

                  <input type="radio" name="status" id="privado" value="privado">
                  <label for="privado" class="label-for-radio"><span>Privado</span></label>
                  
                  <input type="radio" name="status" id="publico" value="publico">
                  <label for="publico" class="label-for-radio"><span>Público</span></label>

               </div>
               <div class="input-group submit-group">
                  <div class="nome-arquivo" id="saida-nome-arquivo"></div>
   
                  <input type="submit" name="sendArquivo" value="Enviar arquivo">
               </div>
            </form>
            
         </div>
      </main>


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
      function mostrarNome(file) {
         var out = document.querySelector("#saida-nome-arquivo");
         out.textContent = file.files[0].name;
      }

      window.onload = () => {
          document.body.style.backgroundImage = "linear-gradient(to bottom, transparent, #f0f0f0, #f0f0f0, #f0f0f0, #f0f0f0, #f0f0f0), url(../img/panel-head.jpeg)";
      }
   </script>
</body>
</html>