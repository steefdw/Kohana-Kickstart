<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Application extends Controller_Template {

  public $template      = 'layouts/application';
  public $auth_required = FALSE;
  public $auth_role     = array('login');
  public $current_role  = '';
  
/**
 * The before() method is called before the controller action.
 *  
 * In our template controller we override this method so that we can
 * set up default values. These variables are then available to our
 * controllers if they need to be modified.
 */
  public function before()
  {    
      parent::before();
      View::bind_global('current_role', $this->current_role); 
        
      $this->check_login();
      
      if ($this->auto_render)
      {
          // keep the last url if it's not home/language
          if (Request::current()->action() != 'language') 
          {
            Session::instance()->set('controller', Request::current()->uri());
          }
          
          $this->template->title         = 'Ko33 Kickstart';
          $this->template->content       = $this->set_default_template();
          $this->template->header        = new View('layouts/header');
          $this->template->header->css   = array();
          $this->template->header->js    = array();
          $this->template->header->links = array();
          $this->template->footer        = new View('layouts/footer');
          $this->template->footer->js    = array();
      }           
  }
   
/**
 * The after() method is called after the controller action.
 *  
 * In our template controller we override this method so that we can
 * make any last minute modifications to the template before anything
 * is rendered.
 */
  public function after()
  {
      if ($this->auto_render)
      {
          $this->template->header->js  = array_merge($this->template->header->js, array(
              'js/jquery-1.7.1.min.js',                 
              )
          );

          $this->template->footer->js  = array_merge($this->template->footer->js, array(
              'js/script.js',
              'js/google-code-prettify/prettify.js',
              'js/bootstrap.min.js',
              )
          );
          $this->template->header->css = array_merge($this->template->header->css, array(
              'css/bootstrap.css'        => 'screen',
              'css/bootstrap-responsive.css' => 'screen',
              'js/google-code-prettify/prettify.css' => 'screen',
              'css/styles.css'               => 'screen',
              )
          );
          $this->template->header->links = $this->set_links();
      }
      parent::after();
  }

/**
 * Check user auth and role.
 *  
 * If user hasn't got the right access level, redirect the user to the login
 * or "no access" page 
 */  
  private function check_login()
  {
      if ($this->auth_required == TRUE AND Auth::instance()->logged_in($this->auth_role) == FALSE)
      {
          if (Auth::instance()->logged_in())
          {
              $this->redirect('pages/noaccess');
          }
          else
          {
              $this->redirect('login');
          }
      }
  }

/**
 * Get user role.
 *  
 * Make sure the role of the session is used, instead of the one set by the
 * controller. In example: with this set, the user with role "admin" can go 
 * to (controller => pages, action => home) and all views have the variable
 * $current_role set to "admin".    
 */      
  public function get_role()
  {
      if (Auth::instance()->logged_in() AND $this->current_role == '') 
      {
          $this->current_role = Auth::instance()->get_user()->roles->where('name', '!=', 'login')->find()->name;
          View::bind_global('current_role', $this->current_role);
      }
      return $this->current_role;
  }
  
/**
 * Get an object by id and type    
 */  
  public function get_object($id, $type)
  {
      $object = ORM::factory($type)->where('id', '=',(int)$id)->find();
      if ( ! $object->loaded() )
      {
          $this->redirect('pages/404'); //throw new Kohana_Exception('Record not found');
      }
      return $object;
  }

/**
 * Get current logged in user, or redirect to the login page
 */  
  public function current_user()
  {
      $user = Auth::instance()->get_user();
      if ( ! $user )
      {
          Message::add('error', __('Please login to do that'));
          $this->redirect('login');
      }
      return $user;
  }
                  
/**
 * Set the template automatically.
 *  
 * Setting $this->template->content = View::factory('<directory>/<filename>');
 * for every action in every controller feels like recursion and is not 
 * necessary. Now the template is automatically set to:
 * $this->template->content = View::factory('(<directory>/)<controller>/<action>');
 * You can override this in the controller actions before binding/setting 
 * variables to $this->template->content       
 */     
  private function set_default_template()
  {
      $excluded_pages = array('delete', 'update', 'destroy', 'noaccess', 'logout','language');
      if ( ! in_array( Request::current()->action(), $excluded_pages ) )
      {
          if (Request::current()->directory() )
          {
              return View::factory(Request::current()->directory().'/'.Request::current()->controller().'/'.Request::current()->action());
          }
          elseif (in_array(Request::current()->controller(), array('Pages','Account')) )
          {
              return View::factory(Request::current()->controller().'/'.Request::current()->action());
          }         
      }
      // else
      return false; 
  }

/**
 * Set the links for the mainmenu.
 *  
 * Depending on the role, set the (titles => links) in the mainmenu
 * For submenu's, start the key with "sub" and an array as value. i.e.: *//*
              'Home'              => '/',
                  'sub'         => array(
                                        array('link' => 'Title1', 'url' => '/example1',   'img' => 'example1.png'),
                                        array('link' => 'Title2', 'url' => '/example2',   'img' => 'example2.png'),
                                   ),
 */
  private function set_links()
  {
      switch ($this->get_role()) {
        case 'user':
          $links = array(
              __('Home')              => '/',
              __('About')             => 'pages/about',
              //__('FAQ')               => 'pages/faq',
              __('Documentation')     => 'pages/docs',
              __('Dashboard')         => 'user',
          );
        break;
        case 'admin':
          $links = array(
              __('Home')              => '/',
              __('About')             => 'pages/about',
              //__('FAQ')               => 'pages/faq',
              __('Documentation')     => 'pages/docs',
              __('Dashboard')         => array(
                                          'url'         => 'admin',
                                          'controllers' => array('Admin')
                                      ),                                  
              __('Users')             => array(
                                          'parent' => array(
                                                          'url'         => 'admin/users',
                                                          'controllers' => array('Users','Roles')
                                          ), 
                                          'sub'    => array(
                                                          array('link' => 'Show users',  'url' => 'admin/users/role/2',   'img' => 'user.png'),
                                                          array('link' => 'Show admins', 'url' => 'admin/users/role/3',   'img' => 'user_red.png'),
                                          )
                                         ),              
              __('Profiles')          => array(
                                          'url'         => 'admin/profiles',
                                          'controllers' => array('Profiles')
                                      ), 
          );
        break;
        default:
          $links = array(
              __('Home')              => '/',
              __('About')             => 'pages/about',
              //__('FAQ')               => 'pages/faq',
              __('Documentation')     => 'pages/docs',
          );
      }
      return $links;  
  }
  
  public function sanitize_input($post)
  {
      foreach($post as $k => $v)
      {
          if (is_array($v))
          {
              $post[$k] = $this->sanitize_input($v);    
          }
          else
          {
              $post[$k] = HTML::chars($v);
          }
          
      }
      return $post;
  } 
      
}