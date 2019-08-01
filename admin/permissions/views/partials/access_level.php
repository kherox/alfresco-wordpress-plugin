<div class="components-panel">
            <div class="components-panel_row">
            <input type="checkbox" 
               name="<?php echo $this->plugin_name . '_permission_access_level_public' ?>" 
               id="<?php echo $this->plugin_name . '_permission_access_level_public' ?>"> public
            </div>
            <div class="components-panel_row">
                <input type="checkbox" 
                    name="<?php echo $this->plugin_name . '_permission_access_level_private' ?>" 
                id="<?php echo $this->plugin_name . '_permission_access_level_private' ?>"> private
            </div>

            <div class="components-panel_row">
                <input type="checkbox" 
                    name="<?php echo $this->plugin_name . '_permission_access_level_restricted' ?>" 
                id="<?php echo $this->plugin_name . '_permission_access_level_restricted' ?>"> restricted
            </div>

           

            <div class="components-panel_row">
                <input type="checkbox" 
                    name="<?php echo $this->plugin_name . '_permission_access_level_close' ?>" 
                id="<?php echo $this->plugin_name . '_permission_access_level_close' ?>"> close
            </div>
               
            </div>