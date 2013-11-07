<h2>Profiles</h2>
<?php if (count($profiles) > 0): ?>
    <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th class="actions">edit</th>
            <th>username</th>
            <th>created_at</th>
            <th>updated_at</th>
            <th>info</th>
            <th>enum_test</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach($profiles as $profile): ?>
                <tr>
                  <td>
                    <div class="btn-group">
                      <a href="<?php echo Url::base(TRUE).$current_role ?>/profiles/show/<?php echo $profile->id ?>" class="btn btn-primary"><i class="icon-user icon-white"></i></a>
                      <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="<?php echo Url::base(TRUE).$current_role ?>/users/show/<?php echo $profile->user->id ?>"><i class="icon-info-sign"></i> Show user</a></li>
                        <li><a href="<?php echo Url::base(TRUE).$current_role ?>/users/edit/<?php echo $profile->user->id ?>"><i class="icon-pencil"></i> Edit user</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo Url::base(TRUE).$current_role ?>/profiles/show/<?php echo $profile->id ?>"><i class="icon-info-sign"></i> Show profile</a></li>
                        <li><a href="<?php echo Url::base(TRUE).$current_role ?>/profiles/edit/<?php echo $profile->id ?>"><i class="icon-pencil"></i> Edit profile</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="icon-trash"></i> Delete</a></li>
                        <li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>            
                      </ul>
                    </div>
                  </td>
                  <td>
                    <a href="<?php echo Url::base(TRUE).$current_role ?>/users/show/<?php echo $profile->id ?>"><?php echo $profile->user->username ?></a>                    
                  </td>
                  <td><?php echo $profile->created_at_datetime ?></td>
                  <td><?php echo $profile->updated_at_datetime ?></td>
                  <td><?php echo $profile->info ?></td>
                  <td><?php echo $profile->enum_test ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <?php echo $page_links ?>
<?php else: ?>
    <p class="nothing">There are no profiles yet.</p>
<?php endif ?>