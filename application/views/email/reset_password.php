<p>
Dear <?php echo $user->username ?>,
</p>
<p>
  Someone (or you) has requested to reset the password of your <?php echo Kohana::$config->load('appconfig.site.name').' '.$role ?> account.
</p>
<p>
  You can change the password for your account by visiting the page at: 
  <a href="<?php echo URL::site('account/reset_password?token='.$user->reset_token.'&email='.urlencode($user->email), TRUE) ?>"><?php echo $user->reset_token ?></a>
</p>
<p>
  If the above link is not clickable, please visit <a href="<?php echo URL::site('account/reset_password', TRUE) ?>">the following page</a>,
  and copy/paste the following Reset Token: <?php echo $user->reset_token ?>
</p>
<p>
Regards,<br /><br />
<strong>The  <?php echo Kohana::$config->load('appconfig.site.name') ?> team</strong>
</p>