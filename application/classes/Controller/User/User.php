<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_User extends Controller_Application {

  public $template        = 'layouts/user/application';
  public $auth_required   = TRUE;                  // Auth is required to access this controller
  public $auth_role       = array('login','user'); // Required roles
  public $current_role    = 'user';
    
  public function before()
  {
      parent::before();
      View::bind_global('current_role', $this->current_role);                
  }
  

  public function action_index()
  {
      $user       = Auth::instance()->get_user();
      $user_roles = $this->auth_role;
      
      $this->template->title .= '> Home';
      $this->template->content
          ->bind('user', $user)
          ->bind('user_roles', $user_roles);        
  }
  

  public function after()
  {
      if ($this->auto_render)
      {
          //$this->template->header->css    = array_merge($this->template->header->css, array('css/user.css' => 'screen'));
          //$this->template->header->js     = array_merge($this->template->header->js,  array('js/user.js'));
          $this->template->title .= ' > User';
      }
      parent::after();
  }
    
}