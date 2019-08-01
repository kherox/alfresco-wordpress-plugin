<table class="table"> 
<thead>
    <tr>
        <th>Filename</th>
        <th>Extension</th>
        <th>Download</th>
    </tr>
</thead>
<tbody>
<?php foreach($repository_node_content as $k =>$v) : ?>
    <?php if ($v->access_level =="public") : ?>
    <?php $res =  explode(".",$v->children_name);?>
    <?php $id = $res[0].'_'.$k ?>
    <tr> 
      <td><?= $res[0] ?></td>
      <td><?php  echo $res[count($res)-1] ?></td>
      <td>
      <button onclick="donwload_document_with_link(this,'<?= $v->full_url ?>','<?= $res[0] ?>','<?= $id ?>','<?= $v->children_name ?>')"  class="search-submit">Consulter</button>
      <a href="#" id="<?=$id ?>" target="_blank" style="display:none;">Telecharger</a>
      </td>
    </tr>
    <?php endif ?>
<?php endforeach ?>  
</tbody>
</table>

