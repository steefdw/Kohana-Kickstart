<h2><?php echo __('Reset password'); ?></h2>

<?php if ($errors) echo View::factory('errors/formerrors')->bind('errors', $errors)->render() ?>

<?php echo Form::open('', array('class' => 'form-horizontal')); ?>
<fieldset>
  <h5><?php echo __('Forgot password or username'); ?></h5>
  <div class="control-group">
    <?php echo __('Please send me a link to reset my password.'); ?>                                                                                                                         
  </div>
  <div class="control-group">
    <?php echo Form::label('email', __('Your email address')) ?>
    <div class="controls">
      <?php echo Form::input('email', $post['email']) ?>
    </div>                                                                                                                            
  </div>       
</fieldset>
<?php echo Form::button(null, __('Reset password'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
<?php echo Form::close(); ?>
