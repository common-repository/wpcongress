v
<div class="wrap">
<h2><?php _e('WPCongress Configuration'); ?></h2>
<div class="narrow">
<form action="" method="post" id="wpcongress-conf" style="margin: auto; width: 400px; ">
<?php if ( !$sunlight_api_key ) { ?>
	<p><?php printf(__('WP Congress can allow your visitors to find the contact information of their Senators and Represenatives. It is powered by the Sunlight Foundation and Geocoder.US.'), 'http://sunlightlabs.com/', 'http://services.sunlightlabs.com/accounts/register/'); ?></p>

<h3><label for="key"><?php _e('Sunlight API Key'); ?></label></h3>
<p>Your current key: <?php echo get_option('sunlight_api_key','nothing here'); ?>
<p><input id="key" name="key" type="text" size="50" maxlength="80" value="<?php echo get_option('sunlight_api_key'); ?>" style="font-family: 'Courier New', Courier, mono; font-size: 1.5em;" /></p><p>(<?php _e('<a href="http://services.sunlightlabs.com/accounts/register/">I still need one!</a>'); ?>)</p>
<p><input id="credit" name="credit" type="checkbox" <?php if(get_option('wpcongress_credit')) { echo "checked='checked'"; } ?>  /> Display "Powered by WPCongress" credit link.</p>
<p><input id="curl" name="curl" type="checkbox" <?php if(get_option('wpcongress_curl')) { echo "checked='checked'"; } ?>  />Use CURL to grab API data (Sometimes works around weird server settings)</p>
<p><input id="ajax" name="ajax" type="checkbox" <?php if(get_option('wpcongress_ajax')) { echo "checked='checked'"; } ?>  /> Enable Ajax Forms (Experimental)</p>
<p><input id="cache" name="cache" type="checkbox" <?php if(get_option('wpcongress_cache')) { echo "checked='checked'"; } ?>  /> Enable Cache (Experimental)</p>
<?php } ?>
	<p class="submit"><input type="submit" name="submit" value="<?php _e('Update options &raquo;'); ?>" /></p>
</form>
</div>
</div>