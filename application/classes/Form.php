<?php defined('SYSPATH') or die('No direct script access.');

class Form extends Kohana_Form {

  /**
   * Creates a form input. If no type is specified, a "text" type input will
   * be returned.
   *
   * echo Form::input('username', $username);
   *
   * @param   string  input name
   * @param   string  input value
   * @param   array   html attributes
   * @return  string
   * @uses    HTML::attributes
   */
  public static function input($name, $value = NULL, array $attributes = NULL)
  {
      // Add the id automatically
      if ( ! isset($attributes['id']))
      {
          $attributes['id'] = str_replace(array("[", "]"), "", $name);
      }

       // Add the type as class for better styling
      $class = (isset($attributes['class'])) ? $attributes['class'].' ' : '';
      $type  = (isset($attributes['type']) ) ? $attributes['type'] : 'text';

      $attributes['class'] = $class.$type;

      return parent::input($name, $value, $attributes);
  }

  /**
   * Creates a checkbox form input.
   *
   *     echo Form::checkbox('remember_me', 1, (bool) $remember);
   *
   * @param   string   input name
   * @param   string   input value
   * @param   boolean  checked status
   * @param   array    html attributes
   * @return  string
   * @uses    Form::input
   */
  public static function checkbox($name, $value = NULL, $checked = FALSE, array $attributes = NULL)
  {
      // Add the id automatically
      if ( ! isset($attributes['id']))
      {
          $id = str_replace(array("[", "]"), "", $name);
          // if checkbox is part of a group, i.e. "roles[]", add the value to the ID
          $attributes['id'] = ($id == $name) ? $id : $id.'_'.$value;
      }

      return parent::checkbox($name, $value, $checked, $attributes);
  }

  /**
   * Creates a radio form input.
   *
   *     echo Form::radio('like_cats', 1, $cats);
   *     echo Form::radio('like_cats', 0, ! $cats);
   *
   * @param   string   input name
   * @param   string   input value
   * @param   boolean  checked status
   * @param   array    html attributes
   * @return  string
   * @uses    Form::input
   */
  public static function radio($name, $value = NULL, $checked = FALSE, array $attributes = NULL)
  {
      // Add the id automatically
      if ( ! isset($attributes['id']))
      {
          $attributes['id'] = str_replace(array("[", "]"), "", $name).'_'.$value;
      }

      return parent::radio($name, $value, $checked, $attributes);
  }

  /**
   * Creates a textarea form input.
   *
   *     echo Form::textarea('about', $about);
   *
   * @param   string   textarea name
   * @param   string   textarea body
   * @param   array    html attributes
   * @param   boolean  encode existing HTML characters
   * @return  string
   * @uses    HTML::attributes
   * @uses    HTML::chars
   */
  public static function textarea($name, $body = '', array $attributes = NULL, $double_encode = FALSE)
  {
      // Add the id automatically
      if ( ! isset($attributes['id']))
      {
          $attributes['id'] = str_replace(array("[", "]"), "", $name);
      }

      return parent::textarea($name, $body, $attributes, $double_encode);
  }

  /**
   * Creates a select form input.
   *
   *     echo Form::select('country', $countries, $country);
   *
   * [!!] Support for multiple selected options was added in v3.0.7.
   *
   * @param   string   input name
   * @param   array    available options
   * @param   mixed    selected option string, or an array of selected options
   * @param   array    html attributes
   * @return  string
   * @uses    HTML::attributes
   */
  public static function select($name, array $options = NULL, $selected = NULL, array $attributes = NULL)
  {
      // Add the id automatically
      if ( ! isset($attributes['id']))
      {
          $attributes['id'] = str_replace(array("[", "]"), "", $name);
      }

      return parent::select($name, $options, $selected, $attributes);
  }

} // End form
