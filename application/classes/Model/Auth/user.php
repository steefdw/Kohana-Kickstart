<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Default auth user
 *
 * @package    Kohana/Auth
 * @author     Kohana Team
 * @copyright  (c) 2007-2011 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_Auth_User extends ORM {

  /**
   * A user has many tokens and roles
   *
   * @var array Relationhips
   */
  protected $_has_many = array(
    'user_tokens' => array('model' => 'user_token'),
    'roles'       => array('model' => 'role', 'through' => 'roles_users'),
  );

  protected $_has_one = array
  (
      'profile' => array('model' => 'profile', 'foreign_key' => 'user_id'),
  );

  // auto timestamp
  protected $_created_column = array('column' => 'created_at', 'format' => 'Y-m-d H:i:s');
  protected $_updated_column = array('column' => 'updated_at', 'format' => 'Y-m-d H:i:s');
      
  /**
   * Rules for the user model. Because the password is _always_ a hash
   * when it's set,you need to run an additional not_empty rule in your controller
   * to make sure you didn't hash an empty string. The password rules
   * should be enforced outside the model or with a model helper method.
   *
   * @return array Rules
   */
  public function rules()
  {
    return array(
      'username' => array(
        array('not_empty'),
        array('min_length', array(':value', Kohana::$config->load('appconfig.account.create.username.min_length'))),
        array('max_length', array(':value', Kohana::$config->load('appconfig.account.create.username.max_length'))),
        array(Kohana::$config->load('appconfig.account.create.username.format')),
        array(array($this, 'unique'), array('username', ':value')),
      ),
      'password' => array(
        array('not_empty'),
        array('min_length',array(':value', Kohana::$config->load('appconfig.account.create.password.min_length'))),
        array(array($this, 'pwdneusr'), array(':validation', ':field', 'username')),
      ),
      'email' => array(
        array('not_empty'),
        array('email'),
        array('email_domain'),
        array(array($this, 'unique'), array('email', ':value')),
      ),
    );
  }
     
  /**
   * Filters to run when data is set in this model. The password filter
   * automatically hashes the password when it's set in the model.
   *
   * @return array Filters
   */
  public function filters()
  {
    return array(
      'password' => array(
        array(array(Auth::instance(), 'hash'))
      )
    );
  }

  /**
   * Labels for fields in this model
   *
   * @return array Labels
   */
  public function labels()
  {
    return array(
      'username'         => 'username',
      'email'            => 'email address',
      'password'         => 'password',
    );
  }

  /**
   * Complete the login for a user by incrementing the logins and saving login timestamp
   *
   * @return void
   */
  public function complete_login()
  {
    if ($this->_loaded)
    {
      // Update the number of logins
      $this->logins = new Database_Expression('logins + 1');

      // Set the last login date
      $this->last_login = time();

      // Save the user
      $this->update();
    }
  }

  /**
   * Tests if a unique key value exists in the database.
   *
   * @param   mixed    the value to test
   * @param   string   field name
   * @return  boolean
   */
  public function unique_key_exists($value, $field = NULL)
  {
    if ($field === NULL)
    {
      // Automatically determine field by looking at the value
      $field = $this->unique_key($value);
    }

    return (bool) DB::select(array('COUNT("*")', 'total_count'))
      ->from($this->_table_name)
      ->where($field, '=', $value)
      ->where($this->_primary_key, '!=', $this->pk())
      ->execute($this->_db)
      ->get('total_count');
  }

  /**
   * Allows a model use both email and username as unique identifiers for login
   *
   * @param   string  unique value
   * @return  string  field name
   */
  public function unique_key($value)
  {
    return Valid::email($value) ? 'email' : 'username';
  }

  /**
   * Password validation for plain passwords.
   *
   * @param array $values
   * @return Validation
   */
  public static function get_password_validation($values)
  {
    return Validation::factory($values)
      ->rule('password', 'min_length', array(':value', 8))
      ->rule('password_confirm', 'matches', array(':validation', ':field', 'password'));
  }
      
  // validation rule: password != username
  static function pwdneusr($validation, $password, $username)
  {
    if ($validation[$password] === $validation[$username])
    {
      $validation->error($password, 'pwdneusr');
    }
  }
  
  /**
   * Create a new user
   *
   * Example usage:
   * ~~~
   * $user = ORM::factory('user')->create_user($_POST, array(
   *  'username',
   *  'password',
   *  'email',
   * );
   * ~~~
   *
   * @param array $values
   * @param array $expected
   * @throws ORM_Validation_Exception
   */
  public function create_user($values, $expected)
  {
    // Validation for passwords
    $extra_validation = Model_User::get_password_validation($values)
      ->rule('password', 'not_empty');

    return $this->values($values, $expected)->create($extra_validation);
  }

  /**
   * Update an existing user
   *
   * [!!] We make the assumption that if a user does not supply a password, that they do not wish to update their password.
   *
   * Example usage:
   * ~~~
   * $user = ORM::factory('user')
   *  ->where('username', '=', 'kiall')
   *  ->find()
   *  ->update_user($_POST, array(
   *    'username',
   *    'password',
   *    'email',
   *  );
   * ~~~
   *
   * @param array $values
   * @param array $expected
   * @throws ORM_Validation_Exception
   */
  public function update_user($values, $expected = NULL)
  {
    if (empty($values['password']))
    {
      unset($values['password'], $values['password_confirm']);
    }

    // Validation for passwords
    $extra_validation = Model_User::get_password_validation($values);

    return $this->values($values, $expected)->update($extra_validation);
  }

  public function get_role()
  {
      return $this->roles->where('name', '!=', 'login')->find();
  }


  public function update_roles($new_role_ids = array())
  {
      $roles = array(
          'current' => array_keys($this->roles->select('id')->find_all()->as_array('id')),
          'new'     => $new_role_ids,
      );
      
      $actions = array(
          array_fill_keys( array_values( array_diff($roles['new'], $roles['current']) ), 'add'),
          array_fill_keys( array_values( array_diff($roles['current'], $roles['new']) ), 'remove'),
      );

      // loop through all actions
      foreach($actions as $changes)
      {
          foreach($changes as $role_id => $action) 
          {
              call_user_func(array($this, $action), 'roles', $role_id);
          }
      }
      
      parent::save();
  }
          
} // End Auth User Model