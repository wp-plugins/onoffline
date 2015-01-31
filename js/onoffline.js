jQuery(document).ready(function($){
	var  WPB = {};
	WPB.options = wpb_onoff_options;
		
	WPB.changeTheme = function(theme, lang){
		$('head link.wpb-onoff-style').remove();
		lang = theme.indexOf('indicator') > 0 ? lang+'-indicator' : lang;
		$('head').append('<link rel="stylesheet" href="'+WPB.options.css+'themes/'+theme+'.css'+'" type="text/css" class="wpb-onoff-style wpb-onoff-theme"></link>');
		$('head').append('<link rel="stylesheet" href="'+WPB.options.css+'langs/'+lang+'.css'+'" type="text/css" class="wpb-onoff-style wpb-onoff-language"></link>');
		if(!WPB.options.notice) $('.offline-ui').addClass('pb-force-hide');
	};
	
	WPB.intercept = function(){
	
		$(document).on('click', 'a', function(e){
			if(Offline.state === 'down') e.preventDefault();	
		});
		
		$(document).on('submit', 'form', function(e){
			if(Offline.state === 'down') e.preventDefault();	
		});
		
	};
	
	Offline.options = {
		interceptsRequests: true,
		reconnect : {
			initialDelay: 2,
			delay:2
		},
		requests: true
	};
		
	WPB.intercept();
	WPB.changeTheme(WPB.options.theme, WPB.options.language);
});