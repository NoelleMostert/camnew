<?php
/*
#DEF: htmlentities - convert all applicable characters to HTML entities
They are real handy for protecting against malicious or erroneous 
user input that could lead to unexpected errors.
*/
function escape($string){
    return (htmlentities($string, ENT_QUOTES, 'UTF-8'));
}
?>