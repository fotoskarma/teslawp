// SLIDER \\_______________________________________________________________________________________________________________________________________________

(function($){

    $(function(){

		$('.tesla-option-multiple').sortable({
			axis: "y",
			containment: "parent",
			cursor: "move",
			items: '.tesla-option-container',
			handle: '.tesla-slide-image',
			placeholder: "tesla_image_holder",
			forcePlaceholderSize: true
		});

		/*$('#slide_options').on('click','.tesla-select-image',function(event){

			//event.stopPropagation();
			//event.preventDefault();

			var t = $(this).parent();

		});*/
		
		$('#slide_options').on('click','.tesla-select-image',function(event){

			//event.stopPropagation();
			//event.preventDefault();

			//return;

			var t = $(this);
			var t_parent = t.closest('.tesla-option-container');
			var frame = t.data('frame');
			if(frame===undefined){
				frame = wp.media();
				t.data('frame',frame);
				frame.on('select',function(){
					var url = frame.state().get('selection').first().toJSON().url;
					t_parent.children('input[type="hidden"]').prop('value',url);
					t_parent.find('.tesla-image-holder').removeAttr('style');
					t_parent.find('.tesla-image-holder img').prop('src',url);
					t_parent.find('.tesla-image-default').css({display:'none'});
					t_parent.find('.tesla-remove-image').removeAttr('style');
				});
			}
			
			frame.open();
			
		});
		
		$('#slide_options').on('click','.tesla-remove-image',function(event){

			//event.stopPropagation();
			//event.preventDefault();

			//return;

			var t = $(this);
			var t_parent = t.closest('.tesla-option-container');
			var t_container = t_parent.parent();
			if(t_container.hasClass('.tesla-option-multiple'));
			t_parent.find('input[type="hidden"]').prop('value','');
			t_parent.find('.tesla-image-holder').css({display:'none'});
			t_parent.find('.tesla-image-holder img').prop('src','');
			t_parent.find('.tesla-image-default').removeAttr('style');
			t_parent.find('.tesla-remove-image').css({display:'none'});
			
		});
		
		$('#slide_options').on('click','.tesla-add-image',function(event){

			var t = $(this);
			var t_parent = t.closest('.tesla-option-multiple');
			var t_template = t_parent.find('.tesla-option-template').html();

			var frame = t.data('frame');
			if(frame===undefined){
				frame = wp.media();
				t.data('frame',frame);
				frame.on('select',function(){
					var url = frame.state().get('selection').first().toJSON().url;
					var t_clone = $('<div>').addClass('tesla-option-container').html(t_template);
					t_clone.children('input[type="hidden"]').prop('disabled',false).prop('value',url);
					t_clone.find('.tesla-image-holder img').prop('src',url);
					t_parent.find('.tesla-option-template').before(t_clone);
				});
			}
			
			frame.open();
			
		});
		
		$('#slide_options').on('click','.tesla-delete-image',function(event){

			$(this).closest('.tesla-option-container').remove();
			
		});

    });

})(jQuery);