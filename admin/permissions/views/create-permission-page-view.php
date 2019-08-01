
<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://majestic.com.au
 * @since      0.1.0
 *
 * @package    TresorAlfresco
 * @subpackage TresorAlfresco/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post"  autocomplete="on">
    <input type="hidden" name="default_alfresco_plugin_add_permission_form" value="<?=$this->plugin_name.'_permission' ?>">
        <?php
	       settings_fields( $this->plugin_name.'_permission' );
	       do_settings_sections( $this->plugin_name.'_permission' );
	       submit_button();
	    ?>
    </form>
</div>

<?php 

if ($_POST){
    die();
}

?>