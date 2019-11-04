<?php 
include "../php/antiSql.php";
$cont = 0;
$order = "";
$other = false;
$vazio = false;
if(isset($_GET['generos'])){ // Verifica se vim de generos
      $where = "g.generos";
      $pesquisa = $_GET['generos'];
      $valor = $_GET['generos'];
      $other = true;
}
if(isset($_GET['tags'])){ // verificar se vim de tags
      $pesquisa = $_GET['tags'];
      $valor = $_GET['tags'];
      $where = "t.tags";
      $other = true;
}
if(!$other){ // verifica parametro vazio ou pesquisa em branco ou parametro com valor
      if(!isset($_GET['search'])){
            header("Location: ?search=tudo");
      }else{
            if($_GET['search']=="tudo"){          
                  $valor = "tudo...";
                  $pesquisa = $_GET['search'];
                  $vazio = true;
            }else if($_GET['search']==""){
                  header("Location: ?search=tudo");  
            }else{
                  $pesquisa = $_GET['search'];
                  $where = "l.titulo";
                  $valor = $_GET['search'];
            }
      }
}
//echo $pesquisa;
addslashes($pesquisa);
if(stristr($pesquisa,";")){
      header("Location: ?search=tudo");
}
$parametros = $_SERVER['QUERY_STRING'];
parse_str($parametros,$output);
$link1 = $output;
$link2 = $output;
$link3 = $output;
$link4 = $output;
$link1['order'] = "alfabetica";
$link2['order'] = "recentes";
$link3['order'] = "visitados";
$link4['order'] = "anoPublicacao";

if(isset($_GET['txt'])){
      if($_GET['txt']=="next"){
            $cont = $_GET['num'];
            $cont = $cont + 8;
      }else if($_GET['txt']=="back"){
            $cont = $_GET['num'];
            if(!$cont<8){
                  $cont = $cont - 8;
            }
      }
}
if(isset($_GET['order'])){
      switch($_GET['order']){
            case "anoPublicacao":
            $order = "order by l.anoPublicacao desc";
            break;
            case "visitados":
            $order = "order by l.visitas desc";
            break;
            case "recentes":
            $order = "order by l.idLivros desc";
            break;
            case "alfabetica": 
            $order = "order by l.titulo asc";
            break;
            default:
            $order = "";
            break;
      }
}
if(antiSql($pesquisa)){
      header("Location: ../");
}
if(!$vazio){
      $sql = "select l.idLivros,l.titulo,l.autor,l.tituloOriginal,l.editora,g.generos,l.anoPublicacao,l.caminhoCover,l.paginas from Generos g join Livros l on g.idGeneros=l.idGeneros left join Livros_Tags lt on lt.idLivros=l.idLivros left join Tags t on lt.idTags=t.idTags where $where like '%$pesquisa%' group by l.idLivros $order limit $cont,8";
      $result = mysqli_query($link,$sql);
      $lines = mysqli_num_rows($result);
      /**All contador em baixo - Query para filtrar em cima */
      $sqlAll = "select l.idLivros from Generos g join Livros l on g.idGeneros=l.idGeneros left join Livros_Tags lt on lt.idLivros=l.idLivros left join Tags t on lt.idTags=t.idTags where $where like '%$pesquisa%' group by l.idLivros $order";
      $resultado = mysqli_query($link,$sqlAll);
      $linhas = mysqli_num_rows($resultado);

}else{
      $sql = "select l.idLivros,l.titulo,l.autor,l.tituloOriginal,l.editora,g.generos,l.anoPublicacao,l.caminhoCover,l.paginas from Generos g join Livros l on g.idGeneros=l.idGeneros left join Livros_Tags lt on lt.idLivros=l.idLivros left join Tags t on lt.idTags=t.idTags group by l.idLivros $order limit $cont,8";
      $result = mysqli_query($link,$sql);
      $lines = mysqli_num_rows($result);
      /**All contador em baixo - Query para filtrar em cima */
      $sqlAll = "select l.idLivros from Generos g join Livros l on g.idGeneros=l.idGeneros left join Livros_Tags lt on lt.idLivros=l.idLivros left join Tags t on lt.idTags=t.idTags  group by l.idLivros $order";
      $resultado = mysqli_query($link,$sqlAll);
      $linhas = mysqli_num_rows($resultado);

}
$pagNext = $output;
$pagNext['txt'] = "next";
$pagNext['num'] = $cont;
$pagBack = $output;
$pagBack['txt'] = "back";
$pagBack['num'] = $cont;
?>