<?php

    //make a sample hash text for a string 
    $string = "pass";
    $hash = password_hash($string, PASSWORD_DEFAULT);

    echo $hash;
// $2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.


?>