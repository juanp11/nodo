<?php
    function isNull($nombrecompleto,$direccion)
    {
        if (strlen(trim($nombrecompleto)) < 1 || strlen(trim($direccion)) < 1) {
            return true;
        }else {
            return false;
        }
    }

    /*function isNullDepartamento($departamento_id){
        if ($departamento_id == 0) {
            return true;
        }else {
            return false;
        }
    }*/

    function resultBlock($errors){
        if (count($errors) > 0) {
            echo "<div class='mensaje'><ul>";
            foreach ( $errors as $error){
                echo "<li>".$error."</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
    }
?>