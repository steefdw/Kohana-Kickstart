<?php
/*
* Validation messages for the user model
*/
return array(
    "username" => array(
        "not_empty"  => "You must provide a :field.",
        "min_length" => "The :field must be at least :param2 characters long.",
        "max_length" => "The :field must be less than :param2 characters long.",
        "username_available" => "This :field is not available.",
        "unique"     => "This :field is not available.",
    ),
    "email"         => "Email must be a valid email address",
    "email_domain"  => "Email must contain a valid email domain",
    "email.unique"  => "This :field is not available.",
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
