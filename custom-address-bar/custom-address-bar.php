<?php
	/**
	* Plugin Name: Custom address bar
	* Plugin URI: http://127.0.0.1
	* Description: Wtyczka zmieniająca kolor paska adresu na urządzeniach mobilnych (chrome & safari)
	* Version: 1.0
	
	* Author: Tymoteusz `RazorMeister` Bartnik
	* Author URI: http://razormeister.pl
	
	* License: GPLv3
	* License URI: http://www.gnu.org/licenses/gpl-3.0.html
	**/

if( !defined('ABSPATH') ) exit;
	
class CustomAddressBar
{
	public function __construct() {
		add_action('wp_head', [$this, 'addMetaTags'], 1);
		if (is_admin()) {
			add_action('admin_init', [$this, 'registerSettings']);
			add_action('admin_menu', [$this, 'registerSettingsPage']);
		}
	}
	
	public function registerSettings() {
		register_setting('customAddressBar_settings_group', 'customAddressBar_color');
	}
	
	public function registerSettingsPage() {
		add_options_page('Zmień kolor', 'Custom Address Bar', 'manage_options', 'CustomAddressBar', [$this, 'showSettingsPage']);
	}
	
	public function showSettingsPage() {
		?>
		<div>
			<?php screen_icon(); ?>
			<form method="post" action="options.php">
				<?php settings_fields( 'customAddressBar_settings_group' ); ?>
				<h3>Wpisz kolor</h3>
				<p>Poniżej wpisz kolor, który ma posiadać pasek adresu na urządzeniach mobilnych.</p>
				<table>
					<tr valign="top">
						<th scope="row"><label for="customAddressBar_color">Kolor (HEX)</label></th>
						<td><input type="text" id="customAddressBar_color" name="customAddressBar_color" value="<?php echo get_option('customAddressBar_color'); ?>" /></td>
					</tr>
					<tr>
						<th scope="row">Obecny kolor</th>
						<td><div style="width: 30px; height: 30px; background-color: <?php echo get_option('customAddressBar_color'); ?>"></div></td>
					</tr>
				</table>
				<?php  submit_button(); ?>
			</form>
		</div>
		<?php
	}
	
	public function addMetaTags() {
		$color = get_option('customAddressBar_color');
		$this->headerComment();
		echo '<meta name="theme-color" content="'.$color.'">';	
		echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">';
		$this->footerComment();
	}
	
	private function headerComment() {
		echo '<!-- CustomAdressBar START -->';	
	}
	
	private function footerComment() {
		echo '<!-- CustomAdressBar END -->';	
	}
}

$customAddressBar = new CustomAddressBar();
	
?>
