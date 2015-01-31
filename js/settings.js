jQuery(document).ready(function($){
	WPB = {};
			
	WPB.post = function(data, success, error){
		$.ajax({
			url: 'admin-ajax.php',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: success,
			error: error
		});
	};
	
	WPB.template = function(selector){
		return _.template($(selector).html());
	};
	
	WPB.form = function(form){
		var o = {};
		var inputs = $(form).serializeArray();
		$.each(inputs, function() {
			if (o[this.name] !== undefined) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});
		inputs = $(form).find('input[type="checkbox"]');
		$.each(inputs, function(){
			o[this.name] = o[this.name] ? o[this.name] : '';
		});
		return o;
	};
		
	function onOff(){
		WPB.options = wpb_onoff_options;
		
		$('#wpb-onoff-wrapper').prepend(WPB.template('#wpb-onoff-tmpl')(WPB.options));
		
		events();
				
		function events(){
			function changeTheme(theme, lang){
				$('head link.wpb-onoff-style').remove();
				lang = theme.indexOf('indicator') > 0 ? lang+'-indicator' : lang;
				$('head').append('<link rel="stylesheet" href="'+WPB.options.css+'themes/'+theme+'.css'+'" type="text/css" class="wpb-onoff-style wpb-onoff-theme"></link>');
				$('head').append('<link rel="stylesheet" href="'+WPB.options.css+'langs/'+lang+'.css'+'" type="text/css" class="wpb-onoff-style wpb-onoff-language"></link>');
			}
			
			function changeLanguage(lang){
				$('head link.wpb-onoff-language').remove();
				$('head').append('<link rel="stylesheet" href="'+WPB.options.css+'langs/'+lang+'.css'+'" type="text/css" class="wpb-onoff-style wpb-onoff-language"></link>');
			}
			
			function handlers(){
				$('body').on('change', 'select#onoff-theme', function(e){
					changeTheme($(this).val(), $('select#onoff-language').val());
				});
				
				$('body').on('change', 'select#onoff-language', function(e){
					changeLanguage($('select#onoff-theme').val().indexOf('indicator') ? $(this).val()+'-indicator' : $(this).val());
				});
				
				$('body').on('change', 'input#onoff-notice', function(e){
					if($(this).attr('checked')){
						$(this).parents('tr').nextAll('tr').removeClass('pb-hidden');
						$('.offline-ui').removeClass('pb-force-hide');
					}	
					else {
						$(this).parents('tr').nextAll('tr').addClass('pb-hidden');
						$('.offline-ui').addClass('pb-force-hide');
					}	
				});
					
				$('body').on('click', '#wpb-onoff-simulate', function(){
					$('.offline-simulate-ui input').trigger('click');
				});
				
				$('body').on('submit', '#wpb-onoff-form', function(e){
					e.preventDefault();
					var button = $(this).children('.button');
					button.text('Saving...');
					WPB.post({'action': 'wpb_onoff_save', 'onoff_data': WPB.form(this)}, function(re){
						button.text('Save Changes');
					});
				});
				
				window.setTimeout(function(){
					if(!WPB.options.notice) $('.offline-ui').addClass('pb-force-hide');
				}, 1000);
			}
			
			handlers();
		}
	}	
	
	onOff();
	
});