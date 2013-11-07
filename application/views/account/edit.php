<h2><?php echo __('Edit your account'); ?></h2>

<?php if (isset($errors) AND $errors) echo View::factory('errors/formerrors')->bind('errors', $errors)->render() ?>

<?php echo Form::open(null, array('id' => 'edit', 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
  <fieldset>
    <div class="control-group">
      <?php echo Form::label('id', __('id')) ?>
      <div class="controls">
        <?php echo Form::input('id', $user->id, array('class' => 'small disabled')) ?>
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
  <?php echo Form::button('save', __('Save account'), array('type' => 'submit','class' => 'btn btn-primary save')); ?>
  <?php echo HTML::anchor($current_role.'/', __('Cancel'), array('class' => 'btn cancel')); ?> 
<?php echo Form::close(); ?>