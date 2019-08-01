<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://majestic.com.au
 * @since      1.0.0
 *
 * @package    BaseAlfrescoPlugi
 * @subpackage BaseAlfrescoPlugi/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    BaseAlfrescoPlugi
 * @subpackage BaseAlfrescoPlugi/admin
 * @author     kherox <kk20deis@hotmail.fr>
 */
class BaseAlfrescoPlugin_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
        $this->version = $version;

        $this->permission = new Permission_Page($plugin_name,$version);
        $this->repository = New Repository_Admin($plugin_name,$version);

        


	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in tresoralfresco_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The tresoralfresco_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/alfresco-base-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in tresoralfresco_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The tresoralfresco_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/alfresco-base-plugin-admin.js', array( 'jquery' ), $this->version, false );

    }
    
    
    public function add_options_page() {

        add_menu_page( "Document Settings", "Manager Alfresco", "manage_options", $this->plugin_name,
         array($this,"display_alfresco_settings"),"", 80 );

        // add_submenu_page($this->plugin_name, "Load All data",
        //   "Load data", "manage_options", "load-all-content-page", array($this->repository,'load_all_content'));

        add_submenu_page("", "Repository content","Show content", "manage_options", "show-repository-content", array($this->repository,'show_base_node_folders'));
        
        add_submenu_page($this->plugin_name, "Node List",
          "Repositories", "manage_options", "repository-page", array($this->repository,'display_repository_page'));

        
       // add_submenu_page("", "","", "manage_options", "fetch-repository-content", array($this->repository,'fetch_repository_content'));


       
        
        add_submenu_page($this->plugin_name, "Document permissions liste",
          "List of Permissions", "manage_options", "list-permission-page", array($this->permission,'list_permission'));

        add_submenu_page($this->plugin_name, "Document permissions create",
          "create persmissions", "manage_options", "create-permission-page", array($this->permission,'create_permission'));



          add_meta_box( $this->plugin_name, "Repository Liste", array($this,"meta_box_function"), "page", "side", "high" );
        
        }



        

        
        public function alfresco_base_plugin_save_meta_box($post_id){

            if (array_key_exists($this->plugin_name.'_meta_attach_page',$_POST)){
                update_post_meta( $post_id, $this->plugin_name.'_meta_attach_page', $_POST[$this->plugin_name.'_meta_attach_page'] );
            }
        }



        public function show_repository_content(){
            
            include_once plugin_dir_path( __FILE__ ) . 'repository/partials/show-repository-content.php';
            
        }





    public function meta_box_function(){
        include_once plugin_dir_path( __FILE__ ) .'/partials/meta_box.php';
        
		
			
    }
    
    public function display_alfresco_settings() {
		include_once 'partials/alfresco-base-plugin-admin-display.php';
    }
    
    // public function display_repository_page() {
	// 	include_once 'partials/tresoralfresco-admin-repository.php';
	// }
    
    //register setting
    public function register_setting() {
        // Add a General section
        add_settings_section(
            $this->plugin_name.'_general',
            __( 'General', $this->plugin_name ),
            array( $this, $this->plugin_name . '_general_cb' ),
            $this->plugin_name
        );
        //add setting field
        //url
        add_settings_field(
            $this->plugin_name . '_url',
            __( 'URL', $this->plugin_name ),
            array( $this, $this->plugin_name . '_url_cb' ),
            $this->plugin_name,
            $this->plugin_name . '_general',
            array( 'label_for' => $this->plugin_name . '_url' )
        );
        //port
        add_settings_field(
            $this->plugin_name . '_port',
            __( 'Port', $this->plugin_name ),
            array( $this, $this->plugin_name . '_port_cb' ),
            $this->plugin_name,
            $this->plugin_name . '_general',
            array( 'label_for' => $this->plugin_name . '_port' )
        );
        //username
        add_settings_field(
            $this->plugin_name . '_folder',
            __( 'Folder', $this->plugin_name ),
            array( $this, $this->plugin_name . '_folder_cb' ),
            $this->plugin_name,
            $this->plugin_name . '_general',
            array( 'label_for' => $this->plugin_name . '_folder' )
        );
        //username
        add_settings_field(
            $this->plugin_name . '_username',
            __( 'Username', $this->plugin_name ),
            array( $this, $this->plugin_name . '_username_cb' ),
            $this->plugin_name,
            $this->plugin_name . '_general',
            array( 'label_for' => $this->plugin_name . '_username' )
        );
        //password
        add_settings_field(
            $this->plugin_name . '_password',
            __( 'Password', $this->plugin_name ),
            array( $this, $this->plugin_name . '_password_cb' ),
            $this->plugin_name,
            $this->plugin_name . '_general',
            array( 'label_for' => $this->plugin_name . '_password' )
        );
        
        //password
        add_settings_field(
            $this->plugin_name . '_password',
            __( 'Password', $this->plugin_name ),
            array( $this, $this->plugin_name . '_password_cb' ),
            $this->plugin_name,
            $this->plugin_name . '_general',
            array( 'label_for' => $this->plugin_name . '_password' )
        );
        
       
      
        
        register_setting( $this->plugin_name, $this->plugin_name . '_url', 'esc_url' );
        register_setting( $this->plugin_name, $this->plugin_name . '_port', 'intval' );
        register_setting( $this->plugin_name, $this->plugin_name . '_folder', 'sanitize_text_field' );
        register_setting( $this->plugin_name, $this->plugin_name . '_username', 'sanitize_text_field' );
        register_setting( $this->plugin_name, $this->plugin_name . '_password', 'sanitize_text_field' );
        
       // register_setting( $this->plugin_name, $this->plugin_name . '_display' );
        
    }
    
    public function basealfrescopluginwordpress_general_cb() {
        //echo '<p>' . __( 'Alfresco information.', $this->plugin_name ) . '</p>';
    }
    
    public function basealfrescopluginwordpress_url_cb() {
        ?>
			<input type="url" name="<?php echo $this->plugin_name . '_url' ?>" id="<?php echo $this->plugin_name . '_url'?>" value="<?php echo get_option( $this->plugin_name . '_url' )?>" placeholder="http://example.com">
		<?php
    }
    
    public function basealfrescopluginwordpress_port_cb() {
        ?>
			<input type="number" maxlength="5" name="<?php echo $this->plugin_name . '_port' ?>" id="<?php echo $this->plugin_name . '_port' ?>" value="<?php echo get_option( $this->plugin_name . '_port' )?>" placeholder="1234">
		<?php
    }
    
    public function basealfrescopluginwordpress_folder_cb() {
        ?>
			<input type="text" name="<?php echo $this->plugin_name . '_folder' ?>" id="<?php echo $this->plugin_name . '_folder' ?>" value="<?php echo get_option( $this->plugin_name . '_folder' )?>" placeholder="a684bfed-707f-4f1f-ab8d-8ef52563ffef">
		<?php
    }
    
    public function basealfrescopluginwordpress_username_cb() {
        ?>
			<input type="text" name="<?php echo $this->plugin_name . '_username' ?>" id="<?php echo $this->plugin_name . '_username' ?>" value="<?php echo get_option( $this->plugin_name . '_username' )?>" placeholder="username">
		<?php
    }
    
    public function basealfrescopluginwordpress_password_cb() {
        ?>
			<input type="password" name="<?php echo $this->plugin_name . '_password' ?>" id="<?php echo $this->plugin_name . '_password' ?>" value="<?php echo get_option( $this->plugin_name . '_password' )?>" placeholder="password">
		<?php
    }
    
    
    
    
    
    
    
    
    
    
}