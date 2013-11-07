<?php defined('SYSPATH') or die('No direct script access.'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <meta name="description" content="A short phrase that describes the content of the page" />
    <meta name="keywords" content="list of words, separated by, comma" />
    <meta name="abstract" content="Short description of page" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo URL::base(); ?>favicon.png">
    <title><?php echo $title ?></title>

    <!-- HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo URL::base(); // http://html5shim.googlecode.com ?>/js/html5shim.js"></script>
    <![endif]-->
    
    <?php foreach ($header->css as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>
    <?php foreach ($header->js as $file) echo HTML::script($file), PHP_EOL ?>
</head>
<body>

  <?php echo $header ?>
  
  <div class="container">  

    <div id="content">
      <?php
      echo Message::output();
      echo $content;
      ?>
    </div>

    <?php echo $footer ?>
  </div>
</body>
</html>