<?php

    //make a sample hash text for a string 
    $string = "mnmch@2025";
    $hash = password_hash($string, PASSWORD_DEFAULT);

    echo $hash;

//$2y$10$.VYJUt4jsL2hYFkNEodKK.n1sDLsJTFSv7oDQcL3Um0.o55Hxl7lm HASH for blank

//$2y$10$zNPr3SU/xRrFbUv5HkGgcOEloVMkW9AO5ygDqwhuPPxVsLHfOoQ.K   HASH FOR mnmch@2025
