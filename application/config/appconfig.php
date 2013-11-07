<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
  'encrypt_key'      => 'XaMAWrexuzaspE&HeKEpesteceXENUc=amAQe?aNa--Bruce3TeruYaxu$e$t&sw', 
  'cookie_salt'      => 'kahAphuwR52rUSuKuqEqa#aw8usp*C*acrustEg+-uveGa_weT_sp$sak_p+aq&w',
  'cookie_lifetime'  => DATE::YEAR,
  'session_lifetime' => 0,
  'site' => array(
      'name'  => 'Ko33 Kickstart',
      'email' => 'your@email.com',
  ),
  'language' => array(
      'en',
      'fr',
      'nl',
  ),
  'date_format' => array(
      'minutes'  => 'i',
      'hour'     => 'H',
      'datetime' => 'd/m/Y H:i',
      'date'     => 'd/m/Y',
  ),
  'account'  => array(
      'create' => array(
          'username' => array(
              'min_length' => 4,
              'max_length' => 99,
              'format'     => 'alpha_numeric', // alpha_dash, alpha
          ),
        'password' => array(
            'min_length'  => 6,
        )
      ),
  ),
);
