<h2><?php echo __('Create an account'); ?></h2>

<?php if ($errors) echo View::factory('errors/formerrors')->bind('errors', $errors)->render() ?>

<?php echo Form::open(NULL, array('id' => 'create', 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
<fieldset>
  <div class="control-group">
    <?php echo Form::label('email', __('Email')) ?>
    <div class="controls">
      <?php echo Form::input('email', $post['email']) ?>
    </div>                                                                                                                              
  </div>
  <div class="control-group">
    <?php echo Form::label('username', __('Username')) ?>
    <div class="controls">
      <?php echo Form::input('username', $post['username'], array('MAXLENGTH' => 12)) ?>
    </div>
  </div> 
  <div class="control-group">
    <?php echo Form::label('password', __('Password')) ?>
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
<?php echo Form::button('create', __('Create account'), array('type' => 'submit','class' => 'add btn btn-primary')); ?> 
<?php echo Form::close(); ?>