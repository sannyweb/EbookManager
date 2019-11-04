<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head lang="pt-br">
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Pesquise</title>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.29/browser.min.js"></script>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" type="text/css" media="screen" href="../css/main.css" />
      <!-- <link rel="stylesheet" type="text/css" media="screen" href="../css/book.css" /> -->
      <link rel="stylesheet" type="text/css" media="screen" href="../css/search.css" />
      <link rel="icon" href="../img/icon.png">
      <script src="../js/main.js" async></script>
<?php
include "../php/conexao.php";
include "../php/logout.php";
include "build_query.php";
//echo $sql;
?>
</head>
<body>
      <!-- Todo o conteúdo -->
      <div class="container">

            <!-- Header principal -->
            <header class="header">
                  <h1><a href="../">Ebook-Manager</a></h1>

                  <!-- Menu horizontal -->
                  <nav class="menu">
                        <a href="../index.php">
                              <div class="btn-home" id="btn-home"></div>
                        </a>

                        <!-- <span>EBM</span> -->
                        <div class="show-menu-items" id="show-menu-items"></div>
                        <div class="menu-items">
                              <div class="mobile-search">
                                    <form action="">
                                          <div class="input-group">
                                                <input type="search" name="search" id="m-search" placeholder="Procurar livros">

                                                <button type="submit"></button>
                                          </div>
                                    </form>
                              </div>
                              <!-- Display: none se estiver logado -->
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
                        <div class="home"><a href="../">&#171; Home</a></div>
                        <div class="last-page" onclick="window.history.back();">&lsaquo; Página anterior</div>
                  </div>
                  <div class="main-content">

                        <!-- Resultado de pesquisas -->
                        <div class="pesquisas" id="pesquisa">

                              <h2 id="values">Resultado da busca por "<?=$valor?>"</h2>
                              <h4>Encontrados: <span id="contues" ><?=$linhas?></span></h4>

                              <!-- <h2>Nome da categoria</h2>
                              <h4><span>42 Livros em</span> Categoria</h4> -->

                              <!-- <h2>Nome da tag</h2>
                              <h4><span>35 livros</span></h4> -->

                              <div class="filtros-de-busca">

                                    <span>Ordenar por:</span>

                                    <div class="input-group">
                                          <a style="margin-left: 10px;" href="?<?=http_build_query($link1)?>">Ordem alfabetica</a>
                                    </div>

                                    <div class="input-group">
                                          <a style="margin-left: 10px;" href="?<?=http_build_query($link2)?>">Mais recentes</a>
                                    </div>
                                    <div class="input-group">
                                          <a style="margin-left: 10px;" href="?<?=http_build_query($link3)?>">Mais visitados</a>
                                    </div>
                                    <div class="input-group">
                                          <a style="margin-left: 10px;" href="?<?=http_build_query($link4)?>">Ano de lançamentos</a>
                                    </div>
                              </div>

                              <div class="resultados">
                                    <!-- Item encontrado -->
                                    <?php 
                                    $result = mysqli_query($link,$sql);
                                    while($ln = mysqli_fetch_array($result)){
                                    ?>
                                    <div class="item-busca">
                                          <img src="../img/capas/<?=$ln['caminhoCover']?>" alt="">

                                          <div class="item-busca-detalhes">
                                                <h3><a href="../book/?livros=<?=$ln['idLivros']?>"><?=$ln['titulo']?></a> - <?=$ln['autor']?></h3>

                                                <table>
                                                      <tr>
                                                            <th>Título</th>
                                                            <td><?=$ln['titulo']?></td>
                                                      </tr>

                                                      <tr>
                                                            <th>Título Original</th>
                                                            <td><?=$ln['tituloOriginal']?></td>
                                                      </tr>

                                                      <tr>
                                                            <th>Editora</th>
                                                            <td><?=$ln['editora']?></td>
                                                      </tr>

                                                      <tr>
                                                            <th>Gênero</th>
                                                            <td><?=$ln['generos']?></td>
                                                      </tr>

                                                      <tr>
                                                            <th>Autor</th>
                                                            <td><?=$ln['autor']?></td>
                                                      </tr>

                                                      <tr>
                                                            <th>Ano de lançamento</th>
                                                            <td><?=$ln['anoPublicacao']?></td>
                                                      </tr>

                                                      <tr>
                                                            <th>Número de páginas</th>
                                                            <td><?=$ln['paginas']?></td>
                                                      </tr>
                                                </table>
                                          </div>
                                    </div>
                                    <?php }?>
                              </div>

                              <div class="paginacao">
                                    <a href="?<?=http_build_query($pagBack)?>">&#171; Anterior</a> 
                                    <?php 
                                    if(!$linhas==$cont){
                                    ?>
                                    <a href="?<?=http_build_query($pagNext)?>">Próxima &#187;</a>
                                    <?php }?>
                              </div>
                        </div>
                  </div>

            </main>



            <!-- Categorias e pesquisa -->
            <aside class="aside">
                  <div class="aside-content">
                        <!-- Campo de pesquisa -->
                        <div class="search">
                              <form action="">
                                    <div class="input-group">
                                          <input type="search" name="search" id="search" placeholder="Procurar livros" required>
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
                              <div class="user-info-name"><?=$_SESSION['username']?> <a href="?sair=logout" class="logout" title="Logout"></a></div>
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
                                    <li><a href="?generos=<?=$ln['generos']?>"><?=$ln['generos']?></a></li>
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
                                    $cont = mysqli_query($link,"select idTags from Tags");
                                    $total = mysqli_num_rows($cont);
                                    $random = random_int(1,$total);
                                    $result = mysqli_query($link,"select tags from tags limit $random,6");
                                    while($ln = mysqli_fetch_array($result)){
                                    ?>
                                    <span class="tag-item"><a href="?tags=<?=$ln['tags']?>"><?=$ln['tags']?></a></span>
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
            document.body.style.backgroundImage = "linear-gradient(to bottom, transparent, #f0f0f0, #f0f0f0, #f0f0f0, #f0f0f0, #f0f0f0), url(../img/srch-head.jpeg)";
        }


       
      //Search in onkeyup!
      //I'm learning!
     /*  xmlhttp = new XMLHttpRequest();
      document.querySelector("#search").onkeyup = (obj) => {
      xmlhttp.open("GET","changeQuery.php?search="+obj.target.value,true);
      xmlhttp.send(null);
            xmlhttp.onreadystatechange = () => {
                  if(xmlhttp.readyState==4){
                        document.querySelector(".resultados").innerHTML = xmlhttp.responseText;
                        text = document.querySelector(".numrows").textContent;
                        text = JSON.parse(text);
                        document.querySelector("#contues").innerHTML = text.contagem;
                        document.querySelector(".numrows").style.display = "none";
                  }
            }
      document.querySelector("#values").innerHTML = "Resultado da busca por \""+obj.target.value+"\"";
      }
       */
        
        </script>
</body>
</html>