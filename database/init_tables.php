<?php 
global $wpdb;


$charset_collate = $wpdb->get_charset_collate();

$permission_name = $wpdb->prefix .'default_alfresco_plugin_permissions';

//DROP TABLE $table_name;

$permission =  " CREATE TABLE  $permission_name (
    id int not null auto_increment,
    permission_name varchar(50),
    access_level varchar(100),
    access_restricted_password varchar(100) null,
    primary key (id)
    
     ) $charset_collate;";




$repository_name = $wpdb->prefix .'default_alfresco_plugin_repositories';

$repository =  "CREATE TABLE  $repository_name (
    id int not null auto_increment,
    parent_name varchar(100),
    children_name varchar(100),
    full_url varchar(250),
    filetype varchar(50),
    access_level varchar(50),
    permission_name varchar(50),
    primary key (id)
    
     ) $charset_collate;";

$repository_counter = $wpdb->prefix .'default_alfresco_plugin_repositories_counter';

$rcounter =  " CREATE TABLE  $repository_counter (
    id int not null auto_increment,
    node_name varchar(100),
    folder_count int ,
    lastname varchar(250) null,
    primary key (id)
    
     ) $charset_collate;";


$parent_node = $wpdb->prefix .'default_alfresco_plugin_repositories_parent_node';

$parent_nodes =  " CREATE TABLE  $parent_node (
    id int not null auto_increment,
    node_name varchar(100),
    node_url varchar(250) ,
    access_level varchar(50) ,
    primary key (id)
    
     ) $charset_collate;";



require_once(ABSPATH.'wp-admin/includes/upgrade.php');

dbDelta($permission);
dbDelta($repository);
dbDelta($rcounter);
dbDelta($parent_nodes);








?>