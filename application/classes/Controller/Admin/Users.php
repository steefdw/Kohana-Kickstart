<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Users extends Controller_Admin_Admin {

  public function before()
  {
      parent::before();
      $this->template->title .= ' > Users > '.Request::current()->action();
  }

  
  public function action_index()
  {
      $pagination = Pagination::factory(array(
           'total_items'    => ORM::factory('user')->count_all(),
           'items_per_page' => 20,
       ));

      $users = ORM::factory('user')
                              ->limit($pagination->items_per_page)
                              ->offset($pagination->offset)
                              ->find_all();

      $this->template->content
        ->set('page_links', $pagination->render())
        ->bind('users', $users);   
  }

  public function action_role()
  {
      $id   = $this->request->param('id') ? $this->request->param('id') : 0;
      $role = ORM::factory('role')->where('id', '=', $id)->find();
      
      $pagination = Pagination::factory(array(
           'total_items'    => $role->users->count_all(),
           'items_per_page' => 20,
       ));

      $users      = $role->users
                            ->limit($pagination->items_per_page)
                            ->offset($pagination->offset)
                            ->find_all();                              

      $this->template->content
        ->set('page_links', $pagination->render())
        ->bind('role', $role)
        ->bind('users', $users);        
  }
  
  public function action_show()
  {
      $id         = $this->request->param('id');
      $user       = $this->get_object($id,'user');
      $user_roles = $user->roles->find_all()->as_array('id', 'name');
      
      $this->template->content
          ->bind('user', $user)
          ->bind('user_roles', $user_roles);
  }


  public function action_edit()
  {
      $id         = $this->request->param('id');
      $user       = $this->get_object($id,'user');
      $all_roles  = ORM::factory('role')->find_all();
      $user_roles = $user->roles->find_all()->as_array('id', 'name');      

      if ($_POST = $this->sanitize_input( $this->request->post() ) )
      {    
          $user->update_roles( array_values($_POST['roles']) );
          $user->values($_POST);
          
          if ($user->check() )
          {
              $user->save();
              
              if ($user->is_changed() ) 
              {
                  Message::add('success', __('User account successfully updated'));                              
              }
              $this->redirect($this->current_role.'/users/show/'.$user->id);
          }
          else
          {
              $errors = $user->validate()->errors('user');
          }
          Debug::vars($user);
      }

      $this->template->content
          ->bind('user', $user)
          ->bind('errors', $errors)
          ->bind('user_roles', $user_roles)
          ->bind('all_roles', $all_roles);  
  }

      
  public function action_create()
  {
      if (isset($_POST) AND Valid::not_empty($_POST))
      {        
          $user = ORM::factory('user');
          $post = $_POST;
          try
          {
              $user->create_user($_POST, array(
                  'username',
                  'password',
                  'email',
              ));
              $success = true;
          }
          catch (ORM_Validation_Exception $e)
          {
              $errors = $e->errors('user');            
          }
          
          if (isset($success))
          {
              $user->add('roles', ORM::factory('role')->where('name', '=', 'login')->find());
              $user->add('roles', ORM::factory('role')->where('name', '=', 'user' )->find());
              
              $profile          = $user->profile;
              $profile->user_id = $user->id;
              $profile->save();
              
              Kohana::$log->add(Log::INFO, 'New user account successfully created: '.$post['username']);
              Message::add('success', __('New user account successfully created'));
          } 
      }
      
      $this->template->title  .= '> '.__('Create an account');
      $this->template->content
          ->bind('errors', $errors)
          ->bind('post', $post);
  }
}