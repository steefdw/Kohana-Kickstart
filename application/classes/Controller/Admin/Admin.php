<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Admin extends Controller_Application {

  public $template        = 'layouts/admin/application';
  public $auth_required   = TRUE;                   // Auth is required to access this controller
  public $auth_role       = array('login','admin'); // Required roles
  public $current_role    = 'admin';
    
  public function before()
  {
      parent::before();
      View::bind_global('current_role', $this->current_role);              
  }
  

  public function action_index()
  {
      $user       = Auth::instance()->get_user();
      $user_roles = $this->auth_role; //$user->roles->find_all()->as_array('id', 'name');
      
      $this->template->title .= '> Home';
      $this->template->content
          ->bind('user', $user)
          ->bind('user_roles', $user_roles);        
  }


  public function after()
  {
      if ($this->auto_render)
      {
          //$this->template->header->css    = array_merge($this->template->header->css, array('css/admin.css' => 'screen'));
          //$this->template->header->js     = array_merge($this->template->header->js,  array('js/admin.js'));
          $this->template->title           .= ' > Admin';
      }
      parent::after();
  }
    
}