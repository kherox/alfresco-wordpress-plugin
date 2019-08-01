
<div class="wrap">

<h1 class="wp-heading-inline">Liste des permissions</h1>
<a href="?page=create-permission-page" class="page-title-action">Ajouter</a>


<hr class="wp-header-end">

<table class="wp-list-table widefat fixed striped users">
<thead>
  <tr>
   <th>Role</th>
   <th>Permission</th>
   <th>Pass</th>
  </tr>
</thead>

<tbody>


<?php foreach($permission_name_list as $pk => $v) :?>
<tr> 
  <td> <?= ($v->permission_name) ?></td>
  <?php $access = explode(";",$v->access_level); ?>
  <td> <?= str_replace(";"," ",$v->access_level); ?></td>

   <?php  if (in_array("restricted",$access)) : ?>
   <td> <?= $v->access_restricted_password ?> </td>
   <?php  endif; ?>
</tr>
<?php endforeach; ?>


</tbody>

</table>
</div>