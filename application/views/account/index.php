<h2><?php echo __('Your account'); ?></h2>

<fieldset class="form-horizontal">
  <div class="control-group">
    <?php echo Form::label('email', __('Email')) ?>
    <div class="content">
      <?php echo $user->email ?>
    </div>                                                                                                                               
  </div>
  <div class="control-group">
    <?php echo Form::label('username', __('Username')) ?>
    <div class="content">
      <?php echo $user->username ?>
    </div>                                                                                                                               
  </div>
  <div class="control-group">
    <?php echo Form::label('roles', __('Roles')) ?>
    <div class="content">
      <?php echo implode(', ',$user_roles) ?>
    </div>                                                                                                                               
  </div>    
  <div class="control-group">
    <?php echo Form::label('usertype', __('User Type')) ?>
    <div class="content">
      <?php echo $current_role ?>
    </div> 
  </div> 
  <div class="control-group">
    <?php echo Form::label('password', __('Password')) ?> 
    <div class="content">
      <?php echo $user->password ?>
    </div>  
  </div> 
  <div class="control-group">
    <?php echo Form::label('updated', __('Last update')) ?> 
    <div class="content">
      <?php echo $user->updated_at_datetime ?>
    </div>  
  </div>      
</fieldset>
<?php echo HTML::anchor('account/edit', __('Edit account'), array('class' => 'btn btn-primary edit')); ?>