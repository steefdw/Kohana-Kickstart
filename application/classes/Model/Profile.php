<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Profile extends ORM {

    protected $_belongs_to = array(
        'user'       => array('user' => 'user'),
    );
/*
    protected $_has_many = array(
        'items'     => array('model' => 'item', 'foreign_key' => 'profile_id'),
    );
*/     
    protected $_filters = array(TRUE => array('trim' => NULL));

    // auto timestamp
    protected $_created_column = array('column' => 'created_at', 'format' => 'Y-m-d H:i:s');
    protected $_updated_column = array('column' => 'updated_at', 'format' => 'Y-m-d H:i:s');

    public function rules()
    {
      return array(
          'user_id' => array(
              array('not_empty'),
        ),
      );
    }
            
}// End Profile Model