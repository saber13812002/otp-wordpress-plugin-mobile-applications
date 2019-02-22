<?php
/*
Plugin Name: otp2
Description: otp 
Plugin URI: http://www.berimbasket.ir/
Version: 0.0.1
Author: berimbasket.IR
Author URI: http://www.berimbasket.ir/
License: berimbasket.IR
*/



if (!defined('my_THEME_DIR'))
    define('my_THEME_DIR', ABSPATH . 'wp-content/themes/' . get_template());

if (!defined('my_PLUGIN_NAME'))
    define('my_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('my_PLUGIN_DIR'))
    define('my_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . my_PLUGIN_NAME);

if (!defined('my_PLUGIN_URL'))
    define('my_PLUGIN_URL', WP_PLUGIN_URL . '/' . my_PLUGIN_NAME);


    

function plugin_otp_page_add_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=custom-setting-page-identifier">' . __('Settings') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'plugin_otp_page_add_settings_link');

/* Add Custom Admin Menu */
add_action('admin_menu', 'custom_otp_page_menu');
add_action('admin_init', 'reg_otp_page_settings');

function reg_otp_page_settings()
{
	
    register_setting('otp-page-group', 'server_name_text');
    register_setting('otp-page-group', 'dbname_text');
    register_setting('otp-page-group', 'dbuser_text');
    register_setting('otp-page-group', 'dbpass_text');
    
    register_setting('otp-page-group', 'kavenegartoken_text');
    register_setting('otp-page-group', 'telegram_bot_token_text');

    register_setting('otp-page-group', 'is_telegram_log_enabled');
    register_setting('otp-page-group', 'is_password_md5_or_cas_algorithm');
    register_setting('otp-page-group', 'password_generator_api_url');

};

function custom_otp_page_menu()
{
    add_options_page('SimplePOS setting page Options', 'SimplePOS setting page Options', 'manage_options', 'custom-setting-page-identifier', 'custom_registration_page_options');
}

function custom_registration_page_options()
{
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    ?>

    <div>
        <?php screen_icon();?>
        <h2>Custom train page Options:</h2>

        <form method="post" action="options.php">
<?php
settings_fields('otp-page-group');
    do_settings_fields('otp-page-group', '');
    ?>

	<p>Enter server name</p>
	<input type="text" name="server_name_text" value="<?php echo get_option('server_name_text'); ?>" />
	<p>localhost</p>
	<hr/>

    <p>Enter dbname</p>
    <input type="text" name="dbname_text" value="<?php echo get_option('dbname_text'); ?>" />
    <p>bb_otp2</p>
    <hr/>

<p>Enter dbuser</p>
<input type="text" name="dbuser_text" value="<?php echo get_option('dbuser_text'); ?>" />
<p>root</p>
<hr/>

<p>Enter dbpass</p>
<input type="text" name="dbpass_text" value="<?php echo get_option('dbpass_text'); ?>" />
<p>empty means no password  </p>
<hr/>

<p>Enter kavenegartoken_text</p>
<input type="text" name="kavenegartoken_text" value="<?php echo get_option('kavenegartoken_text'); ?>" />
<p>2374h3475h289r498347r98y89y725y328y482575yr8274y89r5y3489r57y23847r5y8</p>
<hr/>

<p>Enter telegram_bot_token_text</p>
<input type="text" name="telegram_bot_token_text" value="<?php echo get_option('telegram_bot_token_text'); ?>" />
<p>sdfgSDFGsfgg:hfg8sdf89gs9df8s7fg7s8fgs89f7g9s79g</p>
<hr/>

<p>enter password generator url</p>
<input type="text" name="password_generator_api_url" value="<?php echo get_option('password_generator_api_url'); ?>" />
<p>https://asdf.asdf.asdf.adsf</p>
<hr/>

    <p>Enter is_telegram_log_enabled</p>
    <input type="text" name="is_telegram_log_enabled" value="<?php echo get_option('is_telegram_log_enabled'); ?>" />
    <p>1 for true - empty for false</p>
    <hr/>

    <p>Enter is_password_md5_or_cas_algorithm</p>
    <input type="text" name="is_password_md5_or_cas_algorithm" value="<?php echo get_option('is_password_md5_or_cas_algorithm'); ?>" />
    <p>1 for true</p>
    <hr/>


    <?php
    submit_button();
        ?>

            </form>
        </div>
    <?php
}