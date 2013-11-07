<h2><?php echo __('Dashboard'); ?></h2>

<div class="row">
<div class="span6">
  <fieldset class="form-horizontal">
    <legend><?php echo __('Your account'); ?></legend>
    <div class="control-group">
      <?php echo Form::label('email', __('Email')) ?>
      <div class="content">
        <?php echo $user->email ?>
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
        <?php echo substr($user->password, 0, 20).'...'; ?>
      </div>
    </div>
  </fieldset>

  <?php echo HTML::anchor('account/',     __('Show account'), array('class' => 'btn btn-primary')); ?>
  <?php echo HTML::anchor('account/edit', __('Edit account'), array('class' => 'btn btn-primary')); ?>
</div>

<div class="span6">
  <fieldset class="form-horizontal">
    <legend><?php echo __('Your profile'); ?></legend>
    <div class="control-group">
      <?php echo Form::label('id', __('Profile id')) ?>
      <div class="content">
        <?php echo $user->profile->id ?>
      </div>
    </div>
    <div class="control-group">
      <?php echo Form::label('created', __('Profile created at')) ?>
      <div class="content">
        <?php echo $user->profile->created_at_datetime ?>
      </div>
    </div>
    <div class="control-group">
      <?php echo Form::label('updated', __('Profile updated at')) ?>
      <div class="content">
        <?php echo $user->profile->updated_at_datetime ?>
      </div>
    </div>
    <div class="control-group">
      <?php echo Form::label('info', __('Info')) ?>
      <div class="content">
        <?php echo $user->profile->info ?>
      </div>
    </div>
    <div class="control-group">
      <?php echo Form::label('enum_test', __('Enum Select')) ?>
      <div class="content">
        <?php echo $user->profile->enum_test ?>
      </div>
    </div>
    <div class="control-group">
      <?php echo Form::label('textarea_test', __('Textarea')) ?>
      <div class="content">
        <?php echo nl2br($user->profile->textarea_test) ?>
      </div>
    </div>
  </fieldset>

  <?php echo HTML::anchor($current_role.'/profile/',     __('Show profile'), array('class' => 'btn btn-primary')); ?>
  <?php echo HTML::anchor($current_role.'/profile/edit', __('Edit profile'), array('class' => 'btn btn-primary')); ?>
</div>
</div>