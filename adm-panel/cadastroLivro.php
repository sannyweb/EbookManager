<?php
include "../php/conexao.php";
session_start();
$btn = filter_input(INPUT_POST,"sendlivro",FILTER_SANITIZE_STRING);
$erro = false;
if($btn){
    $arrayValidate = [ 
        "titulo" => FILTER_SANITIZE_STRING,
        "tituloOriginal" => FILTER_SANITIZE_STRING,
        "generos" => FILTER_SANITIZE_STRING,
        "editora" => FILTER_SANITIZE_STRING,
        "autor" => FILTER_SANITIZE_STRING,
        "anoPublicacao" => FILTER_VALIDATE_INT,
        "paginas" => FILTER_VALIDATE_INT,
        "sinopse" => FILTER_SANITIZE_STRING,
        "aboutAutor" => FILTER_SANITIZE_STRING
    ];
    function tirarArray($array){
        if(is_array($array)){
            return true;
        }
    }
    $dados_rc = filter_input_array(INPUT_POST,$arrayValidate);
    $dados_st = array_map("strip_tags",$dados_rc);
    $dados = array_map("trim",$dados_st);
    $dados_tags = filter_input_array(INPUT_POST,FILTER_DEFAULT);
    
    if(in_array("",$dados)){
        $erro = true;
        echo "<meta http-equiv='refresh' content='0 URL=painel.php'>"; 
        $_SESSION['msg'] = "Sem espaços brancos =(";
    }else if($_FILES['cover']['error']==4){
        $erro = true;
        echo "<meta http-equiv='refresh' content='0 URL=painel.php'>"; 
        $_SESSION['msg'] = "Não esqueça de mandar a cape =D";
    }else if(!is_numeric($dados['anoPublicacao']) || !is_numeric($dados['paginas'])){
        $erro = true;
        echo "<meta http-equiv='refresh' content='0 URL=painel.php'>"; 
        $_SESSION['msg'] = "Apenas numeros em datas e páginas =D";
    } 

    if(!$erro){
    $nomecover = "cover";
    $exten = strtolower(substr($_FILES['cover']['name'],-4));
    $novolocal = "../img/capas/";
    
        if(file_exists("../img/capas/$nomecover$exten")){
            $i = 1;
            while(file_exists("../img/capas/$nomecover"."[".$i."]".$exten)){
                $i++;
            }
            $nomecover = $nomecover."[".$i."]".$exten;
            move_uploaded_file($_FILES['cover']['tmp_name'],$novolocal.$nomecover);   
        }else{
            $nomecover = $nomecover.$exten;
            move_uploaded_file($_FILES['cover']['tmp_name'],$novolocal.$nomecover);   
        }
    move_uploaded_file($_FILES['cover']['tmp_name'],$novolocal.$nomecover);
    $nivel = "Disponivel";
    $sqlCadastro = "INSERT INTO LIVROS (idUsuarios,idGeneros,caminhoCover,titulo,tituloOriginal,editora,autor,anoPublicacao,paginas,sinopse,aboutAutor,visitas,status) VALUES (
    '".$_SESSION['idUsuarios']."',
    '".$dados['generos']."',
    '$nomecover',
    '".$dados['titulo']."',
    '".$dados['tituloOriginal']."',
    '".$dados['editora']."',
    '".$dados['autor']."',
    '".$dados['anoPublicacao']."',
    '".$dados['paginas']."',
    '".$dados['sinopse']."',
    '".$dados['aboutAutor']."',
    '0',
    '$nivel'
    )";
    //echo $sqlCadastro;
    $cadastrarFoi = mysqli_query($link,$sqlCadastro);
        if($cadastrarFoi){
            $idLivros = mysqli_insert_id($link);
            foreach($dados_tags['tags'] as $i){
                $sqlrr = "INSERT INTO LIVROS_TAGS (idLivros,idTags) values (
                $idLivros,
                $i
                )";
                $result = mysqli_query($link,$sqlrr);
            }
            if($result){
                echo "<meta http-equiv='refresh' content='0 URL=painel.php'>"; 
                $_SESSION['msg'] = "Novo livro em nova estante de Ebooks =D!";
            }
        }else{
            $_SESSION['msg'] = "Alguma coisa aconteceu de errado, nos desculpe =("; 
        }
    }   
}else{
    echo "<meta http-equiv='refresh' content='0 URL=../'>"; 
    $_SESSION['msg'] = "Página não encontrada!";
}
?>