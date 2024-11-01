<?php
/*   
 Plugin Name: WPPM Google Webmaster Tools
 Plugin URI: https://wordpress.org/plugins/wppm-google-webmaster-tools
 Description: Google Webmaster verification Tools for your Wordpress websites & blogs.
 Version: 1.0                      
 Author: Pradeep Maurya                    
 Author URI: http://www.pradeepmaurya.in/about-us                                         
 License: GPL3                                                                                                                                     
 */
 
define('wppm_blog_name',get_bloginfo('name'));                                                                                                             
define('wppm_site_url',get_site_url());                                                                                                                                                              
define('wppm_plugin_url',plugins_url( '/', __FILE__ ));
                                                   
if (!class_exists('wppm_GOOGLE_WEBMASTER_TOOLS')) {    
	                                       
	class wppm_GOOGLE_WEBMASTER_TOOLS {                                                         
		                                                                                               
		function __construct() {                
			              
			add_action('admin_menu', array($this, 'wppm_menu'));            
			    
			add_action('wp_head', array($this, 'wppm_add_webmaster_head'),2);             
			
			/* register activation hook */   
			register_activation_hook( __FILE__, array($this, 'wppm_activate') );        
			         
			/* register deactivation hook */ 
			register_deactivation_hook( __FILE__, array($this, 'wppm_deactivate') ); 

		}  

	function wppm_menu() {
		
		add_options_page( 'Webmaster Tools','Google Webmaster Tools','manage_options','wppm-google-webmaster-tools', array( $this, 'wppm_webmaster_tools_settings_page' ) );
		
		add_action( 'admin_init', array($this, 'wppm_settings') );
		
	}
	/* register settings */
	function wppm_settings() { 
	
		register_setting( 'wppm-webmasters-settings-group', 'wppm_google_webmaster_code');
		register_setting( 'wppm-webmasters-settings-group', 'wppm_bring_webmaster_code');
		register_setting( 'wppm-webmasters-settings-group', 'wppm_alexa_varify_code');
		
	}
	
	/* add default setting values on activation */
	function wppm_activate() { 
		add_option( 'wppm_google_webmaster_code', '', '', '' );
		add_option( 'wppm_bring_webmaster_code', '', '', '' );
		add_option( 'wppm_alexa_varify_code', '', '', '' );
	}
	
	/* delete setting and values on deactivation */
	function wppm_deactivate() { 
		delete_option( 'wppm_google_webmaster_code');
		delete_option( 'wppm_bring_webmaster_code');
		delete_option( 'wppm_alexa_varify_code');
	}

	function wppm_add_webmaster_head(){
		
		$wppm_code = '';
		
		$wppm_code .= "\n\n".'<!-- wppm Google Webmaster Tools v1.0 - https://wordpress.org/plugins/wppm-google-webmaster-tools/ -->' . "\n";
		
		$wppm_code .= '<!-- Website - http://www.pradeepmaurya.in/ -->' . "\n";
		
		if(get_option('wppm_google_webmaster_code')){
		  $wppm_code .= '<meta name="google-site-verification" content="'. get_option('wppm_google_webmaster_code') .'" />'. "\n";
		}
		
		if(get_option('wppm_bring_webmaster_code')){
		  $wppm_code .= '<meta name="msvalidate.01" content="'. get_option('wppm_bring_webmaster_code') .'" />'. "\n";
		}
		
		if(get_option('wppm_alexa_varify_code')){
		  $wppm_code .= '<meta name="alexaVerifyID" content="'. get_option('wppm_alexa_varify_code') .'" />'. "\n";
		}
		
		
		
		$wppm_code .= '<!-- / wppm Google Webmaster Tools plugin. -->'.  "\n\n";
		
		echo $wppm_code;
		
	}
		
  function wppm_webmaster_tools_settings_page(){
	 
 ?>

<div class='wrap'> 
	<h1><?php _e('wppm Google Webmaster Tools', 'pradeepmaurya'); ?></h1>
	
	<p class="description"><?php _e('Google Webmaster Tools provides reports and data that can help you understand how different pages on your website are appearing in search results.', 'pradeepmaurya'); ?></p>

	<?php include('social-media.php'); ?>

	<?php
	$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'webmaster_settings';
	if(isset($_GET['tab'])) $active_tab = $_GET['tab'];
	?>
	
		<?php if($active_tab == 'webmaster_settings') { ?>
		
		 <form method="post" action="options.php">

		<?php settings_fields('wppm-webmasters-settings-group'); ?>
		<?php do_settings_sections('wppm-webmasters-settings-group'); ?>
		
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
			<h3><?php _e('Webmaster Tools Settings', 'pradeepmaurya'); ?></h3>
			<div class="inside">
				<p><?php _e('You can use the boxes below to verify with the different Webmaster Tools, if your site is already verified, you can just forget about these. Enter the verify meta values for:', 'pradeepmaurya'); ?></p>
				
			<table class="form-table">
			
				 <tr valign="top">
					  <th scope="row" style="width: 190px;"><label class="checkbox" for="wppm_google_webmaster_code"><?php _e('Google Webmaster Tools', 'pradeepmaurya'); ?>:</label></th>
					  <td>
						  <input id="wppm_google_webmaster_code" type="text" name="wppm_google_webmaster_code" value="<?php echo get_option('wppm_google_webmaster_code') ?>" size="50" />
					 </td>
				 </tr>
				 
				 <tr valign="top">
					  <th scope="row" style="width: 190px;"><label class="checkbox" for="wppm_bring_webmaster_code"><?php _e('Bing Webmaster Tools', 'pradeepmaurya'); ?>:</label></th>
					  <td>
						  <input id="wppm_bring_webmaster_code" type="text" name="wppm_bring_webmaster_code" value="<?php echo get_option('wppm_bring_webmaster_code') ?>" size="50" />
					 </td>
				 </tr>
				 
				 <tr valign="top">
					  <th scope="row" style="width: 190px;"><label class="checkbox" for="wppm_alexa_varify_code"><?php _e('Alexa Verification ID', 'pradeepmaurya'); ?>:</label></th>
					  <td>
						  <input id="wppm_alexa_varify_code" type="text" name="wppm_alexa_varify_code" value="<?php echo get_option('wppm_alexa_varify_code') ?>" size="50" />
					 </td>
				 </tr>
				 
				 <tr valign="top">
					  <td colspan="2">
						  <div class="wppm_sep"></div>
					 </td>
				 </tr>
				 
				<tr valign="top" align="left">
					<td class="frm_wp_heading"><?php submit_button(); ?></td>
					
				</tr>
		
			</table>
				
			</div>
			</div>
		</div>
		</form>

		<?php } ?>
		
		
		
		
	</div>

	<?php
	
	 }

	}

}

if (class_exists('wppm_GOOGLE_WEBMASTER_TOOLS')) {
	$wppm_GOOGLE_WEBMASTER_TOOLS = new wppm_GOOGLE_WEBMASTER_TOOLS();
}
?>