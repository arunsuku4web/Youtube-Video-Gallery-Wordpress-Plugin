jQuery(document).ready(function () 
{
 
 
  function slideout(){
  setTimeout(function(){
  jQuery("#response").slideUp("slow", function () {
      });
    
}, 2000);}
	
    jQuery("#response").hide();
	jQuery(function() {
	jQuery("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
		
		
		
		
			var order = jQuery(this).sortable("serialize") + '&update=update&action=YGVideoSorting'; 
			jQuery.post(ajaxurl, order, function(theResponse){
			
				jQuery("#response").html(theResponse);
				jQuery("#response").slideDown('slow');
				slideout();
			}); 															 
		}								  
		});
	});
	
	
	
	
jQuery('.editvideo').click(function() 
{
	
	
	jQuery('.alert-success').hide();
	var ppath=jQuery('#plpath').val();
	var pid=this.id;
	jQuery('#pload'+this.id).html('<img src="'+ppath+'" />Please wait....');
	jQuery('#pload'+this.id).fadeIn("slow");
	
	var videotitle=jQuery('#ytitle'+this.id).val();
	var videodescription=jQuery('#ydesc'+this.id).val();
	var mydata ='videotitle='+videotitle+'&videodescription='+videodescription+'&vid='+this.id+'&action=YGEditVideo';
	 
	  
	 
	
	 jQuery.ajax({
     url: ajaxurl,
     data:mydata ,
     success: function(theResponse) 
	 { 
	
	 if(theResponse=="success")
	 {
		
	 jQuery('#pload'+pid).html('Updated Successfully');
	 }
	 }
	  
	  });
	
	
});
jQuery('.deletevideo').click(function() 
{
	
	
	jQuery('.alert-success').hide();
	var ppath=jQuery('#plpath').val();
	var pid=this.id;
	jQuery('#pload'+this.id).html('<img src="'+ppath+'" />Please wait....');
	jQuery('#pload'+this.id).fadeIn("slow");
	

	var mydata ='vid='+this.id+'&action=YGDeleteVideo';
	
	
	jQuery.ajax({
     url: ajaxurl,
     data:mydata ,
     success: function(theResponse) 
	 { 
	
	 if(theResponse=="success")
	 {
		
	 jQuery('#pload'+pid).html('Video deleted successfully');
	 
	 jQuery('#arrayorder_'+pid).fadeToggle("slow");
	 
	 
	 }
	 }
	  
	  });
	
});		
});