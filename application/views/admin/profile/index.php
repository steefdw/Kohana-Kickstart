<h2><?php echo __('Your profile') ?></h2>

<fieldset class="form-horizontal">
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
<a href="<?php echo Url::base(TRUE).$current_role ?>/profile/edit/<?php echo $profile->id ?>" class="btn btn-primary"><?php echo __('Edit your profile') ?></a> 