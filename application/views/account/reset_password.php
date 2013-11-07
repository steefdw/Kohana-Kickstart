<h2><?php echo __('Reset - step 2'); ?></h2>

<?php if ($errors) echo View::factory('errors/formerrors')->bind('errors', $errors)->render() ?>
<?php
if ($user)
{
  if ($user->loaded())
  {
    echo Form::open('', array('class' => 'form-horizontal')); ?>
    <fieldset>
      <h5><?php echo __('Enter your new password'); ?></h5>
      <div class="control-group">
        <?php echo Form::label('password', __('New Password')) ?>
        <div class="controls">
          <?php echo Form::password('password', false) ?>
        </div>                                                                                                                               
      </div>
      <div class="control-group">
        <?php echo Form::label('password_confirm', __('Confirm password')) ?>
        <div class="controls">
          <?php echo Form::password('password_confirm', false) ?>
        </div>    
      </div>      
    </fieldset>
    <?php echo Form::button(null, __('Set new password'), array('type' => 'submit','class' => 'btn btn-primary')); ?>
    <?php 
      echo Form::hidden('username', $user->username);
      echo Form::hidden('token', $token);
      echo Form::hidden('email', $email);
      echo Form::close();
      ?>
  <?php
  }
  else
  { ?>
    Link inactive
  <?php
  }
}
else
{
    echo Form::open('', array('method' => 'get','class' => 'form-horizontal'));
    ?>
    <fieldset>
      <h5><?php echo __('Enter email and token'); ?></h5>
      <div class="control-group">
        <?php echo Form::label('email', __('Account email address')) ?>
        <div class="controls">
          <?php echo Form::input('email', $email, array('class' => 'text')) ?>
        </div>                                                                                                                                   
      </div>
      <div class="control-group">
        <?php echo Form::label('token', __('Reset Token')) ?>
        <div class="controls">
          <?php echo Form::input('token', null, array('class' => 'text')) ?>
        </div>      
      </div>     
    </fieldset>
    <?php echo Form::button(null, __('Reset password'), array('type' => 'submit','class' => 'btn btn-primary')); ?>
    <?php echo Form::close();
}
?>