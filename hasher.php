<?php

    //make a sample hash text for a string 
    $string = "mnmch@2025";
    $hash = password_hash($string, PASSWORD_DEFAULT);

    echo $hash;
// $2y$10$zNPr3SU/xRrFbUv5HkGgcOEloVMkW9AO5ygDqwhuPPxVsLHfOoQ.K
