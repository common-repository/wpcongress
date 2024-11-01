        // wait for the DOM to be loaded 
 jQuery(document).ready(function() { 
     //	data: jQuery("#wpcongress-form").serialize()
     // bind 'myForm' and provide a simple callback function
	var options = { 
    target:     '#wpcongress-form', 
    url:        'wp-admin/admin-ajax.php', 
    data: 		{ action: 'myajax-submit'}    };
    jQuery('#wpcongress-form').ajaxForm(options); 
    
   	}); 