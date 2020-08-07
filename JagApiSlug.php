<?php
namespace Jag;

class JagApiSlug
{
    // host api
    public $host = 'jagsite.test/';
    // id template display data
    public $page_id = 7;
    // action call ajax to display layout
    public $action = 'action_slug_api';
    // key api
    public $key = '';
    // id dom of elementor when display payout example: #dispaly_content_api
    public $elementor = '';
    // url ajax example http://domain.com/wp-admin/admin-ajax.php
    public $ajax_url = '';
    /// info template when have slug
    public $template = array();
    /// config slug as slug of api
    public $slugs= array(
        'our-events' => array('slug'=>false,'url'=>'api/v1/event/list'),
        'events-detail' => array('slug'=>'id','url'=>'api/v1/event/'),
        'blogs' => array('slug'=>false,'url'=>'api/v1/blog/list'),
        'blog-detail' => array('slug'=>'id','url'=>'api/v1/blog/detail/'),
        'blog_categories' => array('slug'=>false,'url'=>'api/v1/blog/categories'),
        'blog_category' => array('slug'=>'id','url'=>'api/v1/blog/category/'),
    );
    public function __construct()
    {
        /// call rule to run slug
        add_action('init',array($this,'custom_rewrite_rule'),10,0);
        // add template in footer
        add_action('wp_footer',array($this,'f_get_template'));
    }
/// function call run slug in wp
    function custom_rewrite_rule(){
        $page_id = $this->page_id;
        $slugs = $this->slugs;
        foreach ($slugs as $key => $value){
            if($value['slug']){
                add_rewrite_rule($key.'/([a-z0-9-]+)[/]?$','index.php?page_id='.$page_id.'&'.$key.'=$matches[1]','top');
            }else{
                add_rewrite_rule($key.'[/]?$','index.php?page_id='.$page_id.'&'.$key.'=$matches[1]','top');
            }
        }
        /// end rewrite
        flush_rewrite_rules();
    }
/// function create template from slug url
    function f_get_template(){
        /// you need get info config in setting then insert here. the present it default
        $host = $this->host;
        $slugs = $this->slugs;
        $key = $this->key;
        $ajax_url = $this->ajax_url;
        $elementor = $this->elementor;
/// get slug from url and remove element empty
       $slug = array_filter( explode('/', $_SERVER['REQUEST_URI']) );
       // check exist in slugs config
       if(  isset( $slugs[$slug[1]] )){
           $template_api = $slugs[$slug[1]];
           $template_api['action'] = 'action_slug_api';
           $template_api['key'] = $key;
           $template_api['ajax_url'] = $ajax_url;
           $template_api['elementor'] = $elementor;
           $template_api['name'] = $slug[1];
           // check type template list or template single
           if($template_api['slug']){
               $template_api['url'] = $host.$template_api['url'].$slug[2];
           }else{
               $template_api['url'] = $host.$template_api['url'];
           }
           $this->do_template($template_api);

       }
    }
/// run template
    function do_template($template_api){
        $this->template = $template_api;
        if($template_api['slug']){
          include_once('template/template_single.php');
        }else{
            require_once('template/template_list.php');
        }
    }

}