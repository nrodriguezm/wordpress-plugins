
// Create a new object for custom validation of a custom field.
var myCustomFieldController = Marionette.Object.extend( {
    initialize: function() {
		
		setTimeout(function(){
			var signaturePad = [];
			var canvas = [];
			jQuery('canvas').each(function(index){
				var canvas_id = jQuery(this).attr("id");
				signaturePad[canvas_id] = 0;
				jQuery( document ).on('mouseenter', '.ds_canvas-'+canvas_id, function() {
					if(signaturePad[canvas_id] == 0){
						canvas[canvas_id] = jQuery(this).get(0);
						signaturePad[canvas_id] = new SignaturePad(canvas[canvas_id]);
					}
				});
				
				jQuery(document).on('mouseup mouseleave', '.ds_canvas-'+canvas_id, function(){
					jQuery('.ds_img_data_url-'+canvas_id).val(signaturePad[canvas_id].toDataURL()); 
				});
				
				jQuery(document).on('click', '.clear-'+canvas_id, function(){
					signaturePad[canvas_id].clear();
					jQuery('.ds_img_data_url-'+canvas_id).val("");
				});
			});
		}, 100);
		/*
		var signaturePad = 0;
	
		jQuery( document ).on('mouseenter', 'canvas', function() {
			if(signaturePad == 0){
				var canvas = jQuery(".ds_canvas").get(0);
				signaturePad = new SignaturePad(canvas);
			}
		});
		
		jQuery(document).on('mouseup mouseleave', 'canvas', function(){
			jQuery('.ds_img_data_url').val(signaturePad.toDataURL()); 
		});

		jQuery(document).on('click', '.clear', function(){
			signaturePad.clear();
			jQuery('.ds_img_data_url').val("");
		});
		
        this.listenTo( Backbone.Radio.channel( 'forms' ), 'submit:response', this.createImg );
		*/
    },

    createImg: function( view ) {
		//this.signaturePad.toDataURL()
    }
});

// On Document Ready...
jQuery( document ).ready( function( $ ) {

    // Instantiate our custom field's controller, defined above.
    new myCustomFieldController();
});

