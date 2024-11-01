<?php
/*
Plugin Name: WPCongress
Plugin URI: http://polkapolka.net/wpcongress/
Description: Add a form to allow your visitors to find/contact their members of Congress. Put your Sunlight API key in the settings page, then add [wpcongress_form] and [wpcongress_browse] where you would like your form and directory to appear respectively. Improved UI and more features coming soon!
Version: 0.6.8
Author: Dana Sniezko
Author URI: http://hackinginthecity.wordpress.com/
License: GPL2 
    
   */

// see if a key is set, if not blank

// init
function wpcongress_init() {
		add_action('admin_menu', 'wpcongress_config_page');
		add_action('wp_print_scripts',wp_enqueue_script('jquery'));
		if(get_option('wpcongress_ajax')) {
		add_action('wp_print_scripts',wp_enqueue_script('jquery-form'));
		wp_register_script( 'wpcongress_script', WP_PLUGIN_URL . '/wpcongress/wpcongress.js.php' );
        wp_enqueue_script('wpcongress_script' );
        }
}

// create a config page
function wpcongress_config_page() {
	if ( function_exists('add_submenu_page') )
		add_submenu_page('plugins.php', __('WPCongress Configuration'), __('WPCongress Configuration'), 'manage_options', 'wpcongress_key', 'wpcongress_conf');
}

// display the config page
function wpcongress_conf() {
	//global $akismet_nonce, $wpcom_api_key;

	if ( isset($_POST['submit']) ) {
		if ( function_exists('current_user_can') && !current_user_can('manage_options') )
			die(__('Cheatin&#8217; uh?'));
		//if(!empty(get_option('sunlight_api_key'))) {
			update_option('sunlight_api_key', $_POST['key']);
			if($_POST['credit'] == 'on') {
				update_option('wpcongress_credit', '1');
			} else { update_option('wpcongress_credit', '0'); }
			if($_POST['ajax'] == 'on') {
				update_option('wpcongress_ajax', '1');
			} else { update_option('wpcongress_ajax', '0'); }
			if($_POST['cache'] == 'on') {
				update_option('wpcongress_cache', '1');
			} else { update_option('wpcongress_cache', '0'); }
			if($_POST['curl'] == 'on') {
				update_option('wpcongress_curl', '1');
			} else { update_option('wpcongress_curl', '0'); }
			
			
		//}
	}
	 if ( !empty($_POST['submit'] ) ) { ?>
	 <div id="message" class="updated fade"><p><strong><?php _e('Options saved.') ?></strong></p></div>
	<?php }
	include('adminform.php'); 
}
function wpcongress_key() {

}

// give optional credit
function wpcongress_credit() {
		if(get_option('wpcongress_credit') == '1') {
			echo "<p class='wpcongress-credit'><small>Powered by <a href='http://wordpress.org/extend/plugins/wpcongress/'>WPCongress</a>. Data from <a href='http://geocoder.us/'>geocoder.us</a>, and the <a href='http://services.sunlightlabs.com/docs/Sunlight_Congress_API/'>Sunlight Congress API</a> </small></p>";
		}
}

function wpcongress_geocode($address) {
	$url = "http://rpc.geocoder.us/service/csv?address=".urlencode($address);
	$geo = get_contents($url);
	$loc = explode(",",$geo);
	if($loc[0] == "2: couldn't find this address! sorry") {
		echo "<p>Address not found, please try again.</p>";
		include('lookupform.php');
	} 
	else {
		// get legislators from geocoded data
		wpcongress_getlegislators($loc[0],$loc[1]);
	}
}
// get legislators for lat long
function wpcongress_getlegislators($lat,$lon) {
$sunlight_api_key = get_option('sunlight_api_key');
$congress = wpcongress_cache("http://services.sunlightlabs.com/api/legislators.allForLatLong.json?apikey=".$sunlight_api_key."&latitude=".$lat."&longitude=".$lon);
		foreach ($congress->response->legislators as $c) {
			echo "<h3 class='legislator'>".$c->legislator->firstname." ".$c->legislator->lastname." <small>(".$c->legislator->state." ".$c->legislator->district.")</small></h3>";
			echo "<ul class='legislator-contact'><li>phone: ".$c->legislator->phone."</li><li>fax: ".$c->legislator->fax."</li><li>webform: <a href='".$c->legislator->webform."'>".$c->legislator->webform."</a></li></ul>";
		} 
	wpcongress_credit();
}

// get legislators by state
function wpcongress_getlegislatorsstate($state) {
$sunlight_api_key = get_option('sunlight_api_key');
$congress = wpcongress_cache("http://services.sunlightlabs.com/api/legislators.getList.json?apikey=".$sunlight_api_key."&state=".$state);
		foreach ($congress->response->legislators as $c) {
			echo "<h3 class='legislator'>".$c->legislator->firstname." ".$c->legislator->lastname." <small>(".$c->legislator->state." ".$c->legislator->district.")</small></h3>";
			echo "<ul class='legislator-contact'><li>phone: ".$c->legislator->phone."</li><li>fax: ".$c->legislator->fax."</li><li>webform: <a href='".$c->legislator->webform."'>".$c->legislator->webform."</a></li></ul>";
		} 
}

// get specific legislator
function wpcongress_getlegislator($id) {
	if(empty($id)) { echo "<p>No ID Found</p>"; }
	$sunlight_api_key = get_option('sunlight_api_key');
	$c = wpcongress_cache("http://drumbone.services.sunlightlabs.com/v1/api/legislator.json?apikey=".$sunlight_api_key."&bioguide_id=".$id);
	$bills = wpcongress_cache("http://drumbone.services.sunlightlabs.com/v1/api/bills.json?apikey=".$sunlight_api_key."&sponsor_id=".$id."&per_page=5");
	$bills2 = wpcongress_cache("http://drumbone.services.sunlightlabs.com/v1/api/bills.json?apikey=".$sunlight_api_key."&cosponsor_ids=".$id."&per_page=5");
	//print_r($c);
	//print_r($bills);
	include('legislator.php');
}

// get specific bill
function wpcongress_getbill($id) {
	if(empty($id)) { echo "<p>No ID Found</p>"; }
	$sunlight_api_key = get_option('sunlight_api_key');
	$b = wpcongress_cache("http://drumbone.services.sunlightlabs.com/v1/api/bill.json?apikey=".$sunlight_api_key."&bill_id=".$id);
	//print_r($c);
	//print_r($b);
	include('bill.php');
}

// get roll call
function wpcongress_getroll($id) {
	if(empty($id)) { echo "<p>No ID Found</p>"; }
	$sunlight_api_key = get_option('sunlight_api_key');
	$b = wpcongress_cache("http://drumbone.services.sunlightlabs.com/v1/api/roll.json?apikey=".$sunlight_api_key."&roll_id=".$id);
	//print_r($b);
	include('roll.php');
}

// print form when shortcode found
function wpcongress_createform($attr) {
	if ( isset($_POST['wpcongress-submit']) ) {
	wpcongress_geocode($_POST['street'].", ".$_POST['city'].", ".$_POST['state']." ".$_POST['zipcode']);
		}
		else {
		include('lookupform.php');
		}
}
// print browse when shortcode found
function wpcongress_createbrowse($attr) {
	if ( isset($_POST['go']) ) {
	wpcongress_getlegislatorsstate($_POST['state']);
		}
		else {
		include('browse.php');
		}
}

// print legislator box
function wpcongress_createmoc ($attr) {
	wpcongress_getlegislator($attr['id']);
}

function wpcongress_createbill ($attr) {
	wpcongress_getbill($attr['id']);
}

function wpcongress_createroll ($attr) {
	wpcongress_getroll($attr['id']);
}


function wpcongress_activate() {
if(!get_option("sunlight_api_key")) {
	add_option("sunlight_api_key", '', '', 'yes');
}
add_option("wpcongress_credit", '0', '', 'yes');
add_option("wpcongress_ajax", '0', '', 'yes');
add_option("wpcongress_cache", '0', '', 'yes');
add_option("wpcongress_curl", '0', '', 'yes');

}
function wpcongress_deactivate() {
delete_option("wpcongress_credit");
}


function wpcongress_stylesheet() {
        $myStyleUrl = WP_PLUGIN_URL . '/wpcongress/style.css';
        $myStyleFile = WP_PLUGIN_DIR . '/wpcongress/style.css';
        if ( file_exists($myStyleFile) ) {
            wp_register_style('wpcongressstyle', $myStyleUrl);
            wp_enqueue_style( 'wpcongressstyle');
        }
    }

// filegrab option
function get_contents($url) {
	// if curl is enabled
	if(get_option('wpcongress_curl') == '1') {
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    ob_start();
    curl_exec ($ch);
    curl_close ($ch);
    $string = ob_get_contents();
    ob_end_clean(); 
    return $string;     	}
    // otherwise
    else {  $string = file_get_contents($url); return $string; }
}

// simple caching for geo/api data
function wpcongress_cache($url,$json=TRUE, $timeout=43200) {
	$base = '/tmp/';
	if(get_option('wpcongress_cache') == '1') {
  		if(!file_exists($base.md5($url)) || filemtime($base.md5($url)) < (time()-$timeout)) {
    		if($json==TRUE) { 
    	   	 $stream =  json_decode(get_contents($url));
   			 } else {
   			 $stream =  get_contents($url);
    		}
   		 $tmp = tempnam('/tmp','wpcongress-cache');
    	 file_put_contents($tmp, $stream);
         rename($tmp, md5($url));
     	 return $stream;
  		 } else {
 		  $meh=get_contents($base.md5($url));
  		  return $meh;
 		 }
 	} else {
 		    $stream =  json_decode(get_contents($url));
 		    return $stream;
 	}
}
// test everything
function wpcongress_debug($url) {
	$address= "100 polk, san francisco,ca";
	echo "<h3>WPCongress Debugging</h3>";
	// test caching
	echo "<p><strong>Cache:</strong>";
   	file_put_contents('/tmp/wpcongresstest', "Works");
    echo file_get_contents('/tmp/wpcongresstest');
    // test file get contents
    echo "</p><p><strong>file_get_contents: </strong>";
    $testfgc = file_get_contents("http://google.com");
    if(empty($testfgc)) { echo "doesn't work"; } else { echo "works"; }
    // test CURL
    echo "</p><p><strong>CURL: </strong>";
	$ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, "http://google.com");
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    ob_start();
    curl_exec ($ch);
    curl_close ($ch);
    $testcurl = ob_get_contents();
    ob_end_clean();     
    if(empty($testcurl)) { echo "doesn't work"; } else { echo "works"; }
    // test connection to geocoder
	echo "</p><p><strong>Geocoder:</strong> (comma separated geo data)<br/>";
	echo get_contents("http://rpc.geocoder.us/service/csv?address=".urlencode($address));
	// test sunlight foundation data
	echo "</p><strong>Sunlight Data</strong><br />";
	wpcongress_getlegislators("37.777511","-122.418041");
		echo "</p><strong>Sunlight Data</strong><br />";

}
//
// sidebar widget
//
class wpcongress_widget extends WP_Widget {
	function wpcongress_widget() {
		// widget actual processes
		 parent::WP_Widget(false, $name = 'WPCongress');	
	}

	function form($instance) {
		// outputs the options form on admin
		$title = esc_attr($instance['title']);
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <?php 
	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        return $instance;
	}

	function widget($args, $instance) {
		// outputs the content of the widget
		      extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        if(empty($title)) { $title = "Congress"; }
		     echo "<li id='wpcongress2'><h3 class='widget-title'>$title</h3>";
   			wpcongress_createform('');  
   			 echo "</li>";
	}

}

add_action('widgets_init', create_function('', 'return register_widget("wpcongress_widget");'));

// activate and inactivation hooks
register_activation_hook( __FILE__, 'wpcongress_activate' );
register_deactivation_hook( __FILE__, 'wpcongress_deactivate' );

// when you add wpcongress to a post, it prints the forms
add_shortcode( 'wpcongress_debug', 'wpcongress_debug' );
add_shortcode( 'wpcongress_form', 'wpcongress_createform' );
add_shortcode( 'wpcongress_browse', 'wpcongress_createbrowse' );
add_shortcode( 'wpcongress_legislator', 'wpcongress_createmoc' );
add_shortcode( 'wpcongress_bill', 'wpcongress_createbill' );
add_shortcode( 'wpcongress_roll', 'wpcongress_createroll' );

// 
// if both logged in and not logged in users can send this AJAX request,
// add both of these actions, otherwise add only the appropriate one
add_action( 'wp_ajax_nopriv_myajax-submit', 'wpcongress_createform' );
add_action( 'wp_ajax_myajax-submit', 'wpcongress_createform' );


// init 
add_action('init', 'wpcongress_init');

add_action('wp_print_styles', 'wpcongress_stylesheet');

?>
