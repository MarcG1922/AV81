<?php
function miAutoload($claseDesconocida){
    $file = "clases/{$claseDesconocida}.php";
    if(file_exists($file)){
        require_once $file;
    }
}
spl_autoload_register("miAutoload");
?>