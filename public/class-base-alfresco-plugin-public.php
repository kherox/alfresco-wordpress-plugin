<?php   

/**
 * @author kherox <deniskakou7@gmail.com>
 * @package public/class-tresoralfresco-public.php 
 */


 class BaseAlfrescoPlugin_Public{

  /**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( "wp_ajax_donwload_document_with_link", array($this,"donwload_document_with_link") );

    }
    
    /**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in TresorAlfresco_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The TresorAlfresco_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/tresoralfresco-public.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in TresorAlfresco_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The TresorAlfresco_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/tresoralfresco-public.js', array('jquery'), $this->version, false);
	   
		wp_localize_script( "ajax-script", "ajaxobject",array($this, array(
			"ajaxurl" => admin_url("admin-ajax.php") ,
			"security" => wp_create_nonce("my_nonce"))) );
	
	}
    





    public function show_folder(){
		global $wpdb;
		$metabox = get_post_meta(get_the_ID(), $this->plugin_name."_meta_attach_page", true);
		$repository_name = $wpdb->prefix .'default_alfresco_plugin_repositories';

		$repository_node_content = $wpdb->get_results($wpdb->prepare("SELECT * FROM $repository_name WHERE parent_name LIKE %s", '%'.$metabox.'%' ));
        include_once plugin_dir_path(__FILE__) .'./partials/folder_view.php';
	}
	

	public function donwload_document_with_link(){

		$upload_dir = (wp_get_upload_dir());
		$base_dir = $upload_dir['basedir'] .'/'.$this->plugin_name;
		if (!file_exists($base_dir)){
			mkdir($base_dir);
		}
		$filename = $base_dir.'/'.$_POST['name'];
		

		$res = wp_tresoralfresco_render_document_content_by_url($this->plugin_name,$_POST['url'],$filename);


		

		die();
	}



 }







?>