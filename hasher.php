<?php

    //make a sample hash text for a string 
    $string = "";
    $hash = password_hash($string, PASSWORD_DEFAULT);

    echo $hash;
// $2y$10$.VYJUt4jsL2hYFkNEodKK.n1sDLsJTFSv7oDQcL3Um0.o55Hxl7lm
