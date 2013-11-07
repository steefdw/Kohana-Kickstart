<?php defined('SYSPATH') or die('No direct access allowed.');

class Message {

  /**
   * Adds a flash message to the session
   *
   *    Message::add('success', __('User account successfully updated'));
   *
   * @param   string  message type
   * @param   string  message to be displayed
   */
  public static function add($type, $message)
  {
    // get session messages
    $messages = (array) Session::instance()->get('messages');

    // append message to messages
    $messages[$type][] = $message;

    // set messages in session
    Session::instance()->set('messages', $messages);
  }

  /**
   * Count number of flash messages. Can be used to check if there are any messages to display
   *
   * @return  int   number of messages
   */
  public static function count()
  {
    return count(Session::instance()->get('messages'));
  }

  /**
   * Return HTML of flash messages to be displayed
   *
   *    echo Message::output();
   *
   * @return  HTML of messages to be displayed
   */
  public static function output()
  {
    $str = '';
    $messages = Session::instance()->get('messages');
    Session::instance()->delete('messages');
    if ( ! empty($messages))
    {
      foreach ($messages as $type => $messages)
      {
        foreach ($messages as $message)
        {
          $str .= '<div class="alert alert-' . $type . '">' . $message . '<a class="close">×</a></div>';
        }
      }
    }
    return $str;
  }
}