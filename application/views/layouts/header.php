<header class="header container">
<?php
    //echo '   environment: '. ((Kohana::$environment === Kohana::PRODUCTION) ? 'production' : 'development'). ' |';
    echo '   current_role: '.$current_role;
    echo ' | directory: '.   Request::current()->directory();
    echo ' | controller: '.  Request::current()->controller();
    echo ' | action: '.      Request::current()->action();
    //echo ' | language: '.    I18n::lang();
?>
  <h1>
    <?php 
        $sitename = Kohana::$config->load('appconfig.site.name');
        echo (Request::current()->uri() != "/" ? HTML::anchor('', $sitename) : $sitename);
        echo ($current_role == '') ? '' : ' :: '.$current_role.' portal';
    ?>
  </h1>
</header>
  
<div class="navbar navbar-static-top">
  <div class="navbar-inner">
    <div class="container">

      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a> 
      
      <div class="nav-collapse navbar-responsive-collapse collapse">
      
      <ul class="nav">
      <?php 
      foreach ($links as $link => $url):
        if (is_array($url) && isset($url['parent'])):
            $current = (in_array(Request::current()->controller(),$url['parent']['controllers']) !== false)
                     ? ' class="active dropdown"'
                     : ' class="dropdown"';
            echo '<li'.$current.'>'.html::anchor($url['parent']['url'], $link.'<b class="caret"></b>', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));
        ?>
          <ul class="dropdown-menu">
            <?php
            foreach ($url['sub'] as $key => $value):
                $current = (Request::current()->uri() == $value['url'])
                         ? ' class="active test"'
                         : '';
                echo '<li'.$current.'><a href="'.Url::base().$value['url'].'"><img title="" src="'.Url::base().'img/icons/'.$value['img'].'" />'.$value['link'].'</a></li>';
            endforeach ?>
          </ul>
        <?php
        elseif(is_array($url)):
            $current = (in_array(Request::current()->controller(),$url['controllers']) !== false)
                     ? ' class="active"'
                     : '';
            echo '<li'.$current.'>'.html::anchor($url['url'], $link).'';
        else:
            $current = (Request::current()->uri() == $url)
                     ? ' class="active test"'
                     : '';
            echo '<li'.$current.'>'.html::anchor($url, $link).'';
        endif;
      endforeach;
      ?>
      </ul>
  
      <ul class="nav pull-right">  
      <?php if (Auth::instance()->logged_in()): ?>
        <li class="dropdown<?php echo Request::current()->controller() == 'Account' ? ' active' : '' ?>">
          <a href="<?php echo Url::base().$current_role ?>" class="dropdown-toggle" data-toggle="dropdown">
            <?php echo Auth::instance()->get_user()->username ?>
            <b class="caret"></b>
          </a>
          <ul class="dropdown-menu">
            <li><?php echo '<a href="'.Url::base().'account"><img title="" src="'.Url::base().'img/icons/vcard.png" />'.__('Account').'</a>' ?></li>
            <li><?php echo '<a href="'.Url::base().'logout"><img title="" src="'.Url::base().'img/icons/door_out.png" />'.__('Logout').'</a>' ?></li>
          </ul>   
      <?php else: ?>
        <li<?php echo Request::current()->uri() == "account/create" ? ' class="active"' : '' ?>><?php echo HTML::anchor('account/create', __('Register')) ?></li>
        <li<?php echo Request::current()->uri() == "login"          ? ' class="active"' : '' ?>><?php echo HTML::anchor('login', __('Login')) ?></li>
      <?php endif ?>
      
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            Language
            <b class="caret"></b>
          </a>
          <ul class="dropdown-menu">
          <?php foreach(Kohana::$config->load('appconfig.language') as $lg) { ?>
            <li>
            <?php echo '<a href="'.Url::base().'/account/language/'.$lg.'"><img title="" src="'.Url::base().'img/icons/flag_'.$lg.'.png" />'.__($lg).'</a>' ?>
            </li>
          <?php } ?>
          </ul>                    
      </ul>
      </div>
     
    </div>
  </div>
</div>
