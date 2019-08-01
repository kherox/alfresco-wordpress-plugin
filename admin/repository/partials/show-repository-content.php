<?php  


if (isset($_GET['respository_name']) && !empty($_GET['respository_name'])) {
    ?>

  
       
    




<div class="wrap">

<h1 class="wp-heading-inline">Detail for <?= $_GET['respository_name'] ?> repository</h1>


<hr class="wp-header-end">
<div class="tablenav top">
 <div class="alignleft actions bulkactions">
    
  <?php if (count($node_folder_content) > 0) :?>
  <input type="submit" id="permission-validate-button" class="button button-primary" value="Valider les permissions">
  <?php endif ?>
 </div>

</div>

<table class="wp-list-table widefat fixed striped users">
  <thead>
    <tr>
    <td id="cb" class="manage-column column-cb check-column">
    <input type="checkbox" id="cb-checkbox-all-repository"> </td>
    <th>Axe</th>
    <th>Filename</th>
    <th>Access</th>
    <th>Group</th>
    </tr>
  </thead>

  

  <tbody id="the-list">
    <?php foreach($node_folder_content as $k => $v) : ?>
      <tr>
          <td><input type="checkbox" id="cb-checkbox-all-repository"></td>
          <td><?= ($v->parent_name); ?></td>
          <td><?= $v->children_name ?></td>
          <td>
             <?php  $base_name = explode("/",$v->parent_name)[0]  ?>
            
             <?php  foreach($permissions_list as $ks => $vs) :  ?>
             <?php  if ($base_name == $vs->node_name) : ?>
                  <?php $access_levels = explode(";",$vs->access_level) ?>
                  <select name="" id="access_level">
                      <?php foreach($access_levels as $cs => $lev) : ?>
                      <?php if ($v->access_level && $v->access_level == $lev): ?>
                      <option selected value="<?= $lev.'_'.$base_name.'_'.$v->id.'_'.$vs->permission_name ?>"><?= $lev ?></option>
                      <?php else : ?>
                      <option value="<?= $lev.'_'.$base_name.'_'.$v->id.'_'.$vs->permission_name ?>"><?= $lev ?></option>
                      <?php endif?>
                      <?php endforeach?>
                  </select>
             <?php  endif ?>
             <?php  endforeach  ?>
          </td>

          <td> <?= $v->permission_name ?> </td>
      </tr>
    <?php endforeach ?>
  </tbody>

</table>
</div>

<?php } ?>

        