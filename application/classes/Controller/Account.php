<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller_Application {

  public function before()
  {
      parent::before();
      $this->template->title .= ' > Account';
  }

  
  public function action_index()
  {
      $user       = $this->current_user();
      $user_roles = $user->roles->find_all()->as_array('id', 'name');

      $this->template->content
          ->bind('user', $user)
          ->bind('user_roles', $user_roles);
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
              // add roles
              $user->add('roles', ORM::factory('role')->where('name', '=', 'login')->find());
              $user->add('roles', ORM::factory('role')->where('name', '=', 'user' )->find());

              // create profile
              $profile          = $user->profile;
              $profile->user_id = $user->id;
              $profile->save();
                  
              Kohana::$log->add(Log::INFO, 'New user account successfully created: '.$post['username']);
              Message::add('success', __('New user account successfully created'));
              
              Auth::instance()->login($user->username, $post['password']);
              $this->redirect_to_account();
          } 
      }
      
      $this->template->title  .= '> '.__('Create an account');
      $this->template->content
          ->bind('errors', $errors)
          ->bind('post', $post);
  }
  
  public function action_edit()
  {
      $user       = $this->current_user();
      $all_roles  = ORM::factory('role')->find_all();
      $user_roles = $user->roles->find_all()->as_array('id', 'name');

      if (isset($_POST) AND Valid::not_empty($_POST))
      {        
          try
          {              
              $user->update_user($_POST, array(
                  'username',
                  'password',
                  'email',
              ));
              if ($user->is_changed() ) 
              {
                  Message::add('success', __('User account successfully updated'));                              
              }
              $this->redirect('account');  

          }
          catch (ORM_Validation_Exception $e)
          {
              $errors = $e->errors('user');            
          }
      }

      $this->template->content
          ->bind('user', $user)
          ->bind('errors', $errors)
          ->bind('user_roles', $user_roles)
          ->bind('all_roles', $all_roles);        
  }

        
  public function action_login()
  {    
      if (Auth::instance()->logged_in())
      {
          $this->redirect_to_account(); // user already logged in, redirect to the user account
      }
  
      if (isset($_POST) AND Valid::not_empty($_POST)) 
      {
          $post = Validation::factory($_POST)
                    ->rule('username', 'not_empty')
                    ->rule('password', 'not_empty')
                    ->rule('password', 'min_length', array(':value', Kohana::$config->load('appconfig.account.create.password.min_length')));
          $remember = isset($post['remember']);
          
          if ($post->check() AND Auth::instance()->login($post['username'], $post['password'], $remember))
          {
              $this->redirect_to_account();
          } 
          else 
          {
              $errors = $post->errors('user'); // validation errors
              if ( ! $errors) $errors[] =  __('Wrong username or password');
          }    
      }
  
      $this->template->title  .= ' > '.__('Login');
      $this->template->content
              ->bind('post', $post)
              ->bind('errors', $errors);
  }

  
  public function action_logout()
  {    
      Auth::instance()->logout(); // log out user
      $this->redirect('');        // redirect to the home page
  }

  /**
   * reset password step 1
   */
  public function action_forgot()
  {
      if (isset($_POST) AND Valid::not_empty($_POST)) 
      {    
          $post = Validation::factory($_POST)
                  ->rule('email', 'not_empty')
                  ->rule('email', 'email')
                  ->rule('email', 'email_domain')
                  ->rule('email', array($this, 'pwdexist'), array(':validation', ':field'));
          
          if ($post->check()) 
          {        
              $user = ORM::factory('user')->where('email', '=', $post['email'])->find();
              $user->reset_token = $user->generate_hash(32,'token');
              $user->save();
              $this->send_email($user);
          } 
          else 
          {
            $errors = $post->errors('user');
          }
      }
  
      $this->template->title  .= ' > Reset password';
      $this->template->content
              ->bind('post', $post)
              ->bind('errors', $errors);
  }
  
  /**
   * reset password step 2
   */
  public function action_reset_password()
  {   
      if (Auth::instance()->logged_in()) 
      {
          $this->redirect_to_account(); // user already logged in, redirect to dashboard
      }
      
      $email = Arr::get($_GET, 'email', false);
      $token = Arr::get($_GET, 'token', false);

      if ($email AND $token) 
      {
          if ((strlen($token) == 32) AND Valid::email($email))
          {              
              $user = ORM::factory('user')->where('email', '=', $email)->where('reset_token', '=', $token)->find();
          }
      }
      
      if (isset($_POST) AND Valid::not_empty($_POST) AND $user AND $user->loaded()) 
      {
          $post = array(
              'password'         => Arr::get($_POST, 'password', false),
              'password_confirm' => Arr::get($_POST, 'password_confirm', false),
              'reset_token'      => NULL, 
          );
          
          // empty passwords are filtered out in the user model, so let's trigger an validation exception
          if (empty($post['password'])) $post['password'] = 'no';
          
          try
          {
              $user->update_user($post, array(
                  'password', // don't set password_confirm here as well
                  'reset_token',                  
              ));
              
              if (Auth::instance()->login($user->username, $post['password'])) 
              {
                  Message::add('success', __('New password set'));
                  $this->redirect_to_account();
              }
          }
          catch (ORM_Validation_Exception $e)
          {
              $errors = $e->errors('user');            
          }
      }

      if ( ! $_POST AND isset($_GET['email']))
      {
          if ( ! $email OR ! Valid::email($email))
          {
              $email = false; // let the user paste the token and email
              $errors[] =  __('Please enter the').' '.__('Account email address');
          }
          if (strlen($token) != 32)
          {
              $errors[] =  __('Please enter the').' '.__('Reset Token');
          }
      }
                  
      $this->template->title  .= ' > Reset password step 2';
      $this->template->content
          ->bind('email', $email)
          ->bind('token', $token)
          ->bind('errors', $errors)
          ->bind('user', $user);
  }
  
  /**
   * check if username is available, call by ajax
   */
  public function action_checkusername()
  {
      if ($this->request->is_ajax())
      {
          $this->auto_render = FALSE;
      
          if ( ! ORM::factory('user')->unique_key_exists($_POST['username']))
          {
              echo json_encode(array('available' => 1));
          }
          else
          {
              echo json_encode(array('available' => 0));
          }
      }
  }  

  /**
   * Language switcher
   */
  public function action_language()
  {
      $lang = $this->request->param('id');

      if (in_array($lang, Kohana::$config->load('appconfig.language')))
      {
          Cookie::set('lang', $lang);
          I18n::lang($lang);
          Message::add('success',__('Language changed to ').__($lang));          
      }           
      $this->redirect(Session::instance()->get('controller'));
  }

  /**
   * check if username is available, call by ajax
   */
  public function send_email($user)
  {
      if ( ! $user->email) // no email, so no way of sending a password
      {
          Message::add('error', __('Could not send email, no email address given'));
          return false;
      }
      else
      {
          $mail_to      = $user->email;
          $mail_from    = array(Kohana::$config->load('appconfig.site.email'),Kohana::$config->load('appconfig.site.name'));
          $mail_body    = View::factory('layouts/email');          
          $template     = isset($reset) ? 'reset_password' : 'reset_password';
          $mail_subject = __($template); // TODO: better email subject
          $role         = $user->roles->where('name', '!=', 'login')->find()->name;
          
          $mail_body->content = View::factory('email/'.$template)
              ->set('role', $role)
              ->set('user', $user);
 
          $mailer = Email::connect();          
          
          if (Email::send($mail_to, $mail_from, $mail_subject, $mail_body->render(), TRUE))
          {
              Kohana::$log->add(Log::INFO, 'success, '.__('Password reset email sent to ').$mail_to);
              Message::add('success', __('Password reset email sent to ').$mail_to);
              $this->redirect('login');
          }
          else
          {
              Message::add('error', __('Could not send email to ').$mail_to);
              Kohana::$log->add(Log::ERROR, 'failure, '.__('Could not send email to ').$mail_to);
          }            
      }
  }

  /**
   * redirect the user to the his role space
   **/               
  private function redirect_to_account()
  {
      $role = (Auth::instance()->logged_in())
            ? Auth::instance()->get_user()->roles->where('name', '!=', 'login')->find()->name
            : false;
             
      switch ($role) {
        case 'user':
          $this->redirect('user');
        break;
        case 'admin':
          $this->redirect('admin');
        break;
        default:
          $this->redirect('/');
        break;
      }     
  }

  /**
   * validation rule: password != username
   **/      
  static function pwdneusr($validation, $password, $username)
  {
    if ($validation[$password] === $validation[$username])
    {
      $validation->error($password, 'pwdneusr');
    }
  }

  /**
   * validation rule: password exist
   **/    
  static function pwdexist($validation, $email)
  {
    if ( ! ORM::factory('user')->unique_key_exists($validation[$email]))
    {
      $validation->error($email, 'emailexistnot');
    }
  }
  
}