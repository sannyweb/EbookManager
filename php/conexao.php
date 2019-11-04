<?php
$link = mysqli_connect("localhost","root","root","ebookmanager");
if($link){
    // echo "<p class=\"error\">"."Conexão feita com sucesso! Você esta conectado!"."</p>";
    mysqli_set_charset($link,"utf8");
    date_default_timezone_set("America/Manaus");
}else{
    echo "<p class=\"error\">"."Aparentemente houve um erro, problema abaixo: "."</p>";
    echo "<p class=\"error\">".mysqli_connect_error($link)."</p>";
    echo "<p class=\"error\">"."Código do erro: ".mysqli_connect_errno($link)."</p>";
    return die;
}

?>