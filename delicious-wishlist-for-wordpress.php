<?php
/*
	Plugin Name: Delicious Wishlist for WordPress
	Description:  Publish a wishlist using your Delicious bookmarks
	Plugin URI: http://www.aldolat.it/wordpress/wordpress-plugins/delicious-wishlist-for-wordpress/
	Author: Aldo Latino
	Author URI: http://www.aldolat.it/
	Version: 2.5
	License: GPLv3 or later
*/

/*
	Copyright (C) 2009, 2011  Aldo Latino  (email : aldolat@gmail.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

define( 'WDW_VERSION', '2.5' );

/**
 * The function performs some checks and setup some default options.
 *
 * @since 0.4 The (deprecated) conversion of old settings
 * @since 0.5 Check of cache on plugin activation
 * @since 0.5 Add a backlink to the author (which the user can disable)
 */
function wdw_conversion() {

	// Check of cache time and, in case it is empty or below 3600 seconds, let's change it
	// These lines will be executed on plugin activation only
	// @since 0.5
	$wdw_prefs = (array) get_option( 'wdw_options' );
	if( $wdw_prefs['wdw_delicious_cache'] == '' || $wdw_prefs['wdw_delicious_cache'] < 3600 ) {
		$wdw_prefs['wdw_delicious_cache'] = 3600;
	}

	// On activation let's create some default options
	// These lines will be executed on plugin activation only
	// @since 2.3
	if( ! isset( $wdw_prefs['wdw_delicious_tag_wishlist'] ) ) $wdw_prefs['wdw_delicious_tag_wishlist'] = 'wishlist';
	if( ! isset( $wdw_prefs['wdw_title_element'] ) )          $wdw_prefs['wdw_title_element'] = 'h3';
	if( ! isset( $wdw_prefs['wdw_delicious_howmany'] ) )      $wdw_prefs['wdw_delicious_howmany'] = '5';
	if( ! isset( $wdw_prefs['wdw_delicious_truncate'] ) )     $wdw_prefs['wdw_delicious_truncate'] = '0';
	if( ! isset( $wdw_prefs['wdw_delicious_more'] ) )         $wdw_prefs['wdw_delicious_more'] = 'Read more';
	if( ! isset( $wdw_prefs['wdw_delicious_icons'] ) )        $wdw_prefs['wdw_delicious_icons'] = 'stars';
	if( ! isset( $wdw_prefs['wdw_date'] ) )                   $wdw_prefs['wdw_date'] = true;
	if( ! isset( $wdw_prefs['wdw_delicious_pre_date'] ) )     $wdw_prefs['wdw_delicious_pre_date'] = 'Saved on';
	if( ! isset( $wdw_prefs['wdw_tags'] ) )                   $wdw_prefs['wdw_tags'] = false;
	if( ! isset( $wdw_prefs['wdw_remove_tags'] ) )            $wdw_prefs['wdw_remove_tags'] = false;
	if( ! isset( $wdw_prefs['wdw_delicious_pre_tags'] ) )     $wdw_prefs['wdw_delicious_pre_tags'] = 'Tags:';
	if( ! isset( $wdw_prefs['wdw_pre_tag'] ) )                $wdw_prefs['wdw_pre_tag'] = '#';
	if( ! isset( $wdw_prefs['wdw_tag_sep'] ) )                $wdw_prefs['wdw_tag_sep'] = ' ';
	if( ! isset( $wdw_prefs['wdw_sort_tag'] ) )               $wdw_prefs['wdw_sort_tag'] = false;
	if( ! isset( $wdw_prefs['wdw_section'] ) )                $wdw_prefs['wdw_section'] = false;
	if( ! isset( $wdw_prefs['wdw_pre_section'] ) )            $wdw_prefs['wdw_pre_section'] = 'Section';
	if( ! isset( $wdw_prefs['wdw_css'] ) )                    $wdw_prefs['wdw_css'] = true;
	if( ! isset( $wdw_prefs['wdw_backlink'] ) )               $wdw_prefs['wdw_backlink'] = false;
	
	update_option( 'wdw_options', $wdw_prefs );
}
register_activation_hook( __FILE__, 'wdw_conversion' );

/**
 * Preliminary actions for creating the settings group into the database
 * and checking some core settings.
 *
 * @since 0.4
 */

function wdw_init() {
	// Create the options group into the database
	register_setting( 'wdw-options-group', 'wdw_options', 'wdw_options_validate' );

	// Check if the main options have been setup by the user, otherwise print the admin notice
	$wdws = get_option( 'wdw_options' );
	if (
		empty( $wdws['wdw_delicious_nickname']     ) ||
		empty( $wdws['wdw_delicious_tag_wishlist'] ) ||
		empty( $wdws['wdw_delicious_tag_high']     ) ||
		empty( $wdws['wdw_delicious_tag_medium']   ) ||
		empty( $wdws['wdw_delicious_tag_low']      )
	) {
		add_action( 'admin_notices', create_function( '', "echo '<div class=\"error\"><p>".sprintf( __( 'Delicious Wishlist for WordPress needs some settings on its <a href="%s">options</a> page.', 'wp-delicious-wishlist' ), admin_url( 'options-general.php?page=wdw-options' ) )."</p></div>';" ) );
	}
}

add_action( 'admin_init', 'wdw_init' );


/**
 * Add a "Settings" link to the plugins page
 *
 * @since 2.4
 */

function wdw_settings_link( $links, $file ) {
	static $this_plugin;

	if( empty( $this_plugin ) )
		$this_plugin = plugin_basename( __FILE__ );

	if ( $file == $this_plugin )
		$links[] = '<a href="' . admin_url( 'options-general.php?page=wdw-options' ) . '">' . __( 'Settings', 'wp-delicious-wishlist' ) . '</a>';

	return $links;
}

add_filter( 'plugin_action_links', 'wdw_settings_link', 10, 2 );


/**
 * Sanitize some options
 *
 * @since 0.4
 */

function wdw_options_validate( $input ) {
	// The number of feed items must be integer and not greater than 100
	$input[ 'wdw_delicious_howmany' ] = intval( $input[ 'wdw_delicious_howmany' ] );
	if( $input[ 'wdw_delicious_howmany' ] > 100 ) {
		$input[ 'wdw_delicious_howmany' ] = 100;
	}

	// Cache value must be integer and not minor than 3600
	$input[ 'wdw_delicious_cache' ] = intval( $input[ 'wdw_delicious_cache' ] );
	if( $input[ 'wdw_delicious_cache' ] < 3600 ) {
		$input[ 'wdw_delicious_cache' ] = 3600;
	}

	// Sanitize some options
	$input['wdw_delicious_nickname']     = strip_tags( $input['wdw_delicious_nickname'] );
	$input['wdw_delicious_tag_wishlist'] = strip_tags( $input['wdw_delicious_tag_wishlist'] );
	$input['wdw_delicious_title_high']   = strip_tags( $input['wdw_delicious_title_high'] );
	$input['wdw_delicious_tag_high']     = strip_tags( $input['wdw_delicious_tag_high'] );
	$input['wdw_delicious_title_medium'] = strip_tags( $input['wdw_delicious_title_medium'] );
	$input['wdw_delicious_tag_medium']   = strip_tags( $input['wdw_delicious_tag_medium'] );
	$input['wdw_delicious_title_low']    = strip_tags( $input['wdw_delicious_title_low'] );
	$input['wdw_delicious_tag_low']      = strip_tags( $input['wdw_delicious_tag_low'] );
	$input['wdw_delicious_truncate']     = intval( $input['wdw_delicious_truncate'] );
	$input['wdw_delicious_more']         = strip_tags( $input['wdw_delicious_more'] );
	$input['wdw_delicious_pre_date']     = strip_tags( $input['wdw_delicious_pre_date'] );
	$input['wdw_delicious_alt_feed_ht']  = strip_tags( $input['wdw_delicious_alt_feed_ht'] );
	$input['wdw_delicious_alt_feed_mt']  = strip_tags( $input['wdw_delicious_alt_feed_mt'] );
	$input['wdw_delicious_alt_feed_lt']  = strip_tags( $input['wdw_delicious_alt_feed_lt'] );

	return $input;
}


/**
 * Override the standard 12 hours WordPress cache time and set it to user's choice or to 1 hour minimum.
 *
 * @since 0.4
 * @param int @wdw_cache can be >= 3600
 */

function wdw_cache_time( $wdw_cache ) {
	$wdws = (array) get_option( 'wdw_options' );
	$wdw_cache = $wdws['wdw_delicious_cache'];
	if( !empty( $wdw_cache ) ) {
		// Further (and probably useless in most cases) control on cache expiry time,
		// regardless of the value stored in database
		// Delicious is very sensitive to this matter!
		if( $wdw_cache < 3600 ) {
			$wdw_cache = 3600;
		}
		return $wdw_cache;
	} else {
		return 3600;
	}
}

/**
 * The function to retrieve feed content.
 *
 * @since 2.3
 */

function wdw_fetch_bookmarks( $args ) {
	$defaults = array(
		'feed_source' => '',
		'title_class' => 'wdw_title_class',
		'wdw_maxitems' => 0,
		'wdw_title' => '',
		'list_class' => '',
		'wdw_icons' => '',
		'wdw_truncate' => '',
		'wdw_more' => '',
		'wdw_date' => false,
		'wdw_pre_date' => '',
		'wdw_tags' => false,
		'wdw_remove_tags' => '',
		'wdw_tag_wishlist' => '',
		'wdw_tag' => '',
		'wdw_sort_tag' => false,
		'wdw_pre_tags' => '',
		'wdw_pre_tag' => '',
		'wdw_tag_sep' => '',
		'wdw_section' => false,
		'wdw_pre_section' => '',
		'wdw_nickname' => '',
		'wdw_title_element' => 'h3',
		// widget options
		'widget_maxitems' => 0,
		'widget_description' => false,
		'widget_page' => '',
		'widget_count' => false,
		'widget_subtitles' => true,
		'widget_element' => 'h4',
		'widget_date' => false,
		'widget_tag' => false,
		'widget_section' => false,
		'widget_random'  => false
	);
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );

	// Change the standard WordPress feed cache time
	add_filter( 'wp_feed_cache_transient_lifetime', 'wdw_cache_time' );

	// Include native WordPress feed fetching features
	// TODO Perhaps this line could be removed. See http://digwp.com/2011/09/feed-display-multiple-columns/#comment-28255
	include_once( ABSPATH . WPINC . '/feed.php' );

	// Retrieve the items from Delicious using nickname + tag wishlist + high tag + max number of items
	// of from an alternative feed source, declared in the options panel
	$wdw_rss = fetch_feed( $feed_source );

	// Reset the standard WordPress feed cache time
	remove_filter( 'wp_feed_cache_transient_lifetime', 'wdw_cache_time' );

	// if there is a problem with the feed...
	if( is_wp_error( $wdw_rss ) ) {
		// ... tell me what's going wrong...
		$wdw_wishlist = '<p>' . sprintf(
			__( 'There was a problem fetching your feed for <strong>%1$s</strong>:<br />%2$s<br />The problem is:<br />%3$s'),
			$wdw_title, $feed_source, $wdw_rss->get_error_message()
		) . '</p>';
	// ... else execute...
	} else {

		if( $wdw_tag_sep == 'space' ) {
			$wdw_tag_sep = ' ';
		} elseif( $wdw_tag_sep == 'comma' ) {
			$wdw_tag_sep = ',';
		} elseif( $wdw_tag_sep == 'comma-space' ) {
			$wdw_tag_sep = ', ';
		}

		// Figure out how many total items there are, but limit it to the $wdw_maxitems variable.
		$num_items = $wdw_rss->get_item_quantity( $wdw_maxitems );

		// Build an array of items
		if ( in_the_loop() ) {
			$wdw_items = $wdw_rss->get_items( 0, $num_items );
		} else {
			// If not in the loop (i.e. in the sidebar widget), take the number of items I set up for the widget
			$wdw_items = $wdw_rss->get_items( 0, $widget_maxitems );
		}

/*
		if( ! in_the_loop() && $widget_subtitles ) {
			if( ! in_the_loop() && $widget_element ) $wdw_title_element = $widget_element;
			$wdw_wishlist = '<' . $wdw_title_element . ' class="' . $title_class . '">';
				// if outside the loop (in the widget), add the number of total items for the section
				if ( ! in_the_loop() && $widget_count ) {
					$qty_for_widget = sprintf( _n( ' <span class="wdw-qty">(%s item)</span>', ' <span class="wdw-qty">(%s items)</span>', $num_items, 'wp-delicious-wishlist' ), $num_items );
				}
				if ( $wdw_title ) {
					$wdw_wishlist .= $wdw_title . $qty_for_widget;
				} else {
					$wdw_wishlist .= __( 'I need', 'wp-delicious-wishlist' ) . $qty_for_widget;
				}
			$wdw_wishlist .= '</' . $wdw_title_element . '>';
		}
*/
		// Build the subtitles
		if( in_the_loop() ) {
			$wdw_wishlist = '<' . $wdw_title_element . ' class="' . $title_class . '">';
				// if outside the loop (in the widget), add the number of total items for the section
				if ( $wdw_title ) {
					$wdw_wishlist .= $wdw_title;
				} else {
					$wdw_wishlist .= __( 'I need', 'wp-delicious-wishlist' );
				}
			$wdw_wishlist .= '</' . $wdw_title_element . '>';
		} else {
			if( $widget_subtitles ) {
				$wdw_wishlist = '<' . $widget_element . ' class="' . $title_class . '">';
					// if outside the loop (in the widget), add the number of total items for the section
					if ( $widget_count ) {
						$qty_for_widget = sprintf( _n( ' <span class="wdw-qty">(%s item)</span>', ' <span class="wdw-qty">(%s items)</span>', $num_items, 'wp-delicious-wishlist' ), $num_items );
					}
					if( ! isset( $qty_for_widget ) ) $qty_for_widget = '';
					if ( $wdw_title ) {
						$wdw_wishlist .= $wdw_title . $qty_for_widget;
					} else {
						$wdw_wishlist .= __( 'I need', 'wp-delicious-wishlist' ) . $qty_for_widget;
					}
				$wdw_wishlist .= '</' . $widget_element . '>';
			}
		}
		
		if( isset( $wdw_wishlist ) ) {
			$wdw_wishlist .= '<ul class="wishlist">';
		} else {
			$wdw_wishlist = '<ul class="wishlist">';
		}
			// If the first (high) section is blank, then let's write "Nothing in this moment."...
			if ( empty( $wdw_items ) ) {
				$wdw_wishlist .= '<li class="' . $list_class . '-' . $wdw_icons . '">' . __( 'Nothing in this moment.', 'wp-delicious-wishlist' ) . '</li>';
			} else {
				// ... else start the loop

				if( $widget_random ) shuffle( $wdw_items );
				//if( $widget_random ) array_rand( $wdw_items, $widget_maxitems );

				foreach ( $wdw_items as $wdw_item ) :
					$bookmark_url = $wdw_item->get_id();
					$wdw_wishlist .= '<li class="' . $list_class . '-' . $wdw_icons . '">';
						$wdw_wishlist .= '<p class="wishlist-bookmark-title"><a class="wishlist-link" href="' . $wdw_item->get_permalink() . '" title="' . $wdw_item->get_title() . '">' . $wdw_item->get_title() . '</a></p>';

						// if in the widget we do not want any description, we do not print it
						if ( in_the_loop() || $widget_description ) {
							$desc = $wdw_item->get_description();
							if ( $desc ) {
								if ( $wdw_truncate != 0 && strlen( $desc ) > $wdw_truncate ) {
									if ( !$wdw_more ) $wdw_more = __( 'Continue', 'wp-delicious-wishlist' );
									$desc = substr( $desc, 0, $wdw_truncate ) . '&hellip; <a href="' . $bookmark_url . '" title="' . sprintf( __( 'Continue reading &laquo;%s&raquo;', 'wp-delicious-wishlist' ), $wdw_item->get_title() ) . ' on Delicious">' . $wdw_more . '</a>';
								}
								$wdw_wishlist .= '<p class="wishlist-description">' . $desc . '</p>';
							}
						}

						if( ( in_the_loop() && $wdw_date ) || ( ! in_the_loop() && $widget_date ) ) {
							// Parse the date into Unix timestamp
							$unixDate  = strtotime( $wdw_item->get_date() );
							// This is the short date
							$briefDate = strftime( __( '%m/%d/%Y', 'wp-delicious-wishlist' ), $unixDate );
							// This is the long date displayed when the mouse overs on it
							$longDate  = strftime(
								__( 'Stored on %A, %m/%d/%Y at %T', 'wp-delicious-wishlist' ), $unixDate ) .
								' (' . sprintf(
									__( '%s ago', 'wp-delicious-wishlist' ), human_time_diff( $unixDate )
								) . ')';
							// Let's build the final line
							// $wdw_wishlist .= '<div class="wishlist-timestamp"><abbr title="'.$longDate.'">'.$briefDate.'</abbr></div>';
							$wdw_wishlist .= '<p class="wishlist-timestamp">
								<span class="wishlist-pre-date">' . $wdw_pre_date . '</span>
								<a class="wishlist-date" href="' . $bookmark_url . '"
								title="' . sprintf(
									__( 'See the bookmark &laquo;%s&raquo; on Delicious - %2$s', 'wp-delicious-wishlist' ),
									$wdw_item->get_title(), $longDate
									) . '">' . $briefDate . '</a></p>';
						}

						   /*
							* Tag section
							*
							* @since 0.6
							*/
						if( ( in_the_loop() && $wdw_tags ) || ( ! in_the_loop() && $widget_tags ) ) {
							// Define $tags as an array and assign the content of get_item_tags
							$tags = (array) $wdw_item->get_item_tags( '', 'category' );
							// If $tags has content
							if( $tags ) {
								// Make sure the new variable $mytags be empty and make it an array
								$mytags = '';
								$mytags = array();
								// for each content of the array...
								foreach( $tags as $tag ) {
									// assign to $mytags the value of 'data'
									$mytags[] = $tag['data'];
								}
								// Now $mytags is an array of values, so let's create each final tag
								// If the user doesn't want to display the base wishlist tags, let's remove them
								if( $wdw_remove_tags ) {
									// Fill an array with the base Wishlist tags
									$tags_to_remove = array( $wdw_tag_wishlist, $wdw_tag );
									// Let's remove them from the tags to display
									$mytags = array_diff( $mytags, $tags_to_remove );
								}
								if ( $wdw_sort_tag ) {
									sort( $mytags );
								}
								// Take the domain to use it as the base url
								$myurl = $tag['attribs']['']['domain'];
								// Make sure that the new variable $all_tags be empty
								$all_tags = '';
								// This is the final loop for our Wishlist
								foreach( $mytags as $mytag ) {
									$all_tags .= $wdw_pre_tag . '<a class="wishlist-tag" title="' . sprintf( __( 'See all my bookmarks tagged &laquo;%s&raquo;', 'wp-delicious-wishlist' ), $mytag ) . '" href="' . $myurl . $mytag . '">' . $mytag . '</a>' . $wdw_tag_sep;
								}
								// Remove the trailing tag separator
								$all_tags = substr( $all_tags, 0, -( strlen( $wdw_tag_sep ) ) );
								$wdw_wishlist .= '<p class="wishlist-tags"><span class="wishlist-pre-tags">' . $wdw_pre_tags . '</span> ' . $all_tags . '</p>';
							}
						}

						/*
						 * Section for main wishlist Delicious tags
						 *
						 * @since 2.1
						 */

						if( ( in_the_loop() && $wdw_section ) || ( ! in_the_loop() && $widget_section ) ) {
							$wdw_wishlist .= '<p class="wishlist-section">' . $wdw_pre_section . ' <a class="wishlist-section-link" href="http://www.delicious.com/' . $wdw_nickname . '/' . $wdw_tag_wishlist . '+' . $wdw_tag . '">' . $wdw_tag_wishlist . '+' . $wdw_tag . '</a></p>';
						}

					$wdw_wishlist .= '</li>';
				endforeach;
			}
		$wdw_wishlist .= '</ul>';
	}

	return $wdw_wishlist;
}

/**
 * The core function.
 *
 * @param $widget_maxitems contains the value of items to fetch for the widget
 * @param $widget_description defines if the description will appear in the widget or not
 * @since 0.1
 * @since 0.5 Alternative feeds
 * @since 0.6 Tag section
 */

function wp_delicious_wishlist(
	$widget_maxitems = 1,
	$widget_description = false,
	$widget_page = '',
	$widget_count = false,
	$widget_subtitles = true,
	$widget_element = 'h3',
	$widget_date = false,
	$widget_tags = false,
	$widget_section = false,
	$widget_backlink = false,
	$widget_random = false
) {

	// Let's collect some options from the plugin admin panel
	$wdws = (array) get_option( 'wdw_options' );
	isset( $wdws['wdw_delicious_nickname'] )     ? $wdw_nickname      = $wdws['wdw_delicious_nickname']     : $wdw_nickname      = '';
	isset( $wdws['wdw_delicious_tag_wishlist'] ) ? $wdw_tag_wishlist  = $wdws['wdw_delicious_tag_wishlist'] : $wdw_tag_wishlist  = '';
	isset( $wdws['wdw_delicious_title_high'] )   ? $wdw_title_high    = $wdws['wdw_delicious_title_high']   : $wdw_title_high    = '';
	isset( $wdws['wdw_delicious_tag_high'] )     ? $wdw_tag_high      = $wdws['wdw_delicious_tag_high']     : $wdw_tag_high      = '';
	isset( $wdws['wdw_delicious_title_medium'] ) ? $wdw_title_medium  = $wdws['wdw_delicious_title_medium'] : $wdw_title_medium  = '';
	isset( $wdws['wdw_delicious_tag_medium'] )   ? $wdw_tag_medium    = $wdws['wdw_delicious_tag_medium']   : $wdw_tag_medium    = '';
	isset( $wdws['wdw_delicious_title_low'] )    ? $wdw_title_low     = $wdws['wdw_delicious_title_low']    : $wdw_title_low     = '';
	isset( $wdws['wdw_delicious_tag_low'] )      ? $wdw_tag_low       = $wdws['wdw_delicious_tag_low']      : $wdw_tag_low       = '';
	isset( $wdws['wdw_title_element'] )          ? $wdw_title_element = $wdws['wdw_title_element']          : $wdw_title_element = 'h3';
	isset( $wdws['wdw_delicious_howmany'] )      ? $wdw_maxitems      = $wdws['wdw_delicious_howmany']      : $wdw_maxitems      = 5;
	isset( $wdws['wdw_delicious_truncate'] )     ? $wdw_truncate      = $wdws['wdw_delicious_truncate']     : $wdw_truncate      = false;
	isset( $wdws['wdw_delicious_more'] )         ? $wdw_more          = $wdws['wdw_delicious_more']         : $wdw_more          = 'Read more';
	isset( $wdws['wdw_delicious_icons'] )        ? $wdw_icons         = $wdws['wdw_delicious_icons']        : $wdw_icons         = 'stars';
	isset( $wdws['wdw_delicious_cache'] )        ? $wdw_cache         = $wdws['wdw_delicious_cache']        : $wdw_cache         = 3600;
	isset( $wdws['wdw_date'] )                   ? $wdw_date          = $wdws['wdw_date']                   : $wdw_date          = false;
	isset( $wdws['wdw_delicious_pre_date'] )     ? $wdw_pre_date      = $wdws['wdw_delicious_pre_date']     : $wdw_pre_date      = '';
	isset( $wdws['wdw_tags'] )                   ? $wdw_tags          = $wdws['wdw_tags']                   : $wdw_tags          = false;
	isset( $wdws['wdw_remove_tags'] )            ? $wdw_remove_tags   = $wdws['wdw_remove_tags']            : $wdw_remove_tags   = false;
	isset( $wdws['wdw_delicious_pre_tags'] )     ? $wdw_pre_tags      = $wdws['wdw_delicious_pre_tags']     : $wdw_pre_tags      = '';
	isset( $wdws['wdw_pre_tag'] )                ? $wdw_pre_tag       = $wdws['wdw_pre_tag']                : $wdw_pre_tag       = '';
	isset( $wdws['wdw_tag_sep'] )                ? $wdw_tag_sep       = $wdws['wdw_tag_sep']                : $wdw_tag_sep       = 'space';
	isset( $wdws['wdw_sort_tag'] )               ? $wdw_sort_tag      = $wdws['wdw_sort_tag']               : $wdw_sort_tag      = false;
	isset( $wdws['wdw_section'] )                ? $wdw_section       = $wdws['wdw_section']                : $wdw_section       = false;
	isset( $wdws['wdw_pre_section'] )            ? $wdw_pre_section   = $wdws['wdw_pre_section']            : $wdw_pre_section   = '';
	isset( $wdws['wdw_backlink'] )               ? $wdw_backlink      = $wdws['wdw_backlink']               : $wdw_backlink      = false;
	isset( $wdws['wdw_delicious_alt_feed_ht'] )  ? $wdw_altfeed_ht    = $wdws['wdw_delicious_alt_feed_ht']  : $wdw_altfeed_ht    = '';
	isset( $wdws['wdw_delicious_alt_feed_mt'] )  ? $wdw_altfeed_mt    = $wdws['wdw_delicious_alt_feed_mt']  : $wdw_altfeed_mt    = '';
	isset( $wdws['wdw_delicious_alt_feed_lt'] )  ? $wdw_altfeed_lt    = $wdws['wdw_delicious_alt_feed_lt']  : $wdw_altfeed_lt    = '';

	// check if fields' values are blank
	if (
		empty( $wdw_nickname )     ||
		empty( $wdw_tag_wishlist ) ||
		empty( $wdw_tag_high )     ||
		empty( $wdw_tag_medium )   ||
		empty( $wdw_tag_low )
	) {
		// if blank, print this
		$wdw_warning  = '<p class="wdw_warning">';
		$wdw_warning .= sprintf(
			__( 'You have not properly configured the plugin. Please, setup it in the %1$splugin panel%2$s, filling in all the required fields.', 'wp-delicious-wishlist' ),
			'<a href="' . admin_url( 'options-general.php?page=wdw-options' ) . '">',
			'</a>'
		);
		$wdw_warning .= '</p>';

	} else { // if required options aren't empty, then execute the following code

		// If $wdw_maxitems has not been declared, then we setup it to 5 items to retrieve
		if ( empty( $wdw_maxitems ) ) {
			$wdw_maxitems = "5";
		}

		// Define my icons
		$wdw_icons == "stars" ? $wdw_icons = "stars" : $wdw_icons = "faces";

		// Define the title element
		if( ! $wdw_title_element ) $wdw_title_element = 'h3';

		//***** Start 3 stars section *****\\

		// Define the feed source
		if( $wdw_altfeed_ht ) {
			$feed_source = $wdw_altfeed_ht;
		} else {
			$feed_source = 'http://feeds.delicious.com/v2/rss/' . $wdw_nickname . '/' . $wdw_tag_wishlist . '+' . $wdw_tag_high . '?count=' . $wdw_maxitems;
		}

		$wdw_wishlist_high = wdw_fetch_bookmarks( array(
			'feed_source'       => $feed_source,
			'title_class'       => 'wishlist-title-high',
			'wdw_maxitems'      => $wdw_maxitems,
			'wdw_title'         => $wdw_title_high,
			'list_class'        => 'high',
			'wdw_icons'         => $wdw_icons,
			'wdw_truncate'      => $wdw_truncate,
			'wdw_more'          => $wdw_more,
			'wdw_date'          => $wdw_date,
			'wdw_pre_date'      => $wdw_pre_date,
			'wdw_tags'          => $wdw_tags,
			'wdw_remove_tags'   => $wdw_remove_tags,
			'wdw_tag_wishlist'  => $wdw_tag_wishlist,
			'wdw_tag'           => $wdw_tag_high,
			'wdw_pre_tags'      => $wdw_pre_tags,
			'wdw_sort_tag'      => $wdw_sort_tag,
			'wdw_pre_tag'       => $wdw_pre_tag,
			'wdw_tag_sep'       => $wdw_tag_sep,
			'wdw_section'       => $wdw_section,
			'wdw_pre_section'   => $wdw_pre_section,
			'wdw_nickname'      => $wdw_nickname,
			'wdw_title_element' => $wdw_title_element,
			// widget options
			'widget_maxitems'    => $widget_maxitems,
			'widget_description' => $widget_description,
			'widget_page'        => $widget_page,
			'widget_count'       => $widget_count,
			'widget_subtitles'   => $widget_subtitles,
			'widget_element'     => $widget_element,
			'widget_date'        => $widget_date,
			'widget_tags'        => $widget_tags,
			'widget_section'     => $widget_section,
			'widget_random'      => $widget_random
		) );

		//***** Start 2 stars section *****\\

		// Define the feed source
		if( $wdw_altfeed_mt ) {
			$feed_source = $wdw_altfeed_mt;
		} else {
			$feed_source = 'http://feeds.delicious.com/v2/rss/' . $wdw_nickname . '/' . $wdw_tag_wishlist . '+' . $wdw_tag_medium . '?count=' . $wdw_maxitems;
		}

		$wdw_wishlist_medium = wdw_fetch_bookmarks( array(
			'feed_source'       => $feed_source,
			'title_class'       => 'wishlist-title-medium',
			'wdw_maxitems'      => $wdw_maxitems,
			'wdw_title'         => $wdw_title_medium,
			'list_class'        => 'medium',
			'wdw_icons'         => $wdw_icons,
			'wdw_truncate'      => $wdw_truncate,
			'wdw_more'          => $wdw_more,
			'wdw_date'          => $wdw_date,
			'wdw_pre_date'      => $wdw_pre_date,
			'wdw_tags'          => $wdw_tags,
			'wdw_remove_tags'   => $wdw_remove_tags,
			'wdw_tag_wishlist'  => $wdw_tag_wishlist,
			'wdw_tag'           => $wdw_tag_medium,
			'wdw_pre_tags'      => $wdw_pre_tags,
			'wdw_sort_tag'      => $wdw_sort_tag,
			'wdw_pre_tag'       => $wdw_pre_tag,
			'wdw_tag_sep'       => $wdw_tag_sep,
			'wdw_section'       => $wdw_section,
			'wdw_pre_section'   => $wdw_pre_section,
			'wdw_nickname'      => $wdw_nickname,
			'wdw_title_element' => $wdw_title_element,
			// widget options
			'widget_maxitems'    => $widget_maxitems,
			'widget_description' => $widget_description,
			'widget_page'        => $widget_page,
			'widget_count'       => $widget_count,
			'widget_subtitles'   => $widget_subtitles,
			'widget_element'     => $widget_element,
			'widget_date'        => $widget_date,
			'widget_tags'        => $widget_tags,
			'widget_section'     => $widget_section,
			'widget_random'      => $widget_random
		) );

		//***** Start 1 star section *****\\

		// Define the feed source
		if( $wdw_altfeed_lt ) {
			$feed_source = $wdw_altfeed_lt;
		} else {
			$feed_source = 'http://feeds.delicious.com/v2/rss/' . $wdw_nickname . '/' . $wdw_tag_wishlist . '+' . $wdw_tag_low . '?count=' . $wdw_maxitems;
		}

		$wdw_wishlist_low = wdw_fetch_bookmarks( array(
			'feed_source'       => $feed_source,
			'title_class'       => 'wishlist-title-low',
			'wdw_maxitems'      => $wdw_maxitems,
			'wdw_title'         => $wdw_title_low,
			'list_class'        => 'low',
			'wdw_icons'         => $wdw_icons,
			'wdw_truncate'      => $wdw_truncate,
			'wdw_more'          => $wdw_more,
			'wdw_date'          => $wdw_date,
			'wdw_pre_date'      => $wdw_pre_date,
			'wdw_tags'          => $wdw_tags,
			'wdw_remove_tags'   => $wdw_remove_tags,
			'wdw_tag_wishlist'  => $wdw_tag_wishlist,
			'wdw_tag'           => $wdw_tag_low,
			'wdw_pre_tags'      => $wdw_pre_tags,
			'wdw_sort_tag'      => $wdw_sort_tag,
			'wdw_pre_tag'       => $wdw_pre_tag,
			'wdw_tag_sep'       => $wdw_tag_sep,
			'wdw_section'       => $wdw_section,
			'wdw_pre_section'   => $wdw_pre_section,
			'wdw_nickname'      => $wdw_nickname,
			'wdw_title_element' => $wdw_title_element,
			// widget options
			'widget_maxitems'    => $widget_maxitems,
			'widget_description' => $widget_description,
			'widget_page'        => $widget_page,
			'widget_count'       => $widget_count,
			'widget_subtitles'   => $widget_subtitles,
			'widget_element'     => $widget_element,
			'widget_date'        => $widget_date,
			'widget_tags'        => $widget_tags,
			'widget_section'     => $widget_section,
			'widget_random'      => $widget_random
		) );

		if ( ! in_the_loop() && $widget_page ) { // in_the_loop() - What a useful function! I twittered here: http://bit.ly/cImZne :)
			if ( ! is_page( $widget_page ) ) {
				if( $wishlist_page = get_page_by_title( $widget_page ) ) {
					$wdw_page_link = get_page_link( $wishlist_page->ID );
					if( $wishlist_page->post_status == 'publish' ) {
						$wdw_wishlist_page = '<p class="wdw-page">';
						$wdw_wishlist_page .= sprintf( __( 'Check out %1$smy complete list%2$s.', 'wp-delicious-wishlist' ), '<a href="'.$wdw_page_link.'">', '</a>' );
						$wdw_wishlist_page .= '</p>';
					}
				}
			}
		}
		
		if( ( in_the_loop() && $wdw_backlink ) || ( ! in_the_loop() && $widget_backlink ) ) {
			$wdw_credits = '<p class="wdw_backlink">'
			. __( 'Created using', 'wp-delicious-wishlist' )
			. ' <a href="http://wordpress.org/extend/plugins/delicious-wishlist-for-wordpress/">'
			. __( 'Delicious Wishlist for WordPress', 'wp-delicious-wishlist') . '</a> ' . WDW_VERSION . '.</p>';
		}

	}

	// Return the complete wishlist
	if( ! isset( $wdw_warning ) )          $wdw_warning        = '';
	if( ! isset( $wdw_wishlist_high ) )   $wdw_wishlist_high   = '';
	if( ! isset( $wdw_wishlist_medium ) ) $wdw_wishlist_medium = '';
	if( ! isset( $wdw_wishlist_low ) )    $wdw_wishlist_low    = '';
	if( ! isset( $wdw_wishlist_page ) )   $wdw_wishlist_page   = '';
	if( ! isset( $wdw_credits ) )         $wdw_credits         = '';
	return $wdw_warning . $wdw_wishlist_high . $wdw_wishlist_medium . $wdw_wishlist_low . $wdw_wishlist_page . $wdw_credits;
}

add_shortcode('my-delicious-wishlist', 'wp_delicious_wishlist');


/**
 * The Widget
 *
 * Add the widget for Delicious Wishlist for WordPress
 *
 * @since 2.0
 */

add_action( 'widgets_init', 'wdw_load_widget' );

function wdw_load_widget() {
	register_widget( 'WDW_Widget' );
}

class WDW_Widget extends WP_Widget {
	function WDW_Widget() {
		$widget_ops = array(
			'classname'   => 'wdw_widget',
			'description' => __( 'Your personal wishlist proudly powered by Delicious', 'wp-delicious-wishlist' )
		);
		$this->WP_Widget( 'wdw-widget', __('Delicious Wishlist Widget', 'wp-delicious-wishlist'), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title              = apply_filters('widget_title', $instance['title']);
		$widget_maxitems    = $instance['maxitems'];
		$widget_description = isset( $instance['desc'] ) ? $instance['desc'] : false;
		$widget_page        = $instance['page'];
		$widget_count       = isset( $instance['count'] ) ? $instance['count'] : false;
		$widget_subtitles   = isset( $instance['subtitles'] ) ? $instance['subtitles'] : false;
		$widget_element     = $instance['element'];
		$widget_date        = isset( $instance['date'] ) ? $instance['date'] : false;
		$widget_tags        = isset( $instance['tags'] ) ? $instance['tags'] : false;
		$widget_section     = isset( $instance['section'] ) ? $instance['section'] : false;
		$widget_backlink    = isset( $instance['backlink'] ) ? $instance['backlink'] : false;
		$widget_random      = isset( $instance['random'] ) ? $instance['random'] : false;

		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;
		echo wp_delicious_wishlist(
			$widget_maxitems,
			$widget_description,
			$widget_page,
			$widget_count,
			$widget_subtitles,
			$widget_element,
			$widget_date,
			$widget_tags,
			$widget_section,
			$widget_backlink,
			$widget_random
		);
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title']     = strip_tags($new_instance['title']);
		$instance['maxitems']  = strip_tags($new_instance['maxitems']);
		$instance['desc']      = $new_instance['desc'];
		$instance['page']      = strip_tags($new_instance['page']);
		$instance['count']     = $new_instance['count'];
		$instance['subtitles'] = $new_instance['subtitles'];
		$instance['element']   = $new_instance['element'];
		$instance['date']      = $new_instance['date'];
		$instance['tags']      = $new_instance['tags'];
		$instance['section']   = $new_instance['section'];
		$instance['backlink']  = $new_instance['backlink'];
		$instance['random']    = $new_instance['random'];
		return $instance;
	}

	function form($instance) {
		$defaults = array(
			'title'     => __( 'My Wishlist', 'wp-delicious-wishlist' ),
			'maxitems'  => 1,
			'desc'      => false,
			'page'      => '',
			'count'     => false,
			'subtitles' => true,
			'element'   => 'h4',
			'date'      => false,
			'tags'      => false,
			'section'   => false,
			'backlink'  => false,
			'random'    => false
		);
		$instance  = wp_parse_args( (array) $instance, $defaults );
		$desc      = (bool) $instance['desc'];
		$count     = (bool) $instance['count'];
		$subtitles = (bool) $instance['subtitles'];
		$date      = (bool) $instance['date'];
		$tags      = (bool) $instance['tags'];
		$section   = (bool) $instance['section'];
		$backlink  = (bool) $instance['backlink'];
		$random    = (bool) $instance['random'];
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">
					<?php _e('Title:', 'wp-delicious-wishlist'); ?>
				</label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('maxitems'); ?>">
					<?php _e('Maximum number of items per section (100 max):', 'wp-delicious-wishlist'); ?>
				</label>
				<input class="widefat" id="<?php echo $this->get_field_id('maxitems'); ?>" name="<?php echo $this->get_field_name('maxitems'); ?>" type="text" value="<?php echo $instance['maxitems']; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('page'); ?>">
					<?php _e('Insert the title of your Wishlist page:', 'wp-delicious-wishlist'); ?>
				</label>
				<input class="widefat" id="<?php echo $this->get_field_id('page'); ?>" name="<?php echo $this->get_field_name('page'); ?>" type="text" value="<?php echo $instance['page']; ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $desc ); ?> value="1" id="<?php echo $this->get_field_id( 'desc' ); ?>" name="<?php echo $this->get_field_name( 'desc' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'desc' ); ?>">
					<?php _e('Display description', 'wp-delicious-wishlist'); ?>
				</label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $subtitles ); ?> value="1" id="<?php echo $this->get_field_id( 'subtitles' ); ?>" name="<?php echo $this->get_field_name( 'subtitles' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'subtitles' ); ?>">
					<?php _e('Display the subtitles', 'wp-delicious-wishlist'); ?>
				</label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $count ); ?> value="1" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'count' ); ?>">
					<?php _e('Display the total number of items in titles', 'wp-delicious-wishlist'); ?>
				</label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('element'); ?>">
					<?php _e( 'Choose the HTML element for subtitles:', 'wp-delicious-wishlist' ); ?>
				</label>
				<select name="<?php echo $this->get_field_name('element'); ?>" >
					<option <?php selected( 'h1', $instance['element']); ?> value="h1">
						<?php _e( 'H1', 'wp-delicious-wishlist' ); ?>
					</option>
					<option <?php selected( 'h2', $instance['element']); ?> value="h2">
						<?php _e( 'H2', 'wp-delicious-wishlist' ); ?>
					</option>
					<option <?php selected( 'h3', $instance['element']); ?> value="h3">
						<?php _e( 'H3', 'wp-delicious-wishlist' ); ?>
					</option>
					<option <?php selected( 'h4', $instance['element']); ?> value="h4">
						<?php _e( 'H4', 'wp-delicious-wishlist' ); ?>
					</option>
					<option <?php selected( 'h5', $instance['element']); ?> value="h5">
						<?php _e( 'H5', 'wp-delicious-wishlist' ); ?>
					</option>
					<option <?php selected( 'div', $instance['element']); ?> value="div">
						<?php _e( 'DIV', 'wp-delicious-wishlist' ); ?>
					</option>
					<option <?php selected( 'span', $instance['element']); ?> value="span">
						<?php _e( 'SPAN', 'wp-delicious-wishlist' ); ?>
					</option>
				</select>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $random ); ?> value="1" id="<?php echo $this->get_field_id( 'random' ); ?>" name="<?php echo $this->get_field_name( 'random' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'random' ); ?>">
					<?php _e('Pick up random items', 'wp-delicious-wishlist'); ?>
				</label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $date ); ?> value="1" id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'date' ); ?>">
					<?php _e('Display date', 'wp-delicious-wishlist'); ?>
				</label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $tags ); ?> value="1" id="<?php echo $this->get_field_id( 'tags' ); ?>" name="<?php echo $this->get_field_name( 'tags' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'tags' ); ?>">
					<?php _e('Display tags', 'wp-delicious-wishlist'); ?>
				</label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $section ); ?> value="1" id="<?php echo $this->get_field_id( 'section' ); ?>" name="<?php echo $this->get_field_name( 'section' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'section' ); ?>">
					<?php _e('Display section', 'wp-delicious-wishlist'); ?>
				</label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $backlink ); ?> value="1" id="<?php echo $this->get_field_id( 'backlink' ); ?>" name="<?php echo $this->get_field_name( 'backlink' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'backlink' ); ?>">
					<?php _e('Link to the author', 'wp-delicious-wishlist'); ?>
				</label>
			</p>
		<?php
	}
}


/*
 * Load the options file
 */
include_once( 'wdw-options.php' );

/**
 * Add the stylesheet
 *
 * @since 0.1
 * @since 1.0 The plugin can avoid the use of CSS. The user will stylize the output via theme's CSS.
 */

function wp_delicious_wishlist_stylesheets() {
	$wdws = (array) get_option( 'wdw_options' );
	if( isset( $wdws['wdw_css'] ) ) {
		if( file_exists( TEMPLATEPATH . '/wdw.css' ) ) {
			wp_register_style( 'wp-delicious-wishlist', get_stylesheet_directory_uri() . '/wdw.css' );
			wp_enqueue_style( 'wp-delicious-wishlist');
		} else {
			wp_register_style( 'wp-delicious-wishlist', plugin_dir_url( __FILE__ ) . '/wdw.css' );
			wp_enqueue_style( 'wp-delicious-wishlist');
		}
	}
}
add_action( 'wp_print_styles', 'wp_delicious_wishlist_stylesheets' );


/**
 * Make plugin available for i18n
 * Translations must be archived in the /languages directory
 *
 * @since 0.1
 */

function wdw_load_languages() {
	load_plugin_textdomain( 'wp-delicious-wishlist', false, dirname( plugin_basename( __FILE__ ) ) . '/languages');
}

add_action( 'plugins_loaded', 'wdw_load_languages' );

/***********************************************************************
 *                            CODE IS POETRY
 **********************************************************************/
