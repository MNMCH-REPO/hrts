<?php

    //make a sample hash text for a string 
    $string = "password";
    $hash = password_hash($string, PASSWORD_DEFAULT);

    echo $hash;




?>