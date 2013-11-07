<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pages extends Controller_Application {
    
    public $template        = 'layouts/application';
    
    public function before()
    {
        parent::before();
    }
    
    public function action_index()
    {
        $this->template->title .= '> '.__('Home');
    }
   
    public function action_about()
    {
        $this->template->title .= '> '.__('About');
    }

    public function action_faq()
    {
         $this->template->title .= '> '.__('Faq');
    }      

    public function action_docs()
    {
         $this->template->title .= '> '.__('Documentation');
    }
    
    public function action_noaccess()
    {
        // maybe render this without layout? but how?
        $this->template->content = View::factory('errors/401');
    }

    public function action_404()
    {
        $this->template->content = View::factory('errors/404');
    }   
} // End Pages
