<?php
//функция генерации соли

/*
   взяли длину 8 символов, сгенерировали символы из ASCII
   и объединили в строку.
*/
function Salt()
{
    $salt = '';
    $saltLength = 8;
    for ($i = 0; $i < $saltLength; $i++) {
        $salt .= chr(mt_rand(33,126));
    }
    return $salt;
}