<h2><?php echo __('Login'); ?></h2>

<div class="row">
<div class="span6">
<?php if ($errors) echo View::factory('errors/formerrors')->bind('errors', $errors)->render() ?>

<?php echo Form::open('', array('class' => 'form-horizontal')); ?>
<fieldset>
  <div class="control-group">
    <?php echo Form::label('username', __('Username or email')) ?>
    <div class="controls">
      <?php echo Form::input('username', $post['username']) ?>
    </div>                                                                                                                               
  </div>
  <div class="control-group">
    <?php echo Form::label('password', __('Password')) ?>
    <div class="controls">
      <?php echo Form::password('password') ?>
    </div>
  </div> 
  <div class="control-group">
    <?php echo Form::label('remember', __('Remember me')) ?>
    <div class="controls">
      <?php echo Form::checkbox('remember', NULL, ! empty($post['remember'])) ?>
    </div>
  </div>      
</fieldset>
<?php echo Form::button(null, __('Login'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
<?php echo Form::close(); ?>

<p><?php echo HTML::anchor('account/forgot',  __('Lost my log in information')); ?></p>
</div>

<div class="span6">
<h4><?php echo __("Don't have an account yet?"); ?></h4>

Lorem ipsum dolor sit amet consectetuer turpis Nulla Nam Donec orci. Nulla dolor enim ridiculus malesuada quis mattis Phasellus diam turpis Vivamus. 
Sed metus nibh Sed congue interdum eget Cras non tortor elit. Neque elit nunc Quisque et dapibus Pellentesque vitae Aenean Curabitur eros. 
<br><br>
<?php echo HTML::anchor('account/create/',     __('Create account'), array('class' => 'btn btn-primary add')); ?>
</div>
</div>