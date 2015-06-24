<?php

/**
 * Add the options page
 *
 * @since 0.1
 */

add_action( 'admin_menu', 'wdw_menu' );

function wdw_menu() {
	global $wdw_menu_page;

	$wdw_menu_page = add_options_page( 
		__( 'Delicious Wishlist for WordPress Options', 'wp-delicious-wishlist' ), // The title of the displayed page
		__( 'Delicious Wishlist', 'wp-delicious-wishlist' ),                            // The title in the admin sidebar
		'manage_options',                                                          // Who can modify this options
		'wdw-options',                                                             // The slug of this options page
		'wdw_options_page' );                                                      // The callback function to create the options page

	// Adds my_help_tab when my_admin_page loads
    add_action('load-' . $wdw_menu_page, 'wdw_contextual_help');
}

/**
 * Add a contextual help tab
 */

function wdw_contextual_help() {
	global $wdw_menu_page;

	// Text to display
	$text  = '<p><strong>' . __( 'USER GUIDE', 'wp-delicious-wishlist' ) . '</strong></p>';
	$text .= '<p><strong>' . __( 'Installation', 'wp-delicious-wishlist' ) . '</strong></p>';
	$text .= '<p>' . __( 'This plugin allows you to publish in your blog a wishlist using your Delicious bookmarks. In order to make this, when you visit a web page with something you like, tag that page with two different bookmarks: <code>wishlist</code> and, if it is very important, <code>***</code> (three stars). Then, when you visit a page with something less important, you could use <code>wishlist</code> and <code>**</code> (two stars), and finally for a page with something even less important, you could use <code>wishlist</code> and <code>*</code> (one star). It\'s not mandatory to use these exact tags: you can choose your own tags, but consider that you have to bookmark a page with at least two different tags: one general to collect all your bookmarks relative to your wishlist, and another to mark that page depending on the importance of the stuff for you.', 'wp-delicious-wishlist' ) . '</p>';
	$text .= '<p>' . __( 'When you are done with an item (you have bought it or someone gave it to you as a gift), you can edit that bookmark on Delicious and remove the star(s), leaving only the main tag (e.g., <code>wishlist</code>), so you can maintain in Delicious an archive of all desired items.', 'wp-delicious-wishlist' ) . '</p>';
	$text .= '<p>' . __( 'To start, fill in the fields in the form below. The values are not case sensitive.', 'wp-delicious-wishlist' ) . '</p>';
	$text .= '<p>' . __('When you are done filling those fields, clic on the "Save Changes" button, create a new page, and give it a title you want. In the body of the page, paste the following shortcode:', 'wp-delicious-wishlist' );
	$text .= '<p><pre>[my-delicious-wishlist]</pre></p>';
	$text .= '<p>' . __( 'You can add some text before and/or after the shortcode. Save the page and preview it. If you are satisfied, publish it!', 'wp-delicious-wishlist' ) . '</p>';
	$text .= '<p><strong>' . __( 'The widget', 'wp-delicious-wishlist' ) . '</strong></p>';
	$text .= '<p>' . __( 'Do not forget to check out the special widget in the Widget page!', 'wp-delicious-wishlist' ) . '</p>';
	$text .= '<p><strong>' . __( 'Changing the style of the Wishlist page', 'wp-delicious-wishlist' ) . '</strong></p>';
	$text .= '<p>' . __( 'The page is stylized using the css file included in the plugin directory. If you want to restyle the page, you can put a css file in the root directory of the theme you are using, create your styles, and name it <code>wdw.css</code>. All future versions of this plugin will load only your own css file.', 'wp-delicious-wishlist' ) . '</p>';
	$text .= '<p><strong>' . __( 'For more information:', 'wp-delicious-wishlist' ) . '</strong></p>';
	$text .= '<ul>';
	$text .= '<li><a href="http://www.aldolat.it/wordpress/wordpress-plugins/delicious-wishlist-for-wordpress/">' . __( 'Plugin\'s Page', 'wp-delicious-wishlist' ) . '</a></li>';
	$text .= '<li><a href="http://www.aldolat.it/support/forum/51">' . __( 'Support Forums', 'wp-delicious-wishlist' ) . '</a></li>';
	$text .= '</ul>';
	
	$screen = get_current_screen();
	$screen->add_help_tab( array(
		'id'      => 'wdw-help', 
		'title'   => 'Delicious Whishlist for WordPress Help', 
		'content' => $text
	) );
}

/**
 * Load the options page
 *
 * @since 0.1
 * @since 0.5 Alternative feeds
 * @since 1.0 Use or not the plugin CSS file
 */

function wdw_options_page() { ?>

	<div class="wrap">
		<h2><?php _e('Delicious Wishlist for WordPress Options', 'wp-delicious-wishlist'); ?></h2>

		<p>
			<strong>
				<?php _e( 'The User Guide is located at the top of this page: click on the Help button.', 'wp-delicious-wishlist' ); ?>
			</strong>
			<br />
			<?php printf( __( 'You are running the version %s of this plugin.', 'wp-delicious-wishlist' ), WDW_VERSION ); ?>
		</p>

		<div class="clear"></div>

		<div id="poststuff" style="width: 830px;">

			<div style="float: right; width: 255px;">

				<div class="postbox">
					<h3 style="cursor: default;"><?php _e('Support me!', 'wp-delicious-wishlist'); ?></h3>
					<div class="inside">
						<p><?php _e('If you find this plugin useful, please help me continuing to develop it.', 'wp-delicious-wishlist'); ?></p>
						<p><?php _e('The easiest way to do this is to make a donation via PayPal, a well-known and secure method to make me happy!', 'wp-delicious-wishlist'); ?></p>
						<form style="text-align: center" action="https://www.paypal.com/cgi-bin/webscr" method="post">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="11189816">
							<input type="image" src="https://www.paypal.com/it_IT/IT/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="<?php _e('PayPal - The safer, easier way to pay online!', 'wp-delicious-wishlist'); ?>">
							<img alt="" border="0" src="https://www.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1">
						</form>
						<p style="text-align: center;">
							<a style="font-weight: bold;" href="http://www.aldolat.it/info/wishlist/">
								<?php _e('If you want, you may also visit my wishlist.', 'wp-delicious-wishlist').' &rarr;'; ?>
							</a>
						</p>
					</div>
				</div>
				<!-- close Support Me -->

				<div class="postbox">
					<h3 style="cursor: default;"><?php _e('Help & feedback', 'wp-delicious-wishlist'); ?></h3>
					<div class="inside">
						<p>
							<?php printf( __('<strong>Need help?</strong> %1$sVisit my forums%2$s (you can write in English too) or visit the %3$sOfficial WordPress Forums%2$s.', 'wp-delicious-wishlist'), '<a href="http://www.aldolat.it/support/forum/51">', '</a>', '<a href="http://wordpress.org/tags/delicious-wishlist-for-wordpress?forum_id=10">' ); ?>
						</p>
						<p>
							<?php printf( __('<strong>Want to give a feedback?</strong> Come on %smy blog%s and drop a comment. It will be very appreciated.', 'wp-delicious-wishlist'), '<a href="http://www.aldolat.it/wordpress/wordpress-plugins/delicious-wishlist-for-wordpress/">', '</a>' ); ?>
						</p>
						<p>
							<?php printf( __('You can also <strong>rate this plugin</strong> on the %sWordPress plugins page%s.', 'wp-delicious-wishlist'), '<a href="http://wordpress.org/extend/plugins/delicious-wishlist-for-wordpress/">', '</a>' ); ?>
						</p>
					</div>
				</div>
				<!-- close Help & Feedback -->

				<div class="postbox">
					<h3 style="cursor: default;"><?php _e('Uninstall info', 'wp-delicious-wishlist'); ?></h3>
					<div class="inside">
						<p>
							<?php _e('If you decide to uninstall this plugin, it will delete any options it created, so to clean the database. No further user action is required. Deactivating the plugin, however, will not erase any data.', 'wp-delicious-wishlist'); ?>
						</p>
					</div>
				</div>
				<!-- close Uninstall Info -->

				<div class="postbox">
					<h3 style="cursor: default;"><?php _e('Credits', 'wp-delicious-wishlist'); ?></h3>
					<div class="inside">
						<p>
							<?php printf( __('My thanks go to all people who contributed in revisioning and helping me in any form, and in particular to %1$s and to %2$s for their great idea behind this work.', 'wp-delicious-wishlist'), '<a href="http://www.nicoladagostino.net/">Nicola D\'Agostino</a>', '<a href="http://suzupearl.com/">Barbara Arianna Ripepi</a>' ); ?>
						</p>
					</div>
				</div>
				<!-- close Credits -->

			</div>
			<!-- close container right -->

			<div style="width: 560px;">

				<form method="post" action="options.php">

					<div class="postbox">
						<h3 style="cursor: default;"><?php _e('Core Settings', 'wp-delicious-wishlist'); ?></h3>
						<div class="inside">
							<p>
								<?php _e('These are the main options and it\'s mandatory to set them up.', 'wp-delicious-wishlist'); ?>
							</p>
							<?php
								settings_fields( 'wdw-options-group' );
								$wdws = (array) get_option( 'wdw_options' );
							?>
							<table class="widefat" style="clear: none;">
								<tr valign="top" class="alternate">
									<th scope="row">
										<?php _e('Delicious Username', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_nickname]" value="<?php if( isset( $wdws['wdw_delicious_nickname'] ) ) echo esc_attr( $wdws['wdw_delicious_nickname'] ); ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<?php _e('Main Delicious Wishlist Tag', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_tag_wishlist]" value="<?php if( isset( $wdws['wdw_delicious_tag_wishlist'] ) ) echo esc_attr( $wdws['wdw_delicious_tag_wishlist'] ); ?>" />
									</td>
								</tr>
								<tr valign="top" class="alternate">
									<th scope="row">
										<?php _e('Title for "Most Wanted" section', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_title_high]" value="<?php if( isset( $wdws['wdw_delicious_title_high'] ) ) echo esc_attr( $wdws['wdw_delicious_title_high'] ); ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<?php _e('Delicious "Most Wanted" Tag', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_tag_high]" value="<?php if( isset( $wdws['wdw_delicious_tag_high'] ) ) echo esc_attr( $wdws['wdw_delicious_tag_high'] ); ?>" />
									</td>
								</tr>
								<tr valign="top" class="alternate">
									<th scope="row">
										<?php _e('Title for "Medium Wanted" section', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_title_medium]" value="<?php if( isset( $wdws['wdw_delicious_title_medium'] ) ) echo esc_attr( $wdws['wdw_delicious_title_medium'] ); ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<?php _e('Delicious "Medium Wanted" Tag', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_tag_medium]" value="<?php if( isset( $wdws['wdw_delicious_tag_medium'] ) ) echo esc_attr( $wdws['wdw_delicious_tag_medium'] ); ?>" />
									</td>
								</tr>
								<tr valign="top" class="alternate">
									<th scope="row">
										<?php _e('Title for "Low Wanted" section', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_title_low]" value="<?php if( isset( $wdws['wdw_delicious_title_low'] ) ) echo esc_attr( $wdws['wdw_delicious_title_low'] ); ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<?php _e('Delicious "Low Wanted" Tag', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_tag_low]" value="<?php if( isset( $wdws['wdw_delicious_tag_low'] ) ) echo esc_attr( $wdws['wdw_delicious_tag_low'] ); ?>" />
									</td>
								</tr>
							</table>

							<p class="submit" style="padding: 0.5em 0;">
								<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'wp-delicious-wishlist'); ?>" />
							</p>

						</div>
					</div>
					<!-- close postbox core settings -->

					<div class="postbox">
						<h3 style="cursor: default;"><?php _e('Optional Settings', 'wp-delicious-wishlist'); ?></h3>
						<div class="inside">
							<p>
								<?php _e('These options are not mandatory: it\'s up to you to set them up.', 'wp-delicious-wishlist'); ?>
							</p>

							<table class="widefat" style="clear: none;">
								<tr valign="top">
									<th scope="row">
										<?php printf( __('How many items%1$s(max 100)%2$s', 'wp-delicious-wishlist'), '<br /><small>', '</small>' ); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_howmany]" value="<?php if( isset( $wdws['wdw_delicious_howmany'] ) ) echo esc_attr( $wdws['wdw_delicious_howmany'] ); else echo '5'; ?>" />
									</td>
								</tr>
								<tr valign="top" class="alternate">
									<th scope="row">
										<?php printf( __('Feed cache time%1$s(in seconds, min 3600)%2$s', 'wp-delicious-wishlist'), '<br /><small>', '</small>' ); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_cache]" value="<?php if( isset( $wdws['wdw_delicious_cache'] ) ) echo esc_attr( $wdws['wdw_delicious_cache'] ); ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<?php _e('HTML element for titles', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<select name="wdw_options[wdw_title_element]">
											<?php $wdwTitleElement = isset( $wdws['wdw_title_element'] ) ? $wdws['wdw_title_element'] : 'h3'; ?>
											<option <?php selected( 'h1', $wdwTitleElement ) ; ?> value="h1">
												<?php _e('H1', 'wp-delicious-wishlist'); ?>
											</option>
											<option <?php selected( 'h2', $wdwTitleElement ); ?> value="h2">
												<?php _e('H2', 'wp-delicious-wishlist'); ?>
											</option>
											<option <?php selected( 'h3', $wdwTitleElement ); ?> value="h3">
												<?php _e('H3', 'wp-delicious-wishlist'); ?>
											</option>
											<option <?php selected( 'h4', $wdwTitleElement ); ?> value="h4">
												<?php _e('H4', 'wp-delicious-wishlist'); ?>
											</option>
											<option <?php selected( 'h5', $wdwTitleElement ); ?> value="h5">
												<?php _e('H5', 'wp-delicious-wishlist'); ?>
											</option>
											<option <?php selected( 'div', $wdwTitleElement ); ?> value="div">
												<?php _e('DIV', 'wp-delicious-wishlist'); ?>
											</option>
											<option <?php selected( 'span', $wdwTitleElement ); ?> value="span">
												<?php _e('SPAN', 'wp-delicious-wishlist'); ?>
											</option>
										</select>
									</td>
								</tr>
								<tr valign="top" class="alternate">
									<th scope="row">
										<?php _e('Icons style', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<select name="wdw_options[wdw_delicious_icons]">
											<?php $my_wdw_style = $wdws['wdw_delicious_icons']; ?>
											<option <?php selected('stars', $my_wdw_style); ?> value="stars">
												<?php _e('Stars', 'wp-delicious-wishlist'); ?>
											</option>
											<option <?php selected('faces', $my_wdw_style); ?> value="faces">
												<?php _e('Smilies', 'wp-delicious-wishlist'); ?>
											</option>
										</select>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<?php printf( __('Truncate tag description%1$s(in characters, 0 = do not truncate)%2$s', 'wp-delicious-wishlist'), '<br /><small>', '</small>' ); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_truncate]" value="<?php if( isset( $wdws['wdw_delicious_truncate'] ) ) echo esc_attr( $wdws['wdw_delicious_truncate'] ); else echo '0'; ?>" />
									</td>
								</tr>
								<tr valign="top" class="alternate">
									<th scope="row">
										<?php _e('Read More text', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_more]" value="<?php if( isset( $wdws['wdw_delicious_more'] ) ) echo esc_attr( $wdws['wdw_delicious_more'] ); else _e( 'Read more', 'wp-delicious-wishlist' ); ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<?php _e('Use the CSS of the plugin', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input type="checkbox" value="1" name="wdw_options[wdw_css]" id="wdw_css" <?php if( isset( $wdws['wdw_css'] ) ) checked( $wdws['wdw_css'] ); ?> />
									</td>
								</tr>
								<tr valign="top" class="alternate">
									<th scope="row">
										<?php _e('Link to the author', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input type="checkbox" value="1" name="wdw_options[wdw_backlink]" id="wdw_backlink" <?php if( isset( $wdws['wdw_backlink'] ) ) checked( $wdws['wdw_backlink'] ); ?> />
									</td>
								</tr>
							</table>
							<p class="submit" style="padding: 0.5em 0;">
								<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'wp-delicious-wishlist'); ?>" />
							</p>
						</div>
					</div>
					<!-- close postbox optional settings -->

					<div class="postbox">
						<h3 style="cursor: default;"><?php _e('Bookmark Settings', 'wp-delicious-wishlist'); ?></h3>
						<div class="inside">
							<p>
								<?php _e('These options are not mandatory: it\'s up to you to set them up.', 'wp-delicious-wishlist'); ?>
							</p>

							<table class="widefat" style="clear: none;">
								<tr valign="top">
									<th scope="row">
										<?php _e('Display date', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input type="checkbox" value="1" name="wdw_options[wdw_date]" id="wdw_date" <?php if( isset( $wdws['wdw_date'] ) ) checked( $wdws['wdw_date'] ); ?> />
									</td>
								</tr>
								<tr valign="top" class="alternate">
									<th scope="row">
										<?php _e('Text before date', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_pre_date]" value="<?php if( isset( $wdws['wdw_delicious_pre_date'] ) ) echo esc_attr( $wdws['wdw_delicious_pre_date'] ); ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<?php _e('Display tags...', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input type="checkbox" value="1" name="wdw_options[wdw_tags]" id="wdw_tags" <?php if( isset( $wdws['wdw_tags'] ) ) checked( $wdws['wdw_tags'] ); ?> />
									</td>
								</tr>
								<tr valign="top" class="alternate">
									<th scope="row">
										<?php _e('... but do not display my Wishlist tags', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input type="checkbox" value="1" name="wdw_options[wdw_remove_tags]" id="wdw_remove_tags" <?php if( isset( $wdws['wdw_remove_tags'] ) ) checked( $wdws['wdw_remove_tags'] ); ?> />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<?php _e('Text before tags list', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_pre_tags]" value="<?php if( isset( $wdws['wdw_delicious_pre_tags'] ) ) echo esc_attr( $wdws['wdw_delicious_pre_tags'] ); ?>" />
									</td>
								</tr>
								<tr valign="top" class="alternate">
									<th scope="row">
										<?php _e('Text before each tag', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_pre_tag]" value="<?php if( isset( $wdws['wdw_pre_tag'] ) ) echo esc_attr( $wdws['wdw_pre_tag'] ); ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<?php _e('Tag Separator', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<select name="wdw_options[wdw_tag_sep]">
											<?php $wdwTagSep = isset( $wdws['wdw_tag_sep'] ) ? $wdws['wdw_tag_sep'] : 'space'; ?>
											<option <?php selected( 'space', $wdwTagSep ); ?> value="space">
												<?php _e('Space', 'wp-delicious-wishlist'); ?>
											</option>
											<option <?php selected( 'comma', $wdwTagSep ); ?> value="comma">
												<?php _e('Comma', 'wp-delicious-wishlist'); ?>
											</option>
											<option <?php selected( 'comma-space', $wdwTagSep ); ?> value="comma-space">
												<?php _e('Comma and Space', 'wp-delicious-wishlist'); ?>
											</option>
										</select>
									</td>
								</tr>
								<tr valign="top" class="alternate">
									<th scope="row">
										<?php _e('Sort Tags in alphabetical order', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input type="checkbox" value="1" name="wdw_options[wdw_sort_tag]" id="wdw_css" <?php if( isset( $wdws['wdw_sort_tag'] ) ) checked( $wdws['wdw_sort_tag'] ); ?> />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<?php _e('Display Section', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input type="checkbox" value="1" name="wdw_options[wdw_section]" id="wdw_css" <?php if( isset( $wdws['wdw_section'] ) ) checked( $wdws['wdw_section'] ); ?> />
									</td>
								</tr>
								<tr valign="top" class="alternate">
									<th scope="row">
										<?php _e('Text before section', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_pre_section]" value="<?php if( isset( $wdws['wdw_pre_section'] ) ) echo esc_attr( $wdws['wdw_pre_section'] ); ?>" />
									</td>
								</tr>
							</table>
							<p class="submit" style="padding: 0.5em 0;">
								<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'wp-delicious-wishlist'); ?>" />
							</p>

						</div>

					</div>
					<!-- close postbox tag settings -->

					<div class="postbox">
						<h3 style="cursor: default;"><?php _e('Alternative feed source', 'wp-delicious-wishlist'); ?></h3>
						<div class="inside">
							<p>
								<?php _e('If you experience problems in fetching your feeds directly from Delicious, you can use another service that fetches your feeds for you (such as FeedBurner or Yahoo! Pipes or other services). Enter here the alternative feed URLs, that this plugin will use instead of Delicious\' feeds.', 'wp-delicious-wishlist'); ?>
							</p>

							<table class="widefat" style="clear: none;">

								<tr valign="top" class="alternate">
									<th scope="row">
										<?php _e('Feed for High Tag section:', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_alt_feed_ht]" value="<?php if( isset( $wdws['wdw_delicious_alt_feed_ht'] ) ) echo esc_url( $wdws['wdw_delicious_alt_feed_ht'] ); ?>" />
									</td>
								</tr>

								<tr valign="top">
									<th scope="row">
										<?php _e('Feed for Medium Tag section:', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_alt_feed_mt]" value="<?php if( isset( $wdws['wdw_delicious_alt_feed_mt'] ) ) echo esc_url( $wdws['wdw_delicious_alt_feed_mt'] ); ?>" />
									</td>
								</tr>

								<tr valign="top" class="alternate">
									<th scope="row">
										<?php _e('Feed for Low Tag section:', 'wp-delicious-wishlist'); ?>
									</th>
									<td>
										<input style="width: 100%;" type="text" name="wdw_options[wdw_delicious_alt_feed_lt]" value="<?php if( isset( $wdws['wdw_delicious_alt_feed_lt'] ) ) echo esc_url( $wdws['wdw_delicious_alt_feed_lt'] ); ?>" />
									</td>
								</tr>

							</table>

							<p class="submit" style="padding: 0.5em 0;">
								<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'wp-delicious-wishlist'); ?>" />
							</p>
						</div>
					</div>
					<!-- close postbox alternative feed source -->

				</form>
				<!-- close form -->

			</div>
			<!-- close container left -->

		</div>
		<!-- close poststuff -->

	</div>
	<!-- close wrap -->

<?php }

