<?php

    //make a sample hash text for a string 
    $string = "password";
    $hash = password_hash($string, PASSWORD_DEFAULT);

    echo $hash;

$2y$10$H2V4VZ3DgUK.n1UeWyCVYuhp9NE46wXOZYmPR.YnwMfajSg5N6XE.


?>