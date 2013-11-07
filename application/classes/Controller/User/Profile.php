<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Profile extends Controller_User_User {

  public function before()
  {
      parent::before();
      $this->template->title .= ' > Profile > '.Request::current()->action();
  }

  
  public function action_index()
  {
      $user    = Auth::instance()->get_user();
      $profile = $user->profile;

      $this->template->content
          ->bind('profile', $profile);  
  }

  public function action_edit()
  {
      $user    = Auth::instance()->get_user();
      $profile = $user->profile;
      $errors  = array();

      if ($_POST = $this->sanitize_input( $this->request->post() ) )
      {
          $profile->values($_POST);
          if ($profile->check() )
          {
              $profile->save();
              $this->redirect($this->current_role.'/profile');
          }
          else
          {
              $errors = $profile->validate()->errors('profile');
          }
      }

      $this->template->content
          ->bind('profile', $profile)
          ->set('errors', $errors);
  }
}
