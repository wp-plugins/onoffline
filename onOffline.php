<?php
/**
 * @package onOffline
 * @version 0.2
 */
/*
Plugin Name: onOffline
Plugin URI: http://wordpress.org/plugins/onOffline/
Description: Handle internet disconnection of users.
Author: Plugin Builders
Version: 0.2
Author URI: http://plugin.builders/
*/

class WPB_onOffline{
	private $options;
	private $included = false;
	
	function __construct(){
		$this->getOptions();
		add_action('admin_menu', array($this, 'createMenu'));
		
		add_action('admin_enqueue_scripts', array($this, 'onOffScripts'));
		add_action('wp_enqueue_scripts', array($this, 'frontScripts'));
		
		add_action('wp_ajax_wpb_onoff_save', array($this, 'save'));
	}
	
	public function getOptions(){
		$this->options = get_option('wpb_onoff_options');
		
		if(sizeof($this->options) < 3){
			$this->options = array(
				'status' => '',
				'links' => 'on',
				'dashboard' => 'on',
				'notice' => 'on',
				'theme' => 'chrome',
				'language' => 'english'
			);
		}
		$this->options['css'] = WP_PLUGIN_URL.'/onOffline/css/';
	}
	
	public function createMenu(){
		add_submenu_page(
			'options-general.php',
			'onOffline',
			'onOffline',
			'manage_options',
			'onOffline',
			array($this, 'pageTemplate')
		);
	}
	
	public function pageTemplate(){ ?>
		<div class="wrap wpb-onoff-wrapper">
			<div id="icon-themes" class="icon32"></div>
			<h2 class="wpb-logo">onOffline</h2>
			<div id="wpb-onoff-wrapper">
				<div id="wpb-onoff-demo" class="pb-relativ">
					<div><label for="wpb-onoff-simulate"><b>Demo: </b></label><input id="wpb-onoff-simulate" type="checkbox"></input></div>
				</div>
			</div>
		</div>
		<?php
		$this->templates();
	}
	
	public function templates(){
		include 'templates/templates.php';
	}	
	
	public function dashScripts(){
		wp_register_script('wpb_offline', plugins_url('/js/offline.js', __FILE__), null, null, 1);
		wp_enqueue_script('wpb_offline');
		wp_register_script('wpb_onOffline', plugins_url('/js/onOffline.js', __FILE__), array('jquery', 'wpb_offline'), null, 1);
		wp_enqueue_script('wpb_onOffline');
		wp_localize_script('wpb_onOffline', 'wpb_onoff_options', $this->options);
		wp_register_style('wpb_onoff_style', plugins_url('/css/style.css', __FILE__));
		wp_enqueue_style('wpb_onoff_style');
				
		$this->included = true;
	}
		
	public function onOffScripts($hook){
		if(isset($this->options['dashboard'])) $this->dashScripts();
		
		if($hook == 'settings_page_onOffline'){
			if(!$this->included)  $this->dashScripts();
			
			wp_register_script('wpb_onoff_settings', plugins_url('/js/settings.js', __FILE__), array('underscore'), null, 1);
			wp_enqueue_script('wpb_onoff_settings');
			wp_register_script('wpb_onoff_simulate', plugins_url('/js/simulate.js', __FILE__), array('wpb_offline'), null, 1);
			wp_enqueue_script('wpb_onoff_simulate');
		}		
	}
	
	public function frontScripts(){
		if(!isset($this->options['status']) || !$this->options['status']) return false;
		
		wp_register_script('wpb_offline', plugins_url('/js/offline.js', __FILE__), null, null, 1);
		wp_enqueue_script('wpb_offline');
		wp_register_script('wpb_onOffline', plugins_url('/js/onOffline.js', __FILE__), array('jquery'), null, 1);
		wp_enqueue_script('wpb_onOffline');
		wp_localize_script('wpb_onOffline', 'wpb_onoff_options', $this->options);
		wp_register_style('wpb_onoff_style', plugins_url('/css/style.css', __FILE__));
		wp_enqueue_style('wpb_onoff_style');
	}
	
	/**
	 * stores input types,  not listed ones are supposed to be strings.
	 *
	*/
	public $fields = array(
	
	);
	
	
	public function save(){
		$d = $_POST['onoff_data'];
		$d = $this->validate($d);
		
		wp_send_json(update_option('wpb_onoff_options', $d));
	}
	
	public function validate($ins, $object = false){
		$rins = array();
		foreach($ins as $key=>$value){
			$rins[$key] = $this->cleanse(
				( array_key_exists($key, $this->fields) ? $this->fields[$key] : 'string' ),
			$value);
		}
		return $object ? (object)$rins : $rins;
	}
	
	public function cleanse($type, $value){
		switch($type){
			case 'int':
				return intval($value);
				break;
			case 'url':
				return esc_url($value);
				break;
			default:
				return sanitize_text_field($value);
				break;
		} 
	}
	
} 

new WPB_onOffline();
?>