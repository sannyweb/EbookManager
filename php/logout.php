<?php 
    if(isset($_GET['sair'])){
        unset($_SESSION['username']);
        unset($_SESSION['idUsuarios']);
        unset($_SESSION['email']);
        unset($_SESSION['tipo']);
    }
?>