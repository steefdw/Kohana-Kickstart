<?php defined('SYSPATH') or die('No direct script access.');
class ORM extends Kohana_ORM {
  /**
   * ORM extends Kohana_ORM
   *
   * Extending the ORM with some nice features
   */

  // store the values of the previous save, remains the same after calling values
  protected $_cached_attributes = array();
  protected $_enum_field_values = array();

  public function values(array $values, array $expected = NULL)
  {
      unset($values['created_at']);               // shouldn't this being done in the models?
      unset($values['updated_at']);               // shouldn't this being done in the models?

      $this->_cached_attributes = $this->_object; // store the current values (the ones in the database)
      $this->convert_dates($values);              // convert dates from viewformat to database format

      parent::values($values);                    // set the new values
      return $this;                               // needed for chaining: $object->values(...)->update(...)
  }

/**
 * Check if updated values of the object made some changes to the object
 *
 * @return bool    there were changes made or not
 *
 * example usage:
 * if ($user->is_changed() ) echo 'succesfully updated your account';
 */
  public function is_changed()
  {
      return count( $this->changes_for_update() ) > 0 ? true : false;
  }

  public function changes_for_update()
  {
      $arrChanged = array_diff_assoc($this->_object, $this->_cached_attributes);

      if (count($arrChanged) > 0 )
      {
          return array_combine( array_keys($arrChanged), array_keys($arrChanged) );
      }
      else
      {
          return array();
      }
  }

 /**
 * Check posted date values, and reformat them for the database
 */
  public function convert_dates(&$values)
  {
      foreach($values as $key => $value)
      {
          if ($this->is_date($key) )
          {
              $values[$key] = $this->date2db($value);
          }
      }
  }

 /**
 * Check if column is a date.
 *
 * All date, datetime or timestamp DB columns should end with _at
 *
 * @param  string    column name
 * @return bool      is it a date column? (yes/no)
 */
  public function is_date($field)
  {
      return (preg_match('/_at$/', $field) >= 1);
  }

 /**
 * Reformat posted dates to the DB datetime format
 *
 * @param  string    date, assuming format 'd/m/Y H:i'
 * @return string    formatted datetime, format 'Y-m-d H:i' or 'Y-m-d'
 */
  public function date2db($date = FALSE)
  {
      if ($date AND !empty($date) AND $date !='00/00/0000' AND $date !='00/00/0000 00:00' AND strpos($date, '/') !== FALSE)
      {
        $datetime = explode(" ", $date);
        $date_arr = explode("/", $datetime[0]);

        if (strpos($date, '/') == TRUE AND !isset($datetime[1])) // date only
        {
            return $date_arr[2].'-'.$date_arr[1].'-'.$date_arr[0];
        }
        elseif (strpos($datetime[0], '/') == TRUE AND $datetime[1] == TRUE AND strpos($datetime[1], ':') == TRUE) // date+time
        {
            $time = $datetime[1];
            return $date_arr[2].'-'.$date_arr[1].'-'.$date_arr[0].' '.$time;
        }
        else
        {
            return 'error';
        }
      }
  }

/**
 * overload of __get() to add the attributes [date_field]_minutes, [date_field]_hour, [date_field]_datetime, [date_field]_date
 *
 * add one of these suffixes to a date/datetime/timestamp table column for automatic
 * date formatting instead of using in all views:
 *  echo date('d/m/Y H:i', strtotime($obj->created_at ));
 *
 * @param  string        [date_field] column name with suffix (_minutes, _hour, _datetime, _date)
 * @return string        formatted date and/or time
 *
 * example usage:
 * echo $user->updated_at_datetime;
 */
  public function __get($column)
  {
      // WATCH IT! Every column can be called here, even name_minutes will execute this code.
      if ( ! array_key_exists($column, $this->_table_columns) AND preg_match('/(.*)_(minutes|hour|datetime|date)$/', $column, $matches) > 0 )
      {
          if (in_array($this->_table_columns[$matches[1]]['data_type'], array('datetime', 'date', 'timestamp') ) )
          {
              switch ($matches[2])
              {
                  case 'minutes':
                    return $this->get_formatted_datetime( $matches[1], Kohana::$config->load('appconfig.date_format.minutes') );
                  break;
                  case 'hour':
                    return $this->get_formatted_datetime( $matches[1], Kohana::$config->load('appconfig.date_format.hour') );
                  break;
                  case 'datetime':
                    return $this->get_formatted_datetime( $matches[1], Kohana::$config->load('appconfig.date_format.datetime') );
                  break;
                  case 'date':
                    return $this->get_formatted_datetime( $matches[1], Kohana::$config->load('appconfig.date_format.date') );
                  break;
              }
          }
          else
          {
              throw new Kohana_Exception('The :property property has no parent property with datetime class',
                   array(':property' => $column));
          }

      }
      return parent::__get($column);
  }

/**
 * Create new object attributes [date_field]_minutes, [date_field]_hour, [date_field]_datetime, [date_field]_date
 *
 * @param  string      [date_field] column name with suffix (_minutes, _hour, _datetime, _date)
 * @param  string      date format. See: http://php.net/manual/en/function.date.php
 * @return string      formatted date and/or time
 */
  public function get_formatted_datetime($column, $format)
  {
      $value = $this->__get($column);
      return empty($value) ? '' : date( $format , strtotime( $value ));
  }

/**
 * Generate a random hash
 *
 * Can be used for passwords, or other random strings
 *
 * @param  int       string length
 * @param  mixed     possible characters: [0-9a-z] or [0-9a-zA-z!@#$%^&*-+_]
 * @return string    random string
 *
 * example usage:
 *  echo ORM::factory('user')->generate_hash(10,'strong');
 */
  public function generate_hash($length=8, $type = 'weak')
  {
      // start with a blank password
      $password = "";

      // define possible characters
      if    ($type == 'strong') $possible = "0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ!@#$%^&*-+_";
      elseif($type == 'token')  $possible = "123456789abcdefghjklmnpqrstuvwxyz123456789";
      else                      $possible = "0123456789bcdfghjkmnpqrstvwxyz";

      // add random characters to $password until $length is reached
      $i = 0;
      while ($i < $length AND $i < 200)
      {
          // pick a random character from the possible ones
          $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

          // we don't want this character if it's already in the password,
          // except if the password already has all possible characters
          if ( !strstr($password, $char) OR strlen($possible)-3 < strlen($password) )
          {
              $password .= $char;
              $i++;
          }
      }

      return $password;
  }

/**
 * Get an array of enum field values
 * (with optional default value to be prepended as first key)
 *
 * @param   string  enum field name
 * @param   string  a default value to be prepended as first key
 * @return  array   values of the enum field in the database
 *
 * inspired by: http://forum.kohanaframework.org/discussion/3682/ko3-getting-field-type-from-ormmodel/
 *
 * Example usage:
 * echo Form::select('body_type', $profile->enum_field_values('body_type', 'Please select Body Type'));
 */
  public function enum_field_values($field, $default = NULL)
  {
      // Check if enum data has already been pulled as to avoid unnecessary database calls
      if (empty($this->_enum_field_values))
      {
          $columns = $this->list_columns();

          foreach ($columns as $column => $row)
          {
              // Only parse columns of the type enum
              if (strpos($row['data_type'], 'enum') !== FALSE)
              {
                  // Set protected variable with the enum array list for the column
                  $values = $row['options'];

                  $this->_enum_field_values[$column] = $values;
              }
          }
      }

      /* Store enum array into temp variable for use in the step below (details below).
         If using this function against the same field twice, the second call would contain the default value prepended
         already and it would prepended it again, a temp variable fixes this as we don't modify the orignal array list. */
      $enum_values = $this->_enum_field_values[$field];

      // If a default value is passed, prepend it the enum array list
      if ( !is_null($default) ) $values[''] = array_unshift($enum_values, $default);

      // Return the columns enum list as an array
      return $enum_values;
  }
}