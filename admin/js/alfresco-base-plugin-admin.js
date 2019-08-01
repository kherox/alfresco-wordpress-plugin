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


	$('#tresoralfresco_permission_access_level_restricted').on("click",function(e){
		
		// var elt = document.getElementById("tresoralfresco_permission_access_level_restricted");
		// 	elt.onclick = function(e){
		// 		if(e.target.checked){
		// 			document.getElementById("_permission_access_level_restricted_password").style.display = "block"

		// 		}else{
		// 			document.getElementById("_permission_access_level_restricted_password").style.display = "none"

		// 		}
		// 	}

		
	});

	$("#cb-checkbox-all-repository").on("click",function(){
			
		$('input[id=cb-select-repository]').prop('checked',$(this).prop('checked'));
	})

	$("#doaction-select-repository").on("click",function(){

		if ($("#cb-select-all-repository").val() == 2){
			$('input[id=cb-select-repository]').prop('checked',true);
		}

		if ($("#cb-select-all-repository").val() == 3){
			$('input[id=cb-select-repository]').prop('checked',false);
		}
			
		
	})


	$('#load-all-content-button-alfresco').on("click",function(e){


		var data = {
			action : "fetch_repository_content",
		}

		$.post(ajaxurl,data,function(res){ console.log(res)});
	})



	//update folder permission

	$("#permission-validate-button").on("click",function(e){
		var docs = document.querySelectorAll("#access_level");

		var content = []

		docs.forEach(elt => {
			var l = elt.value.split("_");

			content.push({
				"access_level" : l[0],
				//"node_name" : l[1],
				"id" : l[2],
				"permission_name" : l[3],
			})
		})

		var data = {
			action : 'update_node_folder_and_content_permission',
			content : content
		}

		$.post(ajaxurl,data,function(res){ console.log(res)});
	});


	
});
	



})( jQuery );



function fetch_repository_content(folder,node_name){

	var data = {
		action : "fetch_repository_content",
		folder : folder,
		node_name : node_name
	}

	// var oReq = new XMLHttpRequest();
	// oReq.open("POST",ajaxurl,true);
	// oReq.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
	// formData = new FormData();
	// formData.append("data",data);
	// oReq.send(formData);

	jQuery.post(ajaxurl,data,function(res){ console.log(res)});

	
}


function load_repository_content(node_name){

	var data = {
		action : "load_repository_content",
		node_name : node_name
	}

	jQuery.post(ajaxurl,data,function(res){ console.log(res)});

	
}

function save_permission_attach_to_node(node_name , id){

	var data = {
		action : "save_permission_attach_to_node",
		node_name : node_name ,
		id : id,
		access_level : jQuery("#permission_attach_to_node_"+node_name).val()
	}
	


	jQuery.post(ajaxurl,data,function(res){ console.log(res)});

}
