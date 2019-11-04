<?php 
function antiSql($texto){
    $check[] = chr(34); //  "
    $check[] = chr(39); //  '
    $check[] = chr(92); //  /
    $check[] = chr(96); //  `
    $check[] = "drop table";    
    $check[] = "drop";    
    $check[] = "drop database";    
    $check[] = "delete";    
    $check[] = "select";    
    $check[] = "destroy";    
    $check[] = "remove";    
    $check[] = "add update";    
    $check[] = "alter table";    
    $check[] = "alter";    
    $check[] = "database";    
    $check[] = "union";    
    $check[] = "1=1";    
    $check[] = "insert";    
    $check[] = "or 1";    
    $check[] = "exec";    
    $check[] = "INFORMATION_SCHEMA";    
    $check[] = "into";
    $check[] = "like";      
    $check[] = "values";     
    $check[] = "Livros";    
    $check[] = "Usuarios";    
    $check[] = "Managers";    
    $check[] = "Livros_Tags";    
    $check[] = "Tags";
    $check[] = "Generos";    
    $check[] = "Comentarios";    
    $check[] = "Resenhas";
    
    foreach($check as $cont => $word){
        if(stristr(strtolower($texto),$check[$cont])){
            return true;
        }
    }
}
?>