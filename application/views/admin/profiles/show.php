<h2><?php echo __('Profile').': '.$profile->user->username ?></h2>

<fieldset class="form-horizontal">
  <legend><?php echo __('Show profile'); ?></legend>
  <div class="control-group">
    <?php echo Form::label('id', __('Profile id')) ?>
    <div class="content">
      <?php echo $profile->id ?>
    </div>                                                                                                                               
  </div>
  <div class="control-group">
    <?php echo Form::label('created', __('Profile created at')) ?> 
    <div class="content">
      <?php echo $profile->created_at_datetime ?>
    </div>  
  </div> 
  <div class="control-group">
    <?php echo Form::label('updated', __('Profile updated at')) ?> 
    <div class="content">                                          
      <?php echo $profile->updated_at_datetime ?>
    </div>  
  </div>  
  <div class="control-group">
    <?php echo Form::label('info', __('Info')) ?>
    <div class="content">
      <?php echo $profile->info ?>
    </div>
  </div>  
  <div class="control-group">
    <?php echo Form::label('enum_test', __('Enum Select')) ?>
    <div class="content">
      <?php echo $profile->enum_test ?>
    </div>
  </div>
  <div class="control-group">
    <?php echo Form::label('textarea_test', __('Textarea')) ?>
    <div class="content">
      <?php echo nl2br($profile->textarea_test) ?>
    </div>  
  </div>
</fieldset>
  <a href="<?php echo Url::base(TRUE).$current_role ?>/profiles/edit/<?php echo $profile->id ?>" class="btn btn-primary"><?php echo __('Edit profile') ?></a>
  <a href="<?php echo Url::base(TRUE).$current_role ?>/users/show/<?php echo $profile->user->id ?>" class="btn btn-info"><?php echo __('Show account') ?></a>
  <a href="<?php echo Url::base(TRUE).$current_role ?>/profiles" class="btn"><?php echo __('Back to profiles') ?></a> 