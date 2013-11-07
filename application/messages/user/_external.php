<?php
/*
* Validation messages for the password:
* $errors = $e->errors('user');
*/
return array(
    "password" => array(
        "not_empty" => "You must provide a :field.",
        "pwdneusr"  => "Password can't be the same as the username.",
        "min_length" => "The :field must be at least :param2 characters long.",
        "max_length" => "The :field must be less than :param2 characters long.",        
    ),
    "password_confirm" => array(
       "matches"      => "The :field must be the same as password.",
    ),    
);
