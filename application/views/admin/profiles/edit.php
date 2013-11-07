<h2><?php echo __('Profile').': '.$profile->user->username ?></h2>

<?php if (isset($errors) AND $errors) echo View::factory('errors/formerrors')->bind('errors', $errors)->render() ?>

<?php echo Form::open(null, array('id' => 'edit')); ?>
  <fieldset class="form-horizontal">
    <legend><?php echo __('Edit profile'); ?></legend>
    <div class="control-group">
      <?php echo Form::label('id', __('Profile id')) ?>
      <div class="controls">
        <?php echo Form::input('id', $profile->id, array('class' => 'span1 disabled')) ?>
      </div>                                                                                                                               
    </div>
    <div class="control-group">
      <?php echo Form::label('created_at', __('Profile created at')) ?> 
      <div class="controls">
        <?php echo Form::input('created_at', $profile->created_at, array('class' => 'disabled')) ?>
      </div>  
    </div> 
    <div class="control-group">
      <?php echo Form::label('updated_at', __('Profile updated at')) ?> 
      <div class="controls">                                          
        <?php echo Form::input('updated_at', $profile->updated_at, array('class' => 'disabled')) ?>
      </div>  
    </div>  
    <div class="control-group">
      <?php echo Form::label('enum_test', __('Enum Select')) ?>
      <div class="controls">
        <?php echo Form::select('enum_test', $profile->enum_field_values('enum_test', 'Please select...'),$profile->enum_test); ?>
      </div>
    </div>      
    <div class="control-group">
      <?php echo Form::label('info', __('Info')) ?>
      <div class="controls">
        <?php echo Form::input('info', $profile->info, array('class' => 'span6') ) ?>
      </div>
    </div>  
    <div class="control-group">
      <?php echo Form::label('textarea_test', __('Textarea')) ?>
      <div class="controls">
        <?php echo Form::textarea('textarea_test', $profile->textarea_test, array('class' => 'span6') ) ?>
      </div>  
    </div>
  </fieldset>
  <?php echo Form::button('save', __('Save profile'), array('type' => 'submit','class' => 'btn btn-primary save')); ?>
  <?php echo HTML::anchor($current_role.'/profile/', __('Cancel'), array('class' => 'btn cancel')); ?>
<?php echo Form::close(); ?>