<?php
session_start();
include "conexao.php";
include "antiSql.php";
$btnCadastro = filter_input(INPUT_POST,"btnCadastro",FILTER_SANITIZE_STRING);
$erro = false;
if($btnCadastro){
    $dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $dados_st = array_map("strip_tags",$dados_rc);
    $dados = array_map("trim",$dados_st);
    
    if(in_array("",$dados)){
        $erro = true;
        $_SESSION['msg'] = "<p class='error'>Sem campos vazios!</p>";
        echo "<meta http-equiv='refresh' content='0 URL=../'>";
    }else if(stristr($dados['password'],"'") || stristr($dados['email'],"'") || stristr($dados['username'],"'")){
        $erro = true;
        $_SESSION['msg'] = "<p class='error'>Caracteres não permitidos!</p>";
        echo "<meta http-equiv='refresh' content='0 URL=../'>";
    }else if(strlen($dados['password'])<8){
        $erro = true;
        $_SESSION['msg'] =  "<p class='error'>Senha maior do que 8 caracteres!</p>";
        echo "<meta http-equiv='refresh' content='0 URL=../'>";
    }else if(!filter_var($dados['email'],FILTER_VALIDATE_EMAIL)){
        $erro = true;
        $_SESSION['msg'] =  "<p class='error'>Preencha um email correto!</p>";
        echo "<meta http-equiv='refresh' content='0 URL=../'>";
    }else if(stristr($dados['password'],";") || stristr($dados['email'],";") || stristr($dados['username'],";")){
        $erro = true;
        $_SESSION['msg'] =  "<p class='error'>Não tente colocar ; amigo!</p>";
        echo "<meta http-equiv='refresh' content='0 URL=../'>";
    }else if(antiSql($dados['username']) || antiSql($dados['email']) || antiSql($dados['password'])){
        $erro = true;
        $_SESSION['msg'] = "<p class='error'>No way to your bad actions!</p>";
        echo "<meta http-equiv='refresh' content='0 URL=../'>";
    }

    if(!$erro){
    $sql1 = "select email,username,senha,tipo,idUsuarios from Usuarios where email='".$dados['email']."' and username='".$dados['username']."' limit 1";  
    $resultadoLogin = mysqli_query($link,$sql1);
    //var_dump($dados);
    //var_dump($resultadoLogin);
        if(mysqli_num_rows($resultadoLogin)==1){
            $column = mysqli_fetch_assoc($resultadoLogin);
            if(password_verify($dados['password'],$column['senha'])){
                $_SESSION['idUsuarios'] = $column['idUsuarios'];
                $_SESSION['username'] = $column['username'];
                $_SESSION['email'] = $column['email'];
                $_SESSION['tipo'] = $column['tipo'];
                setcookie($_SESSION['idUsuarios'],time()*600);
                setcookie($_SESSION['username'],time()*600);
                setcookie($_SESSION['tipo'],time()*600);
                setcookie($_SESSION['email'],time()*600);
                echo "<meta http-equiv='refresh' content='0 URL=../'>";
            }else{
                echo "<meta http-equiv='refresh' content='0 URL=../'>";
                $_SESSION['msg'] = "<p class='error'>Email e/ou senha inválidos!</p>";
            }
        }else{
            $dados['password'] = password_hash($dados['password'],PASSWORD_DEFAULT);
            $sqlCadastrar = "INSERT INTO Usuarios (username,email,senha,tipo) VALUES (
            '".$dados['username']."',
            '".$dados['email']."',
            '".$dados['password']."',
            'USUARIO'
            )";
            $cadastrarFoi = mysqli_query($link,$sqlCadastrar);
            if($cadastrarFoi){
                $_SESSION['msg'] = "<p class='success'>Cadastrado com sucesso, você pode logar</p>";
                header("Location: ../");
            }else{
                $_SESSION['msg'] = "<p class='alert'>Alguma coisa aconteceu de errado, nos desculpe</p>"; 
            }
        }
    }
    //var_dump($dados);
}else{
    echo "<meta http-equiv='refresh' content='0 ../'>";
    $_SESSION['msg'] = "Página não encontrada";
} 
?>