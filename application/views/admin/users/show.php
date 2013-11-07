<h2><?php echo __('Account').': '.$user->username ?></h2>

<fieldset class="form-horizontal">
  <legend><?php echo __('Show account'); ?></legend>
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
      <a href="<?php echo Url::base(TRUE).$current_role ?>/users/role/<?php echo $user->get_role()->id ?>"><?php echo $user->get_role()->name ?></a>
    </div> 
  </div> 
  <div class="control-group">
    <?php echo Form::label('password', __('Password')) ?> 
    <div class="content">
      <?php echo $user->password ?>
    </div>  
  </div> 
  <div class="control-group">
    <?php echo Form::label('created', __('Account created at')) ?> 
    <div class="content">
      <?php echo $user->created_at_datetime ?>
    </div>  
  </div> 
  <div class="control-group">
    <?php echo Form::label('updated', __('Account updated at')) ?> 
    <div class="content">
      <?php echo $user->updated_at_datetime ?>
    </div>  
  </div>        
</fieldset>
  <a href="<?php echo Url::base(TRUE).$current_role ?>/users/edit/<?php echo $user->id ?>" class="btn btn-primary"><?php echo __('Edit account') ?></a>
  <a href="<?php echo Url::base(TRUE).$current_role ?>/profiles/show/<?php echo $user->id ?>" class="btn btn-info"><?php echo __('Show profile') ?></a>
  <a href="<?php echo Url::base(TRUE).$current_role ?>/users" class="btn cancel"><?php echo __('Back to users') ?></a> 