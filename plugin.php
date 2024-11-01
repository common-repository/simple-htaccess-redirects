<?php
/**
* Plugin Name: Simple Htaccess Redirects
* Description: Updates your htaccess file with the correct redirect/header code
* Version: 1.5.8
* Author: PackerlandWebsites
* Author URI: https://www.packerlandwebsites.com
 *
 */


 /*  Copyright 2018-2019  Mike (email : mike@packerlandwebsites.com)

     This program is free software; you can redistribute it and/or modify
     it under the terms of the GNU General Public License as published by
     the Free Software Foundation; either version 2 of the License, or
     (at your option) any later version.

     This program is distributed in the hope that it will be useful,
     but WITHOUT ANY WARRANTY; without even the implied warranty of
     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     GNU General Public License for more details.

		 You should have received a copy of the GNU General Public License
		 along with this program; if not, write to the Free Software
		 Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/*
 * Plugin constants
 */
if(!defined('PK_REDIRECT_URL'))
 define('PK_REDIRECT_URL', plugin_dir_url( __FILE__ ));
if(!defined('PK_REDIRECT_PATH'))
 define('PK_REDIRECT_PATH', plugin_dir_path( __FILE__ ));

/*
 * Main class
 */
/**
 * Class Redirect
 *
 * This class creates the option page and add the web app script
 */


class PKRedirect
{

		/**
		 * Redirect constructor.
		 *
		 * The main plugin actions registered for WordPress
		 */
		public function __construct()
		{
			$plugin = plugin_basename( __FILE__ );

			add_filter( "plugin_action_links_" . $plugin , array( $this,'pk_plugin_add_settings_link') );
			add_action('admin_menu', array( $this, 'PK_plugin_menu'));
			add_action( 'admin_init', array( $this, 'PK_plugin_settings' ));
			add_action( 'wp_head', array( $this, 'PK_headscript' ));
			
			add_action( 'wp_ajax_PK_reset', array($this, 'PK_reset'));
			add_action( 'wp_ajax_PK_scan_working_urls', array($this, 'PK_scan_working_urls'));
            add_action( 'wp_ajax_PK_404_capture', array($this, 'PK_404_capture'));
            add_action( 'wp_ajax_PK_remove_active_redirect', array($this, 'PK_remove_active_redirect'));

			//add_action( 'register_deactivation_hook', array($this, 'PK_reset'));
			//add_filter('admin_footer_text', array($this,'remove_footer_admin'));

			register_activation_hook( __FILE__, array( $this , 'PK_activate' ) );
			register_deactivation_hook( __FILE__, array( $this , 'PK_deactivate' ) );
			add_action( 'admin_footer', array($this,'wpse65611_script') );


		}

		static function PK_activate(){



			if(get_option('_PK_created_default') !== 'true' ){

				$accessfileurl = get_home_path(). ".htaccess";
				$defaultHTfileurl = get_home_path() . 'wp-content/plugins/simple-htaccess-redirects/assets/default.txt';

				$accessfileread = fopen($accessfileurl, 'r') or die('Unable to open the file. Sorry');

				$defaultaccessfilewrite = fopen($defaultHTfileurl, 'w+') or die('Unable to open the file. Sorry');

				$data = fread($accessfileread, filesize($accessfileurl));
				fwrite($defaultaccessfilewrite, $data);

				fclose($defaultaccessfilewrite);
				fclose($accessfileread);

				update_option('_PK_created_default', 'true');

			}



		}

		static function wpse65611_script() {
			wp_enqueue_style( 'wp-pointer' );
			wp_enqueue_script( 'wp-pointer' );
			wp_enqueue_script( 'utils' ); // for user settings
		?>
		    <script type="text/javascript">

		    jQuery('a[aria-label="Deactivate Simple Htaccess Redirects"]').click(function(){

					if(confirm("Do you want to reset your htaccess file from before you activated this plugin?") == true){

						var data = {
						'action': 'PK_reset',
					};

					// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
					jQuery.post(ajaxurl, data, function(response) {
						alert("Your File Has been reset.");
						window.location.reload();
					});
				}


			 });
			 
			

		    </script>
		<?php
		}


		static function PK_deactivate(){


		 update_option('_PK_400_setting', '');

 		 update_option('_PK_500_setting', '');

		 update_option('_PK_301_old_setting', '');
		 update_option('_PK_301_new_setting', '');

		 update_option('_PK_302_old_setting', '');
		 update_option('_PK_302_new_setting', '');

		 update_option('Write404', '');


		}




		function pk_plugin_add_settings_link( $links ) { 	

			$settings_link = '<a href="' . esc_url( get_admin_url( null, 'admin.php?page=PK-redirect-settings' ) ) . '">' . __( "Settings", 'textdomain' ) . '</a>';
			array_unshift( $links, $settings_link );
			return $links;
			
		}
	


		function remove_footer_admin ()
		{
		    echo '';
		}


		function PK_reset(){

			  $accessfileurl = get_home_path(). ".htaccess";
			  $defaultHTfileurl = get_home_path() . 'wp-content/plugins/simple-htaccess-redirects/assets/default.txt';

			  $accessfilewrite = fopen($accessfileurl, 'w+') or die('Unable to open the file. Sorry');

			  $defaultaccessfileread = fopen($defaultHTfileurl, 'r') or die('Unable to open the file. Sorry');

			  $data = fread($defaultaccessfileread, filesize($defaultHTfileurl));

			  $data =  $data . PHP_EOL;

			  fwrite($accessfilewrite, $data);

			  fclose($defaultaccessfileread);
			  fclose($accessfilewrite);

        }
        
        function PK_remove_active_redirect(){

            $activeRedirectsArray = get_option('_PK_Active_Redirect');

            $id = isset($_POST['id']) ? $_POST['id'] : "";

            unset($activeRedirectsArray[$id]);

            update_option ('_PK_Active_Redirect', $activeRedirectsArray);

            echo 'Removed ID: ' . $id;

            wp_die();

        }
	
		function PK_404_capture(){
			
			$optionsArray = get_option('_PK_404');
			
// 			if(!get_option('_PK_Active_Redirect')){
// 				update_option('_PK_Active_Redirect', array());
// 			}
			
			$activeRedirectsArray = get_option('_PK_Active_Redirect');
			$accessfileurl = get_home_path(). ".htaccess";
			
			
			for($i = 0; $i < count($optionsArray); $i++ ){
				
				
				$tempArray = array( 
					'From' => esc_url_raw( $optionsArray[$i]), 
					'To' => get_site_url(),
				);
				array_push($activeRedirectsArray, $tempArray);
				
			}
			
			update_option('_PK_Active_Redirect', $activeRedirectsArray);
			
			update_option('_PK_404', array());
			//update_option('_PK_Active_Redirect', array());

			wp_die();
		}
	
		function PK_scan_working_urls(){

			function str_replace_first($from, $to, $content)
			{
				$from = '/'.preg_quote($from, '/').'/';

				return preg_replace($from, $to, $content, 1);
			}	

			$path=get_site_url();
			$html = file_get_contents($path);
			$dom = new DOMDocument();
			@$dom->loadHTML($html);

			// grab all the on the page
			$xpath = new DOMXPath($dom);
			$hrefs = $xpath->evaluate("/html/body//a");
			$cleanUrls = [];
			$subUrls = [];	

			for ($i = 0; $i < $hrefs->length; $i++ ) {
				$href = $hrefs->item($i);
				$url = $href->getAttribute('href');

				if(substr( $url, 0, 1 ) === "/" ){

					$url = str_replace_first('/', get_site_url() . '/', $url);

				}

				array_push($cleanUrls, $url);
			}


			for($a = 0; $a < count($cleanUrls); $a++){

				$path = $cleanUrls[$a];
				$html = file_get_contents($path);

				$xpath = new DOMXPath($dom);
				$hrefs = $xpath->evaluate("/html/body//a");
				$dom = new DOMDocument();
				@$dom->loadHTML($html);


				for ($i = 0; $i < $hrefs->length; $i++ ) {
					$href = $hrefs->item($i);
					$url = $href->getAttribute('href');

					if(substr( $url, 0, 1 ) === "/" ){

					$url = str_replace_first('/', get_site_url(). "/" , $url);

					}
					array_push($subUrls, $url);
				}
			}
			
			
			$urlString = implode(",", array_unique($subUrls));
			

			$scannedfileurl = get_home_path() . 'wp-content/plugins/simple-htaccess-redirects/assets/allLinksFromYourSite.csv';
    	    $scannedfilewrite = fopen($scannedfileurl, 'w') or die('Unable to open the file. Sorry');
    	    
			
         	fwrite($scannedfilewrite, $urlString);        	
        
        	fclose($scannedfilewrite);
			
			echo print_r(array_unique($subUrls), true);	

			wp_die();	
		}
		
		function PK_scan_urls(){

        	$parseLinksObject = new ParseLinks('http://eb6.255.myftpupload.com/', 3000);
			$parseLinksObject->getAllLinks();	
			
			echo $html;
			wp_die();
		}




	 function PK_plugin_menu() {

		 // add_menu_page(
			//  'Redirect Settings',
			//  'Redirect Settings',
			//  'administrator',
			//  'PK-redirect-settings',
			//  array($this, 'PK_redirect_settings_page'),
			//  'dashicons-image-rotate'
		 // );

		 add_submenu_page( 'options-general.php', 'Redirect Settings', 'Redirect Settings', 'administrator', 'PK-redirect-settings',  array($this, 'PK_redirect_settings_page') );


		}

		function PK_headscript(){
			
			
		    //update_option('_PK_404', array());
		    //update_option('_PK_Active_Redirect', array());

			
            $activeRedirectsArray = get_option('_PK_Active_Redirect');
            
            
            if(empty($activeRedirectsArray)){
                $activeRedirectsArray = array();
            }

			$keys = array_keys($activeRedirectsArray);
			
			?>

			<script>
                currentUrl = window.location.href;
			<?php
			for($i = 0; $i < count($activeRedirectsArray); $i++) {

			?>
					
				if( currentUrl == '<?php echo get_site_url(). $activeRedirectsArray[$i]['From']?>'){
					window.location.href = '<?php echo $activeRedirectsArray[$i]['To'] ?>';
				}
				
			<?php
			}
			?>
			</script>		
			<?php		
			
			if(is_404()){
				
				$url = $_SERVER['REQUEST_URI'];
				$activeRedirects = get_option('_PK_Active_Redirect');
				
				$option = array(
					$url,
				);
				
// 				update_option('_PK_404', $option);
				
				$optionsArray = get_option('_PK_404');

				$activeRedirectsArray = get_option('_PK_Active_Redirect');
				
				if(empty($optionsArray)){
					$optionsArray = array();
				}
				
				if(empty($activeRedirectsArray)){
					$activeRedirectsArray = array();
				}
				
				$fromURL = array_column($activeRedirectsArray, 'From');
				
				if(!in_array($url, $optionsArray, true) && !in_array($url, $fromURL, true)){
					
						array_push($optionsArray, $url);
					
						update_option('_PK_404', $optionsArray);
				}
				
			}

			if(is_404() && get_option('_PK_404_setting') && get_option('Write404') == '1'){

				?>
					<script>

					window.location.href = "<?php if(get_option('_PK_404_setting')){	echo esc_attr( get_option('_PK_404_setting') ); }?>";
					</script>
				<?php
			}


		}


	function PK_debug_to_console( $data ) {
 	    $output = $data;
 	    if ( is_array( $output ) )
 	        $output = implode( ',', $output);

 	    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
 	}

	public function PK_getStatus($url){
		$response = wp_remote_get( $url );
		$http_code = wp_remote_retrieve_response_code( $response );
		return $http_code;
	}


	public function PK_addToLog($data){
	 $logfileurl = get_home_path() . 'wp-content/plugins/simple-htaccess-redirects/assets/log.txt';
	 $logfilewrite = fopen($logfileurl, 'a') or die('Unable to open the file. Sorry');

	 $currentuser = wp_get_current_user();

	 $data = PHP_EOL . "=== User: ". $currentuser->user_login . " Date: " . date_i18n("m-d-Y h:i") . " ===" . PHP_EOL . $data;
	 //PK_debug_to_console("Added data to log file");

	 fwrite($logfilewrite, $data);
	 fclose($logfilewrite);
	}


	function PK_redirect_settings_page() {

// 			update_option('_PK_404', array());
// 			update_option('_PK_Active_Redirect', array());
		?>

                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
                <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

                <style media="screen">
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab a.link-tab:hover:before,
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab a.link-tab.active:not(.expanded):before,
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab .ju-submenu-tabs div.link-tab:hover:before,
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab .ju-submenu-tabs div.link-tab.active:before {
                        content: '';
                        display: block;
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background-color: #fff;
                        opacity: .12;
                        pointer-events: none
                    }
                    
                    .ju-notice-success,
                    .ju-notice-error {
                        padding: 10px;
                        margin: 20px 20px 20px 0;
                        background-color: #fff;
                        border-left: 5px solid #000;
                        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.3);
                        -moz-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.3);
                        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.3)
                    }
                    
                    .clearfix:after,
                    .clearfix:before {
                        content: '';
                        display: block;
                        clear: both
                    }
                    
                    .no-display {
                        display: none
                    }
                    
                    .hidden-item {
                        visibility: hidden
                    }
                    
                    .tabs {
                        display: flex;
                        position: relative;
                        overflow: hidden;
                        margin: 0 auto;
                        white-space: nowrap;
                        width: 100%;
                        background-color: #fff
                    }
                    
                    .tabs .tab {
                        flex-grow: 1;
                        display: block;
                        text-align: center;
                        padding: 0;
                        margin: 0;
                        float: left;
                        text-transform: uppercase;
                        text-overflow: ellipsis;
                        overflow: hidden;
                        letter-spacing: .8px;
                        min-width: 80px;
                        background-color: #2196f3
                    }
                    
                    .tabs .tab a {
                        text-decoration: none;
                        color: #fff;
                        background-color: #2196f3;
                        display: block;
                        width: 100%;
                        height: 100%;
                        text-overflow: ellipsis;
                        overflow: hidden;
                        -webkit-transition: color .3s ease;
                        -moz-transition: color .3s ease;
                        -ms-transition: color .3s ease;
                        -o-transition: color .3s ease;
                        transition: color .3s ease
                    }
                    
                    .tabs .tab.disabled a {
                        cursor: default;
                        opacity: .6
                    }
                    
                    .tabs .indicator {
                        position: absolute;
                        bottom: 0;
                        height: 3px;
                        will-change: left, right;
                        background-color: #ff8726
                    }
                    
                    .ju-button {
                        background-color: transparent;
                        color: #000;
                        padding: 10px 15px;
                        min-width: 180px;
                        border: 1px solid #9fabba;
                        text-transform: uppercase;
                        display: inline-block;
                        text-decoration: none;
                        cursor: pointer;
                        text-align: center;
                        letter-spacing: 2px;
                        transition: all ease .5s;
                        vertical-align: middle;
                        -webkit-border-radius: 40px;
                        -moz-border-radius: 40px;
                        border-radius: 40px
                    }
                    
                    .ju-button:focus {
                        outline: 0
                    }
                    
                    .ju-button:hover {
                        -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
                        -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
                        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12)
                    }
                    
                    .ju-button.orange-button {
                        background-color: #ff8726;
                        color: #fff;
                        border-color: #ff8726
                    }
                    
                    .ju-button.orange-outline-button {
                        background-color: #fff;
                        color: #ff8726;
                        border-color: #fff
                    }
                    
                    .ju-rect-button {
                        background-color: #fff;
                        border: 1px solid #ff8726;
                        color: #ff8726;
                        cursor: pointer;
                        padding: 10px 15px;
                        -webkit-border-radius: 4px;
                        -moz-border-radius: 4px;
                        border-radius: 4px
                    }
                    
                    .ju-material-button {
                        border: 0;
                        outline: 0;
                        padding: 10px 20px;
                        text-transform: uppercase;
                        cursor: pointer;
                        font-size: 14px;
                        background-color: #2196f3;
                        color: #fff
                    }
                    
                    .ju-material-button:hover {
                        -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
                        -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
                        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12)
                    }
                    
                    input.ju-input {
                        padding: 15px;
                        border: 1px solid #ddd;
                        background-color: #fff;
                        height: auto;
                        -webkit-border-radius: 4px;
                        -moz-border-radius: 4px;
                        border-radius: 4px
                    }
                    
                    input.ju-input:focus {
                        border-color: #ff8726;
                        box-shadow: none;
                        outline: 0
                    }
                    
                    input.ju-input.minicolors {
                        padding-left: 55px
                    }
                    
                    input.ju-input.minicolors+.minicolors-swatch {
                        height: 48px;
                        width: 48px;
                        top: 2px;
                        left: 2px;
                        border: 0
                    }
                    
                    input.ju-input.minicolors+.minicolors-swatch .minicolors-swatch-color {
                        -webkit-border-radius: 4px;
                        -moz-border-radius: 4px;
                        border-radius: 4px
                    }
                    
                    input.ju-input.minicolors .minicolors-grid .minicolors-picker {
                        -webkit-box-sizing: content-box;
                        -moz-box-sizing: content-box;
                        box-sizing: content-box
                    }
                    
                    input.ju-input.minicolors .minicolors-grid .minicolors-picker>div {
                        -webkit-box-sizing: content-box;
                        -moz-box-sizing: content-box;
                        box-sizing: content-box
                    }
                    
                    select.ju-select {
                        padding: 0 15px;
                        height: 50px;
                        vertical-align: middle;
                        -webkit-border-radius: 4px;
                        -moz-border-radius: 4px;
                        border-radius: 4px
                    }
                    
                    select.ju-select:focus {
                        border: 1px solid #ff8726;
                        box-shadow: none;
                        outline: 0
                    }
                    
                    input.ju-checkbox:checked {
                        background-color: #49bf88;
                        border: 1px solid #49bf88
                    }
                    
                    input.ju-checkbox:checked:before {
                        color: #fff
                    }
                    
                    input.ju-radiobox {
                        border-color: #7d8a9a;
                        -webkit-box-shadow: none;
                        -moz-box-shadow: none;
                        box-shadow: none
                    }
                    
                    input.ju-radiobox:checked {
                        border-color: #49bf88
                    }
                    
                    input.ju-radiobox:checked:before {
                        width: 10px;
                        height: 10px;
                        margin: 2px;
                        background-color: #49bf88
                    }
                    
                    input.ju-radiobox:focus {
                        border-color: #49bf88;
                        -webkit-box-shadow: none;
                        -moz-box-shadow: none;
                        box-shadow: none
                    }
                    
                    .ju-notice-success {
                        border-left-color: #46b450
                    }
                    
                    .ju-notice-error {
                        border-left-color: #c00
                    }
                    
                    .ju-notice-close {
                        float: right;
                        color: #aaa
                    }
                    
                    .ju-notice-close:hover {
                        color: #c00;
                        cursor: pointer
                    }
                    
                    .ju-switch-button {
                        float: right;
                        margin-left: 10px;
                        margin-right: 30px
                    }
                    
                    .ju-switch-button .switch {
                        position: relative;
                        display: inline-block;
                        width: 50px;
                        height: 30px;
                        margin: 10px
                    }
                    
                    .ju-switch-button .switch input {
                        display: none
                    }
                    
                    .ju-switch-button .switch .slider {
                        position: absolute;
                        cursor: pointer;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background-color: #ccc;
                        -webkit-transition: .4s;
                        -moz-transition: .4s;
                        -ms-transition: .4s;
                        -o-transition: .4s;
                        transition: .4s;
                        -webkit-border-radius: 40px;
                        -moz-border-radius: 40px;
                        border-radius: 40px
                    }
                    
                    .ju-switch-button .switch .slider:before {
                        position: absolute;
                        content: '';
                        height: 27px;
                        width: 27px;
                        left: 2px;
                        bottom: 2px;
                        background-color: #fff;
                        -webkit-transition: .4s;
                        -moz-transition: .4s;
                        -ms-transition: .4s;
                        -o-transition: .4s;
                        transition: .4s;
                        -webkit-border-radius: 50%;
                        -moz-border-radius: 50%;
                        border-radius: 50%
                    }
                    
                    .ju-switch-button .switch input:checked+.slider {
                        background-color: #5dca70
                    }
                    
                    .ju-switch-button .switch input:checked+.slider:before {
                        -webkit-transform: translateX(20px);
                        -moz-transform: translateX(20px);
                        -ms-transform: translateX(20px);
                        -o-transform: translateX(20px);
                        transform: translateX(20px)
                    }
                    
                    .settings-list {
                        display: flex;
                        flex-wrap: wrap;
                        flex: auto
                    }
                    
                    .ju-settings-option {
                        width: 48%;
                        margin-bottom: 20px;
                        margin-right: 2%;
                        background-color: #fff;
                        -webkit-box-shadow: 0 10px 30px 0 rgba(160, 166, 190, 0.08);
                        -moz-box-shadow: 0 10px 30px 0 rgba(160, 166, 190, 0.08);
                        box-shadow: 0 10px 30px 0 rgba(160, 166, 190, 0.08);
                        -webkit-border-radius: 4px;
                        -moz-border-radius: 4px;
                        border-radius: 4px
                    }
                    
                    .ju-settings-option.settings-separator {
                        background-color: transparent;
                        -webkit-box-shadow: none;
                        -moz-box-shadow: none;
                        box-shadow: none
                    }
                    
                    .ju-settings-option.full-width,
                    .ju-settings-option.settings-separator {
                        width: 98%
                    }
                    
                    .ju-settings-option.settings-separator .settings-separator-title {
                        display: block;
                        font-size: 20px;
                        font-weight: bold
                    }
                    
                    .ju-setting-label {
                        float: left;
                        display: inline-block;
                        min-width: 150px;
                        max-width: calc(100% - 150px);
                        overflow: hidden;
                        white-space: nowrap;
                        -ms-text-overflow: ellipsis;
                        text-overflow: ellipsis;
                        margin: 0;
                        line-height: 50px;
                        cursor: pointer
                    }
                    
                    .ju-main-wrapper {
                        margin-left: -20px;
                        font-family: 'Roboto', sans-serif
                    }
                    
                    .ju-main-wrapper * {
                        -webkit-box-sizing: border-box;
                        -moz-box-sizing: border-box;
                        box-sizing: border-box
                    }
                    
                    .ju-main-wrapper img {
                        max-width: 100%
                    }
                    
                    .ju-main-wrapper .ju-left-panel {
                        width: 300px;
                        height: 100%;
                        padding: 20px 0;
                        background-image: linear-gradient(to bottom, #2b600d, #8e8a2e);
                        position: fixed;
                        overflow: auto;
                        z-index: 15;
                        -webkit-box-shadow: 10px 20px 20px 0 rgba(186, 192, 213, 0.1);
                        -moz-box-shadow: 10px 20px 20px 0 rgba(186, 192, 213, 0.1);
                        box-shadow: 10px 20px 20px 0 rgba(186, 192, 213, 0.1)
                    }
                    
                    .ju-main-wrapper .ju-left-panel .ju-logo a {
                        display: block;
                        width: 230px;
                        height: 90px;
                        margin: auto
                    }
                    
                    .ju-main-wrapper .ju-left-panel .ju-menu-search {
                        margin: 20px 10px;
                        padding: 10px 5px;
                        border: 0;
                        border-bottom: 1px solid #6294e9
                    }
                    
                    .ju-main-wrapper .ju-left-panel .ju-menu-search .ju-menu-search-icon {
                        font-size: 20px;
                        color: #fff;
                        vertical-align: text-bottom
                    }
                    
                    .ju-main-wrapper .ju-left-panel .ju-menu-search .ju-menu-search-input {
                        background: transparent;
                        color: #fff;
                        border: 0;
                        outline: 0;
                        padding: 5px;
                        font-size: 18px;
                        -webkit-box-shadow: none;
                        -moz-box-shadow: none;
                        box-shadow: none
                    }
                    
                    .ju-main-wrapper .ju-left-panel .ju-menu-search .ju-menu-search-input::placeholder {
                        color: #fff;
                        opacity: .5
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs {
                        display: block;
                        background-color: transparent;
                        height: auto;
                        margin: 20px 0
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab {
                        float: none;
                        width: auto;
                        height: auto;
                        text-align: left;
                        position: relative;
                        line-height: normal;
                        background-color: transparent
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab a.link-tab {
                        padding: 20px;
                        opacity: .7;
                        background-color: transparent
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab a.link-tab:focus {
                        outline: 0;
                        -webkit-box-shadow: none;
                        -moz-box-shadow: none;
                        box-shadow: none
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab a.link-tab:after {
                        font-family: 'Material Icons';
                        font-size: 24px;
                        vertical-align: text-bottom;
                        position: absolute;
                        right: 15px
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab a.link-tab.with-submenus:not(.expanded):after {
                        content: '\e313'
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab a.link-tab.active {
                        opacity: 1;
                        background-color: #4c79ca
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab a.link-tab.active.with-submenus.expanded:after {
                        content: '\e316'
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab a.link-tab.active.with-submenus.expanded+.ju-submenu-tabs {
                        max-height: 500px
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab a.link-tab.active:not(.expanded) {
                        background-color: transparent
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab .ju-submenu-tabs {
                        display: block;
                        max-height: 0;
                        background-color: #4c79ca;
                        -webkit-transition: max-height cubic-bezier(0.3, 1.1, 0.3, 1.1) 1s;
                        -moz-transition: max-height cubic-bezier(0.3, 1.1, 0.3, 1.1) 1s;
                        -ms-transition: max-height cubic-bezier(0.3, 1.1, 0.3, 1.1) 1s;
                        -o-transition: max-height cubic-bezier(0.3, 1.1, 0.3, 1.1) 1s;
                        transition: max-height cubic-bezier(0.3, 1.1, 0.3, 1.1) 1s
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab .ju-submenu-tabs div.link-tab {
                        padding: 20px;
                        cursor: pointer;
                        color: #fff;
                        margin-left: 32px;
                        font-size: 16px;
                        opacity: .7
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab .ju-submenu-tabs div.link-tab.active {
                        opacity: 1
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab .menu-tab-icon {
                        font-size: 22px;
                        vertical-align: sub
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab .tab-title {
                        font-size: 16px;
                        margin-left: 5px;
                        display: inline-block;
                        max-width: 75%;
                        overflow: hidden;
                        -ms-text-overflow: ellipsis;
                        text-overflow: ellipsis;
                        vertical-align: text-bottom
                    }
                    
                    .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs .indicator {
                        display: none
                    }
                    
                    .ju-main-wrapper .ju-right-panel {
                        width: calc(100% - 300px);
                        padding: 0 20px;
                        font-size: 14px;
                        margin-left: 300px;
                        background-color: #f3f6fa
                    }
                    
                    .ju-main-wrapper .ju-right-panel:before {
                        content: '';
                        display: block;
                        clear: both;
                        padding: 1px 0 0 0
                    }
                    
                    .ju-main-wrapper .ju-right-panel .ju-top-tabs-wrapper {
                        background-color: #fff;
                        margin: auto -20px
                    }
                    
                    .ju-main-wrapper .ju-right-panel .tabs.ju-top-tabs {
                        width: fit-content !important
                    }
                    
                    .ju-main-wrapper .ju-right-panel .tabs.ju-top-tabs li.tab {
                        text-transform: capitalize;
                        min-width: 200px;
                        background-color: #fff
                    }
                    
                    .ju-main-wrapper .ju-right-panel .tabs.ju-top-tabs li.tab a.link-tab {
                        color: #ff8726;
                        background-color: #fff;
                        font-weight: bold;
                        padding: 20px
                    }
                    
                    .ju-main-wrapper .ju-right-panel .tabs.ju-top-tabs li.tab a.link-tab.active:before {
                        content: '\f147';
                        font-family: 'dashicons';
                        font-size: 20px;
                        vertical-align: middle
                    }
                    
                    .ju-main-wrapper .ju-right-panel .tabs.ju-top-tabs li.tab a.link-tab:focus {
                        -webkit-box-shadow: none;
                        -moz-box-shadow: none;
                        box-shadow: none
                    }
                    
                    .ju-main-wrapper .ju-right-panel .tabs.ju-top-tabs .indicator {
                        background-color: #ff8726;
                        z-index: 10
                    }
                    
                    .ju-main-wrapper .ju-left-panel-toggle {
                        display: none;
                        position: fixed;
                        top: 120px;
                        left: 35px;
                        cursor: pointer;
                        background-color: #fff;
                        width: auto;
                        height: auto;
                        padding: 25px 5px;
                        border: 1px solid #ddd;
                        opacity: .5;
                        z-index: 15;
                        -webkit-border-radius: 0 25px 25px 0;
                        -moz-border-radius: 0 25px 25px 0;
                        border-radius: 0 25px 25px 0
                    }
                    
                    .ju-main-wrapper .ju-left-panel-toggle:hover,
                    .ju-main-wrapper .ju-left-panel-toggle:focus {
                        opacity: 1
                    }
                    
                    .ju-main-wrapper .ju-left-panel-toggle .ju-left-panel-toggle-icon {
                        color: #ff8726
                    }
                    
                    .search-result {
                        outline: 1px solid #ff8726;
                        -webkit-box-shadow: 1px 1px 12px #ccc;
                        -moz-box-shadow: 1px 1px 12px #ccc;
                        box-shadow: 1px 1px 12px #ccc
                    }
                    
                    .rtl .ju-main-wrapper {
                        margin-left: 0;
                        margin-right: -20px
                    }
                    
                    .rtl .ju-main-wrapper .ju-left-panel .tabs.ju-menu-tabs li.tab {
                        text-align: inherit
                    }
                    
                    .rtl .ju-main-wrapper .ju-right-panel {
                        margin-left: 0;
                        margin-right: 300px
                    }
                    
                    .rtl .ju-main-wrapper .ju-left-panel-toggle {
                        left: unset;
                        right: 35px;
                        -webkit-border-radius: 25px 0 0 25px;
                        -moz-border-radius: 25px 0 0 25px;
                        border-radius: 25px 0 0 25px
                    }
                    
                    .rtl .ju-setting-label {
                        float: right
                    }
                    
                    .rtl .ju-switch-button {
                        float: left
                    }
                    
                    @media screen and (max-width:960px) {
                        .ju-main-wrapper .ju-left-panel {
                            display: none
                        }
                        .ju-main-wrapper .ju-right-panel {
                            width: 100%;
                            margin-left: 0
                        }
                        .ju-main-wrapper .ju-right-panel .tabs.ju-top-tabs {
                            width: 100% !important;
                            flex-wrap: wrap
                        }
                        .ju-main-wrapper .ju-right-panel .tabs.ju-top-tabs li.tab {
                            flex: 0 0 100%
                        }
                        .ju-main-wrapper .ju-right-panel .tabs.ju-top-tabs li.tab a.link-tab.active {
                            background-color: #ff8726;
                            color: #fff
                        }
                        .ju-main-wrapper .ju-right-panel .tabs.ju-top-tabs li.tab a.link-tab.active:before {
                            display: none
                        }
                        .ju-main-wrapper .ju-right-panel .tabs.ju-top-tabs .indicator {
                            display: none
                        }
                        .ju-main-wrapper .ju-left-panel-toggle {
                            display: block
                        }
                        .rtl .ju-main-wrapper .ju-right-panel {
                            margin-right: 0
                        }
                    }
                    
                    @media screen and (max-width:782px) {
                        .ju-main-wrapper .ju-left-panel-toggle {
                            left: 0
                        }
                        .ju-settings-option {
                            width: 98%
                        }
                        .rtl .ju-main-wrapper .ju-left-panel-toggle {
                            right: 0
                        }
                    }
                    
                    #profiles-list {
                        width: 100%;
                        border-collapse: collapse;
                        border: none;
                    }
                    
                    #delete-selected-profiles {
                        padding: 14px 15px;
                    }
                    
                    #profiles-list th {
                        text-align: inherit;
                        padding: 10px;
                    }
                    
                    #profiles-list th span {
                        color: #568095;
                    }
                    
                    #profiles-list tbody td {
                        padding: 20px 10px;
                    }
                    
                    #profiles-list .profile-header-title {
                        width: 70%;
                    }
                    
                    #profiles-list .profile-header-author {
                        width: 15%;
                    }
                    
                    #profiles-list .profile-header-date {
                        width: 15%;
                    }
                    
                    .advgb-profile {
                        background-color: #fff;
                    }
                    
                    .advgb-profile td {
                        border-bottom: 10px solid #f3f6fa;
                    }
                    
                    .advgb-profile .profile-title .profile-delete {
                        visibility: hidden;
                        cursor: pointer;
                        font-size: 20px;
                        vertical-align: sub;
                        margin-left: 10px;
                        color: #F98436;
                    }
                    
                    .advgb-profile:hover .profile-delete {
                        visibility: visible;
                    }
                    
                    #profiles-list .sorting-header {
                        cursor: pointer;
                    }
                    
                    #profiles-list .sorting-header i {
                        vertical-align: bottom;
                    }
                    
                    .sorting-header.desc i.dashicons:before {
                        content: "\f140";
                    }
                    
                    .sorting-header.asc i.dashicons:before {
                        content: "\f142";
                    }
                    
                    .advgb-profile .profile-title a {
                        text-decoration: none;
                        color: #000;
                        font-weight: bold;
                    }
					pre{
						height: 550px;
					}
					.notice, div.error, div.updated{
						width: calc(100% - 301px) !important;
						padding: 0 20px !important;
						font-size: 14px !important;
						right: 3px !important;
						background-color: #f3f6fa !important;
						position: absolute !important;
					}
					
					.loader {
					  border: 16px solid #f3f3f3;
					  border-top: 16px solid #3498db;
					  border-radius: 50%;
					  width: 120px;
					  height: 120px;
					  animation: spin 2s linear infinite;
					}
					
					@keyframes spin {
					  0% { transform: rotate(0deg); }
					  100% { transform: rotate(360deg); }
					}
					
					#footer-thankyou{
						display:none !important;
					}

                  
                </style>

                <div id="wpbody-content">
                    <div id="screen-meta" class="metabox-prefs">

                        <div id="contextual-help-wrap" class="hidden no-sidebar" tabindex="-1" aria-label="Contextual Help Tab">
                            <div id="contextual-help-back"></div>
                            <div id="contextual-help-columns">
                                <div class="contextual-help-tabs">
                                    <ul>
                                    </ul>
                                </div>


                                <div class="contextual-help-tabs-wrap">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ju-main-wrapper" style="">
                        <div class="ju-left-panel-toggle" id="left-panel-toggle">
                            <i class="dashicons dashicons-leftright ju-left-panel-toggle-icon"></i>
                        </div>
                        <div class="ju-left-panel" id="left-panel">
                            <div class="ju-logo">
                                <a href="https://packerlandwebsites.com/" target="_blank">
                                    <img src="https://packerlandwebsites.com/wp-content/uploads/2018/01/packerland-websites-header-logo.png" alt="JoomUnited logo">
                                </a>
                            </div>
                            <ul class="tabs ju-menu-tabs" id="tabs" style="width: 100%;">
							
								
                                <li class="tab" data-tab-title="Redirect">
                                    <a href="#redirect" class="link-tab white-text waves-effect waves-light active">
                                        <i class="mi mi-account-circle menu-tab-icon"></i>
                                        <span class="tab-title">Redirect</span>
                                    </a>
                                </li>
								
								<li class="tab" data-tab-title="ScanUrls">
                                    <a href="#scanUrls" class="link-tab white-text waves-effect waves-light">
                                        <i class="mi mi-account-circle menu-tab-icon"></i>
                                        <span class="tab-title">Scan Urls</span>
                                    </a>
                                </li>
								
								
								
								<li class="tab" data-tab-title="404-Captures">
                                    <a href="#404-Captures" class="link-tab white-text waves-effect waves-light">
                                        <i class="mi mi-account-circle menu-tab-icon"></i>
                                        <span class="tab-title">404 Captures</span>
                                    </a>
                                </li>
								
								<li class="tab" data-tab-title="Active-Redirects">
                                    <a href="#404-Captures" class="link-tab white-text waves-effect waves-light">
                                        <i class="mi mi-account-circle menu-tab-icon"></i>
                                        <span class="tab-title">Active Redirects</span>
                                    </a>
                                </li>
								
								<li class="tab" data-tab-title="Expired-Headers">
                                    <a href="#Expired-Headers" class="link-tab white-text waves-effect waves-light">
                                        <i class="mi mi-account-circle menu-tab-icon"></i>
                                        <span class="tab-title">Expired Headers</span>
                                    </a>
                                </li>
								
                                
				            
                                <div class="indicator" style="right: -283px; left: 283px;"></div>
                            </ul>
                        </div>
                        <div class="ju-right-panel">
                            <div class="ju-content-wrapper" id="Redirect" style="display: block;">
                                <input type="hidden" id="advgb_profiles_nonce" name="advgb_profiles_nonce" value="fbd884944c"><input type="hidden" name="_wp_http_referer" value="/wp-admin/admin.php?page=advgb_main">
                                <div class="advgb-header" style="padding-top: 40px">
                                    <h1 class="header-title">Redirects</h1>
                                   
							<?php include( plugin_dir_path(__FILE__) . "parts/content-redirect.php" ); ?>
                                </div>
                                
								
								<div id="redirectTab" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php
			

			if(file_exists(get_home_path(). ".htaccess")){

			 $content = "";


			$accessfileurl = get_home_path(). ".htaccess";


			if(get_option('Write301') == '1' && get_option('_PK_301_old_setting') != "" && get_option('_PK_301_new_setting') != ""){

			 $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');
			 $content301 = PHP_EOL . "Redirect 301 ". get_site_url() . esc_attr( esc_url_raw(get_option('_PK_301_old_setting'))). " ". esc_attr( esc_url_raw(get_option('_PK_301_new_setting'))) . PHP_EOL;
			 $content = $content . $content301;
			 fwrite($accessfilewrite, $content301);


			 fclose($accessfilewrite);

			 update_option( 'Write301', "0" );

            $activeRedirectsArray = get_option('_PK_Active_Redirect');
            
            if(empty($activeRedirectsArray)){
                $activeRedirectsArray = array();
            }
			
			$tempArray = array( 
				'From' => esc_attr( esc_url_raw(get_option('_PK_301_old_setting'))), 
				'To' =>  esc_attr( esc_url_raw(get_option('_PK_301_new_setting'))),
			);
				
			array_push($activeRedirectsArray, $tempArray);
	
			update_option('_PK_Active_Redirect', $activeRedirectsArray);

			 ?>
                                    <script type="text/javascript">
                                        document.getElementById("myCheck").checked = false;
                                    </script>
                                    <?php
			}else{
			 ?>
                                        <script type="text/javascript">
                                            document.getElementById("myCheck").checked = false;
                                        </script>
                                        <?php
			}

			if(get_option('ForceHttps') == '1'){

			$accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');
			$contentHttps = PHP_EOL . "RewriteEngine On". PHP_EOL . "RewriteCond %{HTTPS} !=on" . PHP_EOL . "RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]". PHP_EOL;
			$content = $content . $contentHttps;
			fwrite($accessfilewrite, $contentHttps);
			update_option( 'ForceHttps', "0" );
			fclose($accessfilewrite);


			?>
                                            <script type="text/javascript">
                                                document.getElementById("myCheck5").checked = false;
                                            </script>
                                            <?php
			}

			if(get_option('Write500') == '1' && get_option('_PK_500_setting') != ""){

			$accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');
			$content500 = PHP_EOL . "ErrorDocument 500 ". esc_attr( esc_url_raw(get_option('_PK_500_setting'))) . PHP_EOL;
			$content = $content . $content500;
			fwrite($accessfilewrite, $content500);
			update_option( 'Write500', "0" );
			fclose($accessfilewrite);

			?>
                                                <script type="text/javascript">
                                                    document.getElementById("myCheck3").checked = false;
                                                </script>
                                                <?php
			}else{
			?>
                                                    <script type="text/javascript">
                                                        document.getElementById("myCheck3").checked = false;
                                                    </script>
                                                    <?php
			}

			if(get_option('Write302') == '1' && get_option('_PK_302_old_setting') != "" && get_option('_PK_302_new_setting') != ""){

			$accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');
			$content302 = PHP_EOL . "Redirect 302 ". get_site_url() .esc_attr( esc_url_raw(get_option('_PK_302_old_setting'))). " ". esc_attr( esc_url_raw(get_option('_PK_302_new_setting'))) . PHP_EOL;
			$content = $content . $content302;
			fwrite($accessfilewrite, $content302);
			update_option( 'Write302', "0" );
			fclose($accessfilewrite);

			$activeRedirectsArray = get_option('_PK_Active_Redirect');
			
			$tempArray = array( 
				'From' => esc_attr( esc_url_raw(get_option('_PK_302_old_setting'))), 
				'To' =>  esc_attr( esc_url_raw(get_option('_PK_302_new_setting'))),
			);
				
			array_push($activeRedirectsArray, $tempArray);
	
			update_option('_PK_Active_Redirect', $activeRedirectsArray);


			?>
                                                        <script type="text/javascript">
                                                            document.getElementById("myCheck2").checked = false;
                                                        </script>
                                                        <?php

			}else{
			?>
                                                            <script type="text/javascript">
                                                                document.getElementById("myCheck2").checked = false;
                                                            </script>
                                                            <?php
			}

			?>


                            </div>
							
			

                        <div id="fileinfo" style="display:none;">
                            <h4>
                                <?php esc_html_e('This is just showing you what is inside of .htaccess and can\'t be edited here.', 'PK-redirect') ?>
                                </h4>

                                <!-- <h3>You can always copy and paste the file contents into <a target="_blank" href="http://www.htaccesscheck.com/">this</a> valudator to make sure you have everything correct.</h3> -->

                                <form target="_blank" style="width:600px;" action="http://www.htaccesscheck.com/check.cgi" method="post" enctype="multipart/form-data">
                                    <br>
                                    <textarea rows="15" cols="50" name="htaccess" style="font-size:15px;"><?php

			 $accessfileread = fopen($accessfileurl, 'r') or die('Unable to open the file. Sorry');
			 echo fread($accessfileread, filesize($accessfileurl));
			 fclose($accessfileread);
			 ?>
		 </textarea>
                                    <br>
                                    <input class="ju-rect-button" type="submit" name="Submit" value="Validate File">
                                </form>

                        </div>
           <div class="profiles-action-btn" style="float: left; margin: 25px auto">
                                        <button type="button" id="show" class="ju-rect-button">
           								 <?php esc_html_e('Show .htaccess file', 'PK-redirect') ?>        
										</button>
                                    </div>



                    <form id="PK_resetForm" action="" style="float: left; margin: 25px auto">
                        <input type="submit" class="PK_reset ju-rect-button" name="insert" value="Reset .htaccess file" />
                    </form>


                        </div>
                    </div>
                            </div>
							
                        <div class="ju-content-wrapper" id="ScanUrls" style="display: none;">

                                <div id="advgb-settings-container">

                                    <h1 class="advgb-settings-header" style="padding-top:40px;">Scan Urls</h1>
									
									<?php include( plugin_dir_path(__FILE__) . "parts/content-scan-urls.php" ); ?>
			
                            </div>
                        </div>
							
								
					  <div class="ju-content-wrapper" id="404-Captures" style="display: none">
								
							<h1 class="advgb-settings-header" style="padding-top:40px;">404 Captures</h1>
						  
						  	<?php include( plugin_dir_path(__FILE__) . "parts/content-404-captures.php" ); ?>
							
                        </div>
							
						<div class="ju-content-wrapper" id="Active-Redirects" style="display: none">
								
							<h1 class="advgb-settings-header" style="padding-top:40px;">Active Redirects</h1>
						  
						  	<?php include( plugin_dir_path(__FILE__) . "parts/content-active-redirects.php" ); ?>
							
                        </div>	
                        			
							
                        <div class="ju-content-wrapper" id="Expired-Headers" style="display: none">
								
							<h1 class="advgb-settings-header" style="padding-top:40px;">Expired Headers</h1>
							
                            <?php include( plugin_dir_path(__FILE__) . "parts/content-expired-headers.php" ); ?>
                        </div>
					
                        

                    
                </div>
                </div>
                <div class="clear"></div>
                </div>
				
				<script>
					
				var header = document.getElementById("tabs");
				var btns = header.getElementsByClassName("tab");
				var r = document.getElementById('Redirect');
				var s = document.getElementById('ScanUrls');
				var e = document.getElementById('Expired-Headers');
				var c = document.getElementById('404-Captures');
				var ar = document.getElementById('Active-Redirects');
				var current = document.getElementsByClassName("active");	
				var selectedTab = '';
					
				var leftPanel = document.getElementById('left-panel');
				var panelToggle = document.getElementById('left-panel-toggle');
				var menuOpen = false;
					
				panelToggle.addEventListener("click", function() {
					if(menuOpen){
						menuOpen = false;
						leftPanel.style.display = "none";
						panelToggle.style.left = "35px";
					}else{
						menuOpen = true;
						leftPanel.style.display = "block";
						panelToggle.style.left = "335px";
					}
				});	
					
				for (var i = 0; i < btns.length; i++) {
				  btns[i].addEventListener("click", function() {
					  
					 if (current.length > 0) { 
						current[0].className = current[0].className.replace(" active", "");
					 }
					  
					  this.childNodes[1].className += " active";
					  selectedTab = this.getAttribute('data-tab-title');
					  
					  if(selectedTab == 'Redirect'){
						  r.style.display = "block";
						  s.style.display = "none";
						  e.style.display = "none";
						  c.style.display = "none";
						  ar.style.display = "none";
					  }else if(selectedTab == 'ScanUrls'){
						  r.style.display = "none";
						  s.style.display = "block";
						  e.style.display = "none";
						  c.style.display = "none";
						  ar.style.display = "none";
					  }else if(selectedTab == 'Expired-Headers'){
						  r.style.display = "none";
						  s.style.display = "none";
						  e.style.display = "block";
						  c.style.display = "none";
						  ar.style.display = "none";
					  }else if(selectedTab == '404-Captures'){
						  r.style.display = "none";
						  s.style.display = "none";
						  e.style.display = "none";
						  c.style.display = "block";
						  ar.style.display = "none";
					  }else if(selectedTab == 'Active-Redirects'){
						  r.style.display = "none";
						  s.style.display = "none";
						  e.style.display = "none";
						  c.style.display = "none";
						  ar.style.display = "block";
					  }

				  });
				}
				</script>
			

                <?php date_default_timezone_set('America/Chicago'); ?>


                <div class="tab-content">
                    

                    <div id="expiredTab" class="tab-pane fade">
                        <?php include( plugin_dir_path(__FILE__) . "parts/content-expired-headers.php" ); ?>
                    </div>

                  
                    <script>
                        jQuery(document).ready(function() {

                            document.getElementById("PK_resetForm").addEventListener("click", function(event) {
                                event.preventDefault()
                            });
							
							<?php	
				
							if(count($optionsArray) != 0){
							?>
								 document.getElementById("404Captures").addEventListener("click", function(event) {
									event.preventDefault();
								});
							
							<?php } ?>

                            jQuery('#GetFile').css('display', 'none');


                            jQuery('.PK_reset').click(function() {

                                if (confirm("Are you sure you want to reset your htaccess file? It will be reset to the point before this plugin was activated.") == true) {

                                    var data = {
                                        'action': 'PK_reset',
                                    };

                                }

                                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                                jQuery.post(ajaxurl, data, function(response) {
                                    alert("Your File Has been reset.");
                                    window.location.reload();
                                });

                            });

                            jQuery('#ScanWorkingUrls').click(function() {

                                if (confirm("Do you want to scan your sites urls? (This might take a couple of minutes depending on how big your site is)") == true) {

                                    jQuery('.loader').css('display', 'block');


                                    var data = {
                                        'action': 'PK_scan_working_urls',
                                    };

                                }

                                jQuery.post(ajaxurl, data, function(response) {

                                    var res = response;


                                    jQuery('#UrlContainer').html("<pre>" + res + "</pre>");

                                    jQuery('.loader').css('display', 'none');

                                    jQuery('#GetFile').css('display', 'block');
                                });

                            });
							
							jQuery('#404Captures').click(function() {

                                if (confirm("This Will Create a 301 Redirect For Each Of The URLs. Do you want to add them all?") == true) {

                                    jQuery('.loader').css('display', 'block');


                                    var data = {
                                        'action': 'PK_404_capture',
                                    };

                                }

                                jQuery.post(ajaxurl, data, function(response) {

                                    var res = response;
									
									console.log(res);
									
									if(res == ''){
										
									alert("404 Redirects Added");
									
                                   	 window.location.reload();
										
									}
									
									
                                });

                            });



                            jQuery('#GetFile').click(function() {

                                var domainName = document.location.host;
                                var pluginPath = '/wp-content/plugins/simple-htaccess-redirects';
                                var scannedUrlsFile = '/assets/allLinksFromYourSite.csv';
                                var pluginURL = '<?php echo PK_REDIRECT_URL;?>assets/allLinksFromYourSite.csv';

                                fetch(pluginURL)
                                    .then(resp => resp.blob())
                                    .then(blob => {
                                        const url = window.URL.createObjectURL(blob);
                                        const a = document.createElement('a');
                                        a.style.display = 'none';
                                        a.href = url;
                                        // the filename you want
                                        a.download = 'allLinksFromYourSite.csv';
                                        document.body.appendChild(a);
                                        a.click();
                                        window.URL.revokeObjectURL(url);

                                    })
                                    .catch(function(error) {
                                        console.log(error);
                                        alert("Can't Download File, Please Click The New Generated Link");
                                        jQuery('#ForceDownload').css('display', 'block');
                                        jQuery('#GetFile').css('display', 'none');
                                    });

                            });


                            jQuery("#show").click(function() {
                                jQuery("#fileinfo").toggle();
                            });



                        });
                    </script>


                </div>



                <?php
	if($content != ''){
	 	$this->PK_addToLog($content);
	}else{
	}

 	}

	}

	 public function PK_plugin_settings() {

		 // redirect settings
		 register_setting( 'PK-redirect-settings-group', '_PK_redirect_old_urls' );
		 register_setting( 'PK-redirect-settings-group', '_PK_redirect_new_urls' );

		 register_setting( 'PK-redirect-settings-group', '_PK_404_setting' );
		 register_setting( 'PK-redirect-settings-group', '_PK_500_setting' );

		 register_setting( 'PK-redirect-settings-group', '_PK_301_old_setting' );
		 register_setting( 'PK-redirect-settings-group', '_PK_301_new_setting' );

		 register_setting( 'PK-redirect-settings-group', '_PK_302_old_setting' );
		 register_setting( 'PK-redirect-settings-group', '_PK_302_new_setting' );

		 register_setting( 'PK-redirect-settings-group', 'ForceHttps' );

		 register_setting( 'PK-redirect-settings-group', 'Write301' );
		 register_setting( 'PK-redirect-settings-group', 'Write302' );
		 register_setting( 'PK-redirect-settings-group', 'Write404' );
		 register_setting( 'PK-redirect-settings-group', 'Write500' );

		 register_setting( 'PK-redirect-settings-group', '_PK_created_default' );

		 // expire headers settings
		 register_setting( 'PK-redirect-settings-group', '_PK_png_value' );
		 register_setting( 'PK-redirect-settings-group', '_PK_png_options' );
		 register_setting( 'PK-redirect-settings-group', 'WritePNG' );

		 register_setting( 'PK-redirect-settings-group', '_PK_jpg_value' );
		 register_setting( 'PK-redirect-settings-group', '_PK_jpg_options' );
		 register_setting( 'PK-redirect-settings-group', 'WriteJPG' );

		 register_setting( 'PK-redirect-settings-group', '_PK_css_value' );
		 register_setting( 'PK-redirect-settings-group', '_PK_css_options' );
		 register_setting( 'PK-redirect-settings-group', 'WriteCSS' );

		 register_setting( 'PK-redirect-settings-group', '_PK_js_value' );
		 register_setting( 'PK-redirect-settings-group', '_PK_js_options' );
		 register_setting( 'PK-redirect-settings-group', 'WriteJS' );
		 
		 // captured 404 settings
		 register_setting( 'PK-404-capture-settings-group', '_PK_404' );
		 register_setting( 'PK-404-capture-settings-group', '_PK_Active_Redirect' );
	 }




}


/*
 * Starts our plugin class, yay!
 */
new PKRedirect();