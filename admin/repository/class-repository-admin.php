<?php 

/**
 * @author kherox <deniskakou7@gmail.com>
 * @package admin/repository
 * @param mixed $plugin_name $version
 */


 class Repository_Admin{

    private  $node_children_counter = 0;
    private  $node_children_content = [];


    public function __construct($plugin_name,$version){
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_action( "wp_ajax_load_repository_content", array($this,"load_repository_content") );
        add_action( "wp_ajax_update_node_folder_and_content_permission", array($this,"update_node_folder_and_content_permission") );
        
        
    }


    public function load_all_content(){
        return include_once plugin_dir_path( __FILE__ ) .'/partials/load-all-content.php';
    }


    public function load_repository_content(){

        $node_name = ($_POST["node_name"]);


        $base_url = get_option($this->plugin_name."_url");

        $root_folder = get_option($this->plugin_name."_folder");

        global $wpdb;

        $table_name = $wpdb->prefix .'default_alfresco_plugin_repositories';


        $counter = $wpdb->get_results($wpdb->prepare("SELECT COUNT(*) as counter FROM $table_name WHERE parent_name LIKE %s", '%'.$node_name.'%' ));

        

        $folder = 'root/'. $root_folder.'/'.$node_name;

        $url = $base_url.'/'.$folder;

        $this->recursive_folder_loader($url,$table_name,$node_name,$node_name,false);

        $node_counter = count($this->node_children_content);

        if (intval($counter[0]->counter) < $node_counter){
            foreach ($this->node_children_content as $key => $value) {
                $res = $wpdb->get_results($wpdb->prepare("SELECT parent_name  FROM $table_name where parent_name = %s AND children_name = %s",  $value['parent_name'] , $value['children_name']));
                if(!$res){
                    wp_alfresco_plugin_save_content($table_name,$value);
                }
            }


        }

        die();

    }

 


    private function recursive_folder_loader($url,$table_name,$node_name,$children,$isRc){

        $default_url = $url;

      
        $folders_and_content = wp_basealfrescopluginwordpress_render_children_content_by_url($this->plugin_name,$url);
        foreach ($folders_and_content['objects'] as $ky => $val) {
            $isFolder = false;
            $rp = [];
            foreach($val['object']['properties'] as $ks => $vs){
                if ($ks == "cmis:objectTypeId"){
                    if ($vs['value'] == "cmis:folder"){
                        $isFolder = true;
                    }
                }
                if ($ks == "cmis:name"){
                    if ($isFolder){
                        $url = $default_url .'/'.$vs['value'];
                        $children =  $children.'/'.$vs['value'];
                        $this->recursive_folder_loader($url,$table_name,$node_name , $children,true);
                    }else{
                        //not folder
                        $url = $default_url.'/'.$vs['value'];
                        $content = [
                            "parent_name" =>  $children,
                            "children_name" => $vs["value"],
                            "full_url" => $url,
                            "filetype" => "document"
                        ];
                        $this->node_children_content[] = $content;
                    }
                        
                }

            
            }
        }

    }


    public function show_base_node_folders(){

        

        global $wpdb;
        $repo_name =  $_GET['respository_name'];


        $repository_name = $wpdb->prefix .'default_alfresco_plugin_repositories';


        $node_folder_content = $wpdb->get_results($wpdb->prepare("SELECT * FROM $repository_name WHERE parent_name LIKE %s", '%'.$repo_name.'%' ));


        $permission_name = $wpdb->prefix .'default_alfresco_plugin_permissions';
        $parent_node = $wpdb->prefix .'default_alfresco_plugin_repositories_parent_node';


        $permissions_list = $wpdb->get_results("SELECT PerM.access_level , PerM.permission_name, ParentNode.node_name  FROM $permission_name  as PerM INNER JOIN $parent_node as ParentNode ON (ParentNode.access_level = PerM.permission_name)");



        return include_once plugin_dir_path( __FILE__ ) .'/partials/show-repository-content.php';

    }

    public function display_repository_page(){
        $repositories_node_list = [];
        $repositories_node_list_is_query_to_alfresco = false;
        global $wpdb;
        $parent_node = $wpdb->prefix .'default_alfresco_plugin_repositories_parent_node';
        $repositories_node_list = $wpdb->get_results("SELECT * FROM $parent_node");


        //get permission

        $permission_name = $wpdb->prefix .'default_alfresco_plugin_permissions';
        $permissions_list = $wpdb->get_results("SELECT * FROM $permission_name");


        if (count($repositories_node_list) == 0){
            $repositories_node_list_is_query_to_alfresco = true;
            $nodes =  wp_basealfrescopluginwordpress_render_node_content($this->plugin_name);
            $base_url = get_option($this->plugin_name."_url");


            if ($nodes){
                    foreach ($nodes['objects'] as $key => $value) {
                    $content = [];
                    foreach($value['object']['properties'] as $k => $v){

                            if ($k == "cmis:name"){ 
                                $url = $base_url .'/root/'.$v['value'];
                                $content = ['node_name' => $v['value'] , "node_url"=>$url];
                                $wpdb->insert($parent_node,$content);
                                $repositories_node_list[] = $content;
                            }
                        }
                }
            }

            

           
        }
        include_once 'partials/repositories-list.php';
    }



    public function update_node_folder_and_content_permission(){
            $content = ($_POST["content"]);
            global $wpdb;
            $repository_name = $wpdb->prefix .'default_alfresco_plugin_repositories';

            foreach ($content as $key => $value) {

               
                $wpdb->update($repository_name,$value,["id" =>intval($value['id'])]);
                
            }
    }


 }





?>