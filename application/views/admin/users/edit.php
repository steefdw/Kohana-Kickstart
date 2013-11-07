<h2><?php echo __('Account').': '.$user->username ?></h2>

<?php if (isset($errors) AND $errors) echo View::factory('errors/formerrors')->bind('errors', $errors)->render() ?>

<?php echo Form::open(null, array('id' => 'edit', 'class' => 'form-horizontal', 'autocomplete' => 'off',)); ?>
  <fieldset>
    <legend><?php echo __('Edit account'); ?></legend>
    <div class="control-group">
      <?php echo Form::label('id', __('id')) ?>
      <div class="controls">
        <?php echo Form::input('id', $user->id, array('class' => 'span1 disabled')) ?>
      </div>                                                                                                                               
    </div>
    <div class="control-group">
      <?php echo Form::label('email', __('Email')) ?>
      <div class="controls">
        <?php echo Form::input('email', $user->email) ?>
      </div>
    </div> 
    <div class="control-group">
      <?php echo Form::label('username', __('Username')) ?>
      <div class="controls">
        <?php echo Form::input('username', $user->username, array('MAXLENGTH' => 12, 'autocomplete' => 'off')) ?>
      </div>
    </div> 
    <div class="control-group">
      <?php echo Form::label('password', __('Password')) ?>
      <div class="controls">
        <?php echo Form::password('password', false, array('autocomplete' => 'off')) ?>
      </div>
    </div>
    <div class="control-group">
      <?php echo Form::label('password_confirm', __('Confirm password')) ?>
      <div class="controls">
        <?php echo Form::password('password_confirm', false) ?>
      </div>
    </div>   
  </fieldset>
  <fieldset>
    <legend>Roles</legend>     
    <div class="control-group">      
      <label>User type</label>      
      <div class="controls form-inline">
  <?php 
    foreach($all_roles as $role): 
    if ($role->name != 'login'): ?>
        <?php echo Form::radio('roles[]', $role->id, ((isset($user_roles[$role->id])) ? true : false) ) ?>
        <?php echo Form::label('roles_'.$role->id, __($role->name)) ?><br>    
  <?php
    endif;
    endforeach; 
  ?>
      </div>       
    </div>
  <?php 
    foreach($all_roles as $role): 
    if ($role->name == 'login'):
  ?>
    <div class="control-group">
      <?php echo Form::label('roles_'.$role->id, 'Can login') ?>
      <div class="controls"> 
        <?php echo Form::checkbox('roles[]', $role->id, ((isset($user_roles[$role->id])) ? true : false) ) ?>
      </div>
    </div> 
  <?php 
    endif;
    endforeach; 
  ?>                                                                                          
  </fieldset>
  <?php echo Form::button('save', __('Save account'), array('type' => 'submit','class' => 'btn btn-primary save')); ?>
  <?php echo HTML::anchor($current_role.'/users/', __('Cancel'), array('class' => 'btn cancel')); ?> 
<?php echo Form::close(); ?>