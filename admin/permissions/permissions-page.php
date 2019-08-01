<?php 

/**
 * @author kherox <deniskakou7@gmail>
 * @package Admin/permissions/permissions-page.php 
 * 
 */

 
 class Permission_Page{


    public function __construct($plugin_name,$version){
      $this->plugin_name = $plugin_name;
      $this->version = $version;

      add_action( "wp_ajax_save_permission_attach_to_node", array($this,"save_permission_attach_to_node") );
    }


    public function list_permission(){

        global $wpdb;
        $permission_name = $wpdb->prefix .'default_alfresco_plugin_permissions';
        $permission_name_list = $wpdb->get_results("SELECT * FROM $permission_name");
        include_once plugin_dir_path( __FILE__ ) . '/views/permission-page-view.php';
    }

    public function create_permission(){

        if (isset($_POST['default_alfresco_plugin_add_permission_form']) && !empty($_POST['default_alfresco_plugin_add_permission_form'])){
            
            $form_name = $_POST['default_alfresco_plugin_add_permission_form'];

            if ($form_name !=  $this->plugin_name.'_permission'){
                die;
            }
            $data = [];

            if (isset($_POST[$this->plugin_name.'_permission_role']) && !empty($_POST[$this->plugin_name.'_permission_role'])){
                $data['permission_name'] = $_POST[$this->plugin_name.'_permission_role'];
            }

            if (isset($_POST[$this->plugin_name.'_permission_access_level_public']) && !empty($_POST[$this->plugin_name.'_permission_access_level_public'])){
                $data['access_level'] = "public";
            }
            //

            if (isset($_POST[$this->plugin_name.'_permission_access_level_private']) && !empty($_POST[$this->plugin_name.'_permission_access_level_private'])){
                if (!empty($data['access_level'])){
                    $data['access_level'] = $data['access_level'] . ';private';
                }else{
                    $data['access_level'] =  "private";
                }
                
            }

            if (isset($_POST[$this->plugin_name.'_permission_access_level_restricted']) && !empty($_POST[$this->plugin_name.'_permission_access_level_restricted'])){
                if (!empty($data['access_level'])){
                    $data['access_level'] = $data['access_level'] . ';restricted';
                }else{
                    $data['access_level'] =  "restricted";
                }

                $data['access_restricted_password'] = $_POST[$this->plugin_name . '_permission_access_level_restricted_password'];

                
            }

            global $wpdb;
            $permission_name = $wpdb->prefix .'default_alfresco_plugin_permissions';
            $success =  $wpdb->insert($permission_name,$data);

        }

        include_once plugin_dir_path( __FILE__ ) . '/views/create-permission-page-view.php';
    }

    public function register_permission_setting(){

        add_settings_section(
            $this->plugin_name.'_permission_general',
            __( 'General', $this->plugin_name ),
            array( $this, $this->plugin_name . '_permission_general_cb' ),
            $this->plugin_name.'_permission'
        );

        add_settings_field(
            $this->plugin_name.'_permission_role',
            __( 'Role', $this->plugin_name ),
            array( $this, $this->plugin_name . '_permission_role_cb' ),
            $this->plugin_name.'_permission',
            $this->plugin_name . '_permission_general' ,
            array( 'label_for' => $this->plugin_name . '_permission_role' )
        );

        add_settings_field(
            $this->plugin_name.'_permission_access_level',
            __( 'Access level', $this->plugin_name ),
            array( $this, $this->plugin_name . '_permission_access_level_cb' ),
            $this->plugin_name.'_permission',
            $this->plugin_name . '_permission_general' ,
            array( 'label_for' => $this->plugin_name . '_permission_access_level' )
        );

        add_settings_field(
            $this->plugin_name.'_permission_access_level_restricted_password',
            __( 'Retricted Password', $this->plugin_name ),
            array( $this, $this->plugin_name . '_permission_access_level_restricted_password_cb' ),
            $this->plugin_name.'_permission',
            $this->plugin_name . '_permission_general' ,
            array( 'label_for' => $this->plugin_name . '_permission_access_level_restricted_password' )
        );


        register_setting( $this->plugin_name.'_permission', $this->plugin_name . '_permission_role', 'sanitize_text_field' );
    }

    public function basealfrescopluginwordpress_permission_general_cb() {
        //echo '<p>' . __( 'Alfresco information.', $this->plugin_name ) . '</p>';
    }

    public function basealfrescopluginwordpress_permission_role_cb() {
        ?>
			<input type="text" name="<?php echo $this->plugin_name . '_permission_role' ?>" id="<?php echo $this->plugin_name . '_permission_role' ?>"  placeholder="admin">
		<?php
    }


    public function basealfrescopluginwordpress_permission_access_level_restricted_password_cb() {
        include_once plugin_dir_path( __FILE__ ) .'/views/partials/access_level_restricted.php';
    }

    public function basealfrescopluginwordpress_permission_access_level_cb() {
        include_once plugin_dir_path( __FILE__ ) .'/views/partials/access_level.php';
    }


    public function save_permission_attach_to_node(){

        $access_level = $_POST['access_level'];
        $node_name = $_POST['node_name'];
        $id = $_POST['id'];

        $content = [
            "access_level" =>$access_level,
            "node_name" =>$node_name
        ];

        global $wpdb;
        $parent_node = $wpdb->prefix .'default_alfresco_plugin_repositories_parent_node';
        $result = $wpdb->update($parent_node,$content,['id'=>intval($id)]);
        die();

    }

   

 }






?>