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

  <?php
  
  
  $data =  wp_basealfrescopluginwordpress_render_node_content($this->plugin_name);

?>
<ul>

<table class="wp-list-table widefat table-bordered fixed striped users">
<thead>
  <tr>
  
   <th>Name</th>
   <th>Option</th>
   <th>Permission</th>
   <th>Save</th>
   <th>Link</th>
  </tr>
</thead>
<tbody>

<?php if(!$repositories_node_list_is_query_to_alfresco ) : ?>
    <?php foreach ($repositories_node_list as $key => $v) : ?>
        <tr>
        <td><?= $v->node_name ?></td>
        <td>  <button type="submit" onclick="load_repository_content('<?= $v->node_name ?>')" class="button button-primary">Load Content</button></td>
         <td>
            <select name="permission" id="permission_attach_to_node_<?= $v->node_name ?>">
            
              <?php foreach($permissions_list as $k =>$p) : ?>
                  <?php if ($v->access_level && $v->access_level == $p->permission_name) :  ?>
                      <option selected value="<?= $v->access_level ?>"><?= $v->access_level ?></option>
                  <?php else :  ?>
                  <option  value="<?= $p->permission_name ?>"><?= $p->permission_name ?></option>
                  <?php endif ?>
              
              <?php endforeach ?>
            </select>
         </td>
         <td>  <button type="submit" onclick="save_permission_attach_to_node('<?= $v->node_name ?>',<?= $v->id ?>)" class="button button-danger">Update Permission</button></td>
          <td><a href="?page=show-repository-content&respository_name=<?=$v->node_name?>" class="button button-primary">Show content</a></td>
        </tr>
    <?php endforeach ?>
<?php else : ?>
<?php foreach ($repositories_node_list as $key => $v) : ?>
        <tr>
        <td><?= $v['node_name'] ?></td>
        <td>  <button type="submit" onclick="load_repository_content('<?= $v['node_name'] ?>')" class="button button-primary">Load Content</button></td>
        </tr>
    <?php endforeach ?>
<?php endif  ?>




</tbody>
</table>
    
</div>
