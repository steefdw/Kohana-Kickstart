<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Profiles extends Controller_Admin_Admin {

  public function before()
  {
      parent::before();
      $this->template->title .= ' > Profiles > '.Request::current()->action();
  }

  
  public function action_index()
  {
      $pagination = Pagination::factory(array(
           'total_items'    => ORM::factory('profile')->count_all(),
           'items_per_page' => 20,
       ));

      $profiles = ORM::factory('profile')
                              ->limit($pagination->items_per_page)
                              ->offset($pagination->offset)
                              ->find_all();

      $this->template->content
        ->set('page_links', $pagination->render())
        ->bind('profiles', $profiles);   
  }


  public function action_show()
  {
      $id      = $this->request->param('id');
      $profile = $this->get_object($id,'profile');
      
      $this->template->content
          ->bind('profile', $profile);
  }
      
  public function action_edit()
  {
      $id      = $this->request->param('id');
      $profile = $this->get_object($id,'profile');
      $errors  = array();

      if ($_POST = $this->sanitize_input( $this->request->post() ) )
      {
          $profile->values($_POST);
          if ($profile->check() )
          {
              $profile->save();

              if ($profile->is_changed() ) 
              {
                  Message::add('success', __('User profile successfully updated'));                              
              }
                            
              $this->redirect($this->current_role.'/profiles/show/'.$profile->id);
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
