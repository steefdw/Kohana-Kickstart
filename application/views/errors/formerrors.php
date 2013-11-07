<?php
if (isset($errors) AND !empty($errors) )
{   
    echo '<div id="form_error" class="alert alert-error">Some errors were encountered, please check the details you entered.<ul>';
    foreach(Arr::flatten($errors) as $error)
    {
      echo '<li>'.$error.'</li>';
    }
    echo '</ul></div>';
}
?>