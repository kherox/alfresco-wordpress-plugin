<?php 

       $data = wp_basealfrescopluginwordpress_render_node_content($this->plugin_name);
		
		
		$metabox = get_post_meta(get_the_ID(), $this->plugin_name."_meta_attach_page", true);

		
        
        //wp_tresor_debug($data['objects'] );
		echo "<optiongroup>";
		if ($data){
				foreach ($data['objects'] as $key => $value) {
				foreach($value['object']['properties'] as $k => $v){

					if ($k == "cmis:name" && !empty($metabox) && $v['value'] == $metabox){
						echo "<input type='radio' checked  value=".$v['value']." name=".$this->plugin_name."_meta_attach_page />".$metabox."<br><br>";
			
					}
					
						if ($k == "cmis:name" && $v['value'] != $metabox){
						
							echo "<input type='radio'  value=".$v['value']." name=".$this->plugin_name."_meta_attach_page />".$v['value']."<br><br>";
						}
				}
			}
		}
		
        echo "</optiongroup>";


?>