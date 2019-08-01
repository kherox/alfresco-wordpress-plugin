<?php    

/**
 * Plugin Name: Alfresco  Wordpress  Plugin
 * Plugin URI:  https://github.com/kherox/alfresco-wordpress-plugin
 * Description: Plugin work with Alfresco installation .
 * Version:     0.1.0
 * Author:      Kherox
 * Author URI:  dvoyd.com
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: my-basics-plugin
 * 
 */

 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


function activate_base_alfresco_plugin(){
    require_once plugin_dir_path(__FILE__) .'includes/class-base-alfresco-plugin-activate.php';
    BaseAlfrescoPlugin_Activator::activate();
}

function deactivate_base_alfresco_plugin(){
    require_once plugin_dir_path(__FILE__) .'includes/class-base-alfresco-plugin-desactivator.php';
    BaseAlfrescoPlugin_Desactivator::deactivate();
}

function init_plugin_tables(){
    require_once plugin_dir_path(__FILE__) .'database/init_tables.php';
    
}

register_activation_hook(__FILE__, 'activate_base_alfresco_plugin');
register_activation_hook(__FILE__, 'deactivate_base_alfresco_plugin');
register_activation_hook(__FILE__, 'init_plugin_tables');




function wp_basealfrescopluginwordpress_render_node_content($plugin_name){
    $folder = get_option($plugin_name."_folder");
     $url    = get_option($plugin_name."_url");
     $user   = get_option($plugin_name."_username");
     $pass   = get_option($plugin_name."_password");

     $encoded = base64_encode($user.':'.$pass);

     $header = array(
         'headers' => array(
         'Authorization' => ' Basic '.$encoded
         )
     );

     $url = $url.'/root/'.$folder;

     $response = wp_remote_get( $url, $header );

     $responses = wp_remote_retrieve_body($response);

     $data = json_decode($responses, true);

     return $data;
}



function wp_alfrescobaseplugin_render_children_content($plugin_name,$children){

     $folder = get_option($plugin_name."_folder");
     $url    = get_option($plugin_name."_url");
     $user   = get_option($plugin_name."_username");
     $pass   = get_option($plugin_name."_password");

     $encoded = base64_encode($user.':'.$pass);

     $header = array(
         'headers' => array(
         'Authorization' => ' Basic '.$encoded
         )
     );

     $url = $url.'/root/'.$folder.'/'.$children;

     $response = wp_remote_get( $url, $header );

     $responses = wp_remote_retrieve_body($response);

     $data = json_decode($responses, true);

     return $data;
}


/**
* Checks compatibility with the current PHP version.
* @description get children for root content
* @since 5.2.0
*
* @param string $required Minimum required PHP version.
* 
*/

function wp_alfrescobaseplugin_render_children_content_by_url($plugin_name,$url){

    
     $user   = get_option($plugin_name."_username");
     $pass   = get_option($plugin_name."_password");

     $encoded = base64_encode($user.':'.$pass);

     $header = array(
         'headers' => array(
         'Authorization' => ' Basic '.$encoded
         )
     );

 

     $response = wp_remote_get( $url, $header );

     $responses = wp_remote_retrieve_body($response);

     $data = json_decode($responses, true);

     return $data;
}

/**
* Checks compatibility with the current PHP version.
* @description get document content  node
* @since 5.2.0
*
* @param string $required Minimum required PHP version.
* 
*/

function wp_alfrescobaseplugin_render_document_content_by_url($plugin_name,$url,$filename){

    
     $user   = get_option($plugin_name."_username");
     $pass   = get_option($plugin_name."_password");

     $encoded = base64_encode($user.':'.$pass);

     $header = array(
         "http"=>array(
          "method" => "GET",
         'header' => 'Authorization:  Basic '.$encoded
         
     ));

     $f = explode(".", $url);


     $ext = $f[count($f)-1];

 
     $context = stream_context_create($header);

    

     $data = fopen($url,'r',false,$context);

 


     $save = file_put_contents($filename.'.'.$ext, $data);

     if ($save){
         return true;
     }else{
         return false;
     }

    
}




/**
* Save content into custom tables
* 
* @since 5.2.0
*
* @param string $required table_name
* @param [] $required $data
* 
*/

function wp_alfresco_plugin_save_content($table_name,$data){

 global $wpdb;
 $success =  $wpdb->insert($table_name,$data);
 return $success;
    
}







/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-base-alfresco-plugin-default.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_base_alfresco_plugin() {

	$plugin = new BaseAlfrescoPlugin();
	$plugin->run();

}
run_base_alfresco_plugin();