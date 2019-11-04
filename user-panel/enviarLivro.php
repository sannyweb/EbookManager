<?php
session_start();
include "../php/conexao.php";
include "../php/antiSql.php";
$btn = filter_input(INPUT_POST,"sendArquivo",FILTER_SANITIZE_STRING);
$erro = false;
if($btn){        
    $dados_rc = filter_input_array(INPUT_POST,FILTER_DEFAULT);
    $dados_st = array_map("strip_tags",$dados_rc);
    $dados = array_map("trim",$dados_st);
    if($_FILES['livro']['error']==4){
            $erro = true;
            echo "<meta http-equiv='refresh' content='0 URL=index.php'>";
            $_SESSION['msg'] = "<p class='alert'>Não esqueça de enviar o epub</p>";
    }else if(in_array("",$dados)){
        $erro = true;
        echo "<meta http-equiv='refresh' content='0 URL=index.php'>";
        $_SESSION['msg'] = "<p class='alert'>Preencha todos os campos</p>";
    }
    if(!isset($dados['status'])){
        $erro = true;
        echo "<meta http-equiv='refresh' content='0 URL=index.php'>";
        $_SESSION['msg'] = "<p class='alert'>Preencha o tipo de privacidade deste arquivo</p>";
    }else if(antiSql($dados['titulo']) || antiSql($dados['autor'])){
        $erro = true;
        echo "<meta http-equiv='refresh' content='0 URL=index.php'>";
        $_SESSION['msg'] = "<p class='alert'>Something seems a little bad here.</p>";
    }
    $extensao = strtolower(substr($_FILES['livro']['name'],-5));
    if($extensao!=".epub"){
        $erro = true;
        echo "<meta http-equiv='refresh' content='0 URL=index.php'>";
        $_SESSION['msg'] = "<p class='error'>Apenas epub nesse site amigão</p>";
    }
    //var_dump($_FILES['livro']);
    if(!$erro){
        $titulo = $dados['titulo'];
        $novonome = trim($dados['titulo']);
        $extensao = strtolower(substr($_FILES['livro']['name'],-5));
        $tamanhoEpub = $_FILES['livro']['size']."KB";
        $diretorio = "epubs/";
        $txt = "epubs/".$novonome."[";
        if(file_exists("epubs/$novonome$extensao")){
            $i = 1;
            while(file_exists("$txt$i]$extensao")){
            $i++;
            }
            $novonome = $novonome."[".$i."]".$extensao;
            move_uploaded_file($_FILES['livro']['tmp_name'],$diretorio.$novonome);  
        }else{
            $novonome = $novonome.$extensao;
            move_uploaded_file($_FILES['livro']['tmp_name'],$diretorio.$novonome);  
        }
        $sql1 = "INSERT INTO Managers (idUsuarios,titulo,autor,tamanhoEpub,caminhoEpub,nivel) values (
        '".$_SESSION['idUsuarios']."',
        '".$dados['titulo']."',
        '".$dados['autor']."',
        '$tamanhoEpub',
        '$novonome',
        '".$dados['status']."'
        )";
        $result = mysqli_query($link,$sql1);
        if($result){
            echo "<meta http-equiv='refresh' content='0 URL=index.php'>";
            $_SESSION['msg'] = "<p class='success'>Novo livro enviado para seus arquivos</p>";
        }
    }
} 

?>