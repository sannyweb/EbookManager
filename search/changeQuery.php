<?php 
include "../php/conexao.php";
$search = $_GET['search'];
$pesquisa = $search;
$where = "l.titulo";
$sql = "select l.idLivros,l.titulo,l.autor,l.tituloOriginal,l.editora,g.generos,l.anoPublicacao,l.caminhoCover,l.paginas from Generos g join Livros l on g.idGeneros=l.idGeneros left join Livros_Tags lt on lt.idLivros=l.idLivros left join Tags t on lt.idTags=t.idTags where $where like '%$pesquisa%' group by l.idLivros";
$result = mysqli_query($link,$sql);
$num['contagem'] = mysqli_num_rows($result);
echo "<label class=\"numrows\">".json_encode($num)."</label>";
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
<?php 
}
?>
