<h2>Users with role: <?php echo $role->name ?></h2>
<?php if (count($users) > 0): ?>
    <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th class="actions">edit</th>
            <th>username</th>
            <th>role</th>
            <th>created_at</th>
            <th>updated_at</th>
            <th>email</th>
            <th>logins</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
                <tr>
                  <td>
                    <div class="btn-group">
                      <a href="<?php echo Url::base(TRUE).$current_role ?>/users/show/<?php echo $user->id ?>" class="btn btn-primary"><i class="icon-user icon-white"></i></a>
                      <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="<?php echo Url::base(TRUE).$current_role ?>/users/show/<?php echo $user->id ?>"><i class="icon-info-sign"></i> Show user</a></li>
                        <li><a href="<?php echo Url::base(TRUE).$current_role ?>/users/edit/<?php echo $user->id ?>"><i class="icon-pencil"></i> Edit user</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo Url::base(TRUE).$current_role ?>/profiles/show/<?php echo $user->profile->id ?>"><i class="icon-info-sign"></i> Show profile</a></li>
                        <li><a href="<?php echo Url::base(TRUE).$current_role ?>/profiles/edit/<?php echo $user->profile->id ?>"><i class="icon-pencil"></i> Edit profile</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="icon-trash"></i> Delete</a></li>
                        <li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>            
                      </ul>
                    </div>
                  </td>
                  <td>
                    <a href="<?php echo Url::base(TRUE).$current_role ?>/users/show/<?php echo $user->id ?>"><?php echo $user->username ?></a>                    
                  </td>
                  <td><?php echo $role->name ?></td>
                  <td><?php echo $user->created_at_datetime ?></td>
                  <td><?php echo $user->updated_at_datetime ?></td>
                  <td><?php echo $user->email ?></td>
                  <td><?php echo $user->logins    ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <?php echo $page_links ?>
<?php else: ?>
    <p class="nothing">There are no users with this role yet.</p>
<?php endif ?>
<?php echo HTML::anchor($current_role.'/users', __('Back to all users'), array('class' => 'btn back')); ?> 