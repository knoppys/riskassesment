jQuery(document).ready(function(){
	jQuery( "a.dropdown-item.drop-down-header" ).click(function( event ) {
  		event.preventDefault();
  	});
	jQuery('.registerlink a').on('click',function(){
		jQuery('#loginform').hide();
		jQuery('.registerlink a').hide();
		jQuery('#registerform').fadeIn();

	});
	jQuery('.dropdown-toggle').dropdown()
});