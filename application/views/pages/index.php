
  <style type="text/css">
	#results.pass { background: #191; }
	#results.fail { background: #911; }
	#results { padding: 0.8em; color: #fff; font-size: 1.5em; }
	</style>


<h2><?php echo __('Welcome to ').($sitename = Kohana::$config->load('appconfig.site.name')); ?></h2>
<p class="lead">Your kickstarter for building Kohana 3.3 applications.</p>

<div class="row">
  <div class="span4">
    <h3>Getting started</h3>
    <a href="#kickstart" class="btn btn-info"><i class="icon-chevron-right icon-white"></i> See below</a>
  </div>
  <div class="span4">
    <h3>Documentation</h3>
    <a href="pages/docs" class="btn btn-info"><i class="icon-chevron-right icon-white"></i> Documentation</a>
  </div>
  <div class="span4">
    <h3>About</h3>
    <a href="pages/about" class="btn btn-info"><i class="icon-chevron-right icon-white"></i> Read more</a>
  </div>
</div>

<br>
<br>
<div id="kickstart">
<h2>Getting started <small>Let me help you with that</small></h2>

<div class="subnav">
  <ul class="nav nav-pills">
    <li class="active"><a href="#kickstart">Kickstart</a></li>
    <li class=""><a href="#setup">Appp setup</a></li>
    <li class=""><a href="#samdb">Sample database</a></li>
    <li class=""><a href="#build">Start building</a></li>
  </ul>
</div>

<p>
  On this page you can find the information you need to kickstart your own application with <?php echo $sitename ?>.
</p>

</div>

<div class="section" id="setup">
  <div class="section-header">
      <h3>Let's change the default settings:</h3>
  </div>

	<?php if (Kohana::$config->load('appconfig.encrypt_key') != 'XaMAWrexuzaspE&HeKEpesteceXENUc=amAQe?aNa--Bruce3TeruYaxu$e$t&sw'): ?>
    <div class="alert alert-success">✔ <span class="label label-success">encrypt_key</span> set in <code>APPPATH/config/appconfig.php</code></div>
	<?php else: $failed['encrypt_key'] = true ?>
    <div class="alert alert-error">
      Please set your own <span class="label label-important">encrypt_key</span> in <code>APPPATH/config/appconfig.php</code>
    </div>
	<?php endif ?>

	<?php if (Kohana::$config->load('appconfig.cookie_salt') != 'kahAphuwR52rUSuKuqEqa#aw8usp*C*acrustEg+-uveGa_weT_sp$sak_p+aq&w'): ?>
    <div class="alert alert-success">✔ <span class="label label-success">cookie_salt</span> set in <code>APPPATH/config/appconfig.php</code></div>
	<?php else: $failed['cookie_salt'] = true ?>
		<div class="alert alert-error">
      Please set your own <span class="label label-important">cookie_salt</span> in <code>APPPATH/config/appconfig.php</code>
    </div>
	<?php endif ?>

	<?php if (Kohana::$config->load('auth.hash_key') != 'z$DguKB%y0AkoRWP7m-^i9x53nGbdU6&NH!s2vc8eahZ#4Q*ECfTLJXjpt+YVwq@'): ?>
    <div class="alert alert-success">✔ <span class="label label-success">hash_key</span> set in <code>APPPATH/config/auth.php</code></div>
	<?php else: $failed['hash_key'] = true ?>
		<div class="alert alert-error">
      Please set your own <span class="label label-important">hash_key</span> in <code>APPPATH/config/auth.php</code>
    </div>
	<?php endif ?>

	<?php if (Kohana::$config->load('database.default.connection.database') != 'ko33_kickstart_default'): ?>
    <div class="alert alert-success">✔ <span class="label label-success">database</span> set in <code>APPPATH/config/database.php</code></div>
	<?php else: $failed['database'] = false ?>
		<div class="alert alert-error">
      Please set your own <span class="label label-important">database</span> in <code>APPPATH/config/database.php</code>
    </div>
	<?php endif ?>
	
	<?php if (Kohana::$config->load('appconfig.site.email') != 'your@email.com' AND Kohana::$config->load('appconfig.site.email') != ''): ?>
    <div class="alert alert-success">✔ Site <span class="label label-success">email</span> set in <code>APPPATH/config/appconfig.php</code></div>
	<?php else: $failed['email'] = false ?>
		<div class="alert alert-error">
      Please set your own <span class="label label-important">email</span> address in <code>APPPATH/config/appconfig.php</code>
    </div>
	<?php endif ?>
	
	<?php if (count(@$failed) > 0): ?>
		<p id="results" class="fail alert">✘ Please change these settings for security reasons.</p>
    <?php
      foreach($failed as $type => $suggest):
      if ($suggest === true):
    ?>
      Let me generate a random string for your <span class="label label-info"><?php echo $type ?></span> : <code><?php 

      $password = "";
      $length   = 64;
      $possible = "0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ!@#$%^&*-+_";
      $i        = 0;
      while ($i < $length AND $i < 200)
      {
          $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
          if ( !strstr($password, $char) OR strlen($possible)-3 < strlen($password) )
          {
              $password .= $char;
              $i++;
          }
      }

      echo $password;
  
       ?></code><br>
    <?php
      endif;
      endforeach;
    ?>
	<?php else: ?>
		<p id="results" class="pass alert">✔ All settings done.</p>
	<?php endif ?>
</div>


<div class="section" id="samdb">
  <div class="section-header">
      <h3>Let's create a sample database:</h3>
  </div>
  
  <div class="row">
    <div class="span12">

      <p>
        Before you can login to your new Kohana 3.3 application, you'll need a database with sample users.
        Click on the "Create sample database" button below and import it into your <?php echo $sitename ?> database <code><?php echo Kohana::$config->load('database.default.connection.database'); ?></code>.
      </p>

      <div class="alert">
      <?php if (count(@$failed) > 0): ?>
        NOTE: After you've changed the <code>auth.hash_key</code> in <code>APPPATH/config/auth.php</code>, you will have to come back here to create a new sample DB. Otherwise, logging in won't work.
      <?php else: ?>
        Note: Every time you change the <code>auth.hash_key</code>, the passwordhashes in the DB do not match anymore with passwords being hashed with the new hashkey. So you can't login with your old passwords anymore.
      <?php endif ?>
      </div>

      <div class="alert alert-success">
        But that's not a problem. Simply generate a new sample DB here after you've changed the <code>auth.hash_key</code>.
      </div>

      <p>
        <a href="../create_db.php?phash=<?php echo Auth::instance()->hash_password('12341234'); ?>" class="btn btn-primary">
          <i class="icon-ok-sign icon-white"></i>
          Create sample database
        </a>
      </p>

      <p>
        After succesfull import in the database, you can login as admin with username <code>admin</code> and password <code>12341234</code>.
        By the way: all generated sample users will have the password <code>12341234</code>.
      </p>

  		<div class="alert alert-error">
        Please don't upload the <code>create_db.php</code> file to production!!! Better be safe: after generating a working dev database, delete the file.
      </div>

    </div>
  </div>
</div>

<div class="section" id="build">
  <div class="section-header">
      <h3>Start building your own app:</h3>
  </div>

  <div class="row ">
    <div class="span6">
      <p><a href="pages/docs" class="btn btn-info"><i class="icon-chevron-right icon-white"></i> Go to documentation</a></p>
    </div>
    <div class="span6">
      <h4>Some pointers:</h4>
      <ul>
        <li>Please follow Kohana's <a href="http://kohanaframework.org/3.3/guide/kohana/conventions">Coding conventions</a></li>
        <li>Keep Kohana system and modules folders out of your application folder
        <li>Don't put any system, module or application files inside your webroot (for example <code>public_html</code>)
      </ul>
    </div>
</div>