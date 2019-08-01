


(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	//  $('#tresoralfresco_permission_access_level_restricted').on('click', function(){
	// 	 console.log(this);
	// 	 alert()

	//  })


	//  $('#_permission_access_level_restricted').cheched(function(){
    //     console.log(this.value)
	//  });

	
$( window ).load(function() {


});

})( jQuery );



function donwload_document_with_link(btn,url,name,id,fullname){

    
    btn.style.display = 'none';
    data = {
        action : 'donwload_document_with_link',
        url,
        name
    }
    jQuery.post("/wordpress/wp-admin/admin-ajax.php",data,function(e){
        link = "http://192.168.1.134/wordpress/wp-content/uploads/tresoralfresco/"+fullname;
        jQuery("#"+id).attr("href",link).show();
    });
}