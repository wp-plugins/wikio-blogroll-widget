<?php
/*
	Plugin Name: Wikio Blogroll Widget
	Plugin URI: http://wikio.com
	Description: Compatible Worpress 2.3 and above. <a href="themes.php?page=wikio-neighbours-sidebar-basic/wikio-neighbours-sidebar-basic.php">Configure it</a> | <a href="widgets.php">Widgets</a>.
	Version: 0.1
	Author: Wikio
	Author URI: http://wikio.com
	
	Copyright 2009  Wikio  (email : widgets@wikio.com)
	
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
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// Version ?
	$wikio_neighbours_plugin_version = "0.1";
	
// Where is the plugin?
	$wikio_neighbours_plugin_place = PLUGINDIR.'/'.dirname(plugin_basename(__FILE__));

// Where are the pics?
	$wikio_neighbours_plugin_image_dir = get_bloginfo( 'wpurl' ).'/'.$wikio_plugin_place.'/images';

// Localisation
	$wikio_neighbours_domain = 'wikio-neighbours-sidebar-basic';
	
	load_plugin_textdomain($wikio_neighbours_domain, PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)));

// All the services
	
	// Widget title
	if (!get_option( 'wikio_neighbours_title' )){
		update_option( wikio_neighbours_title, '' );
	}
	
	// My wikio
	if (!get_option( 'wikio_tld' )){
		update_option( wikio_tld, 'com' );
	}
	
	// widget width
	if (!get_option( 'wikio_neighbours_width' )){
		update_option( wikio_neighbours_width, '150' );
	}
	
	// Widget style raw|light 
	if (!get_option( 'wikio_neighbours_style' )){
		update_option( wikio_neighbours_style, 'raw' );
	}
	
	// Blog url
	if (!get_option( 'wikio_neighbours_blog_url' )){
		update_option( wikio_neighbours_blog_url, get_bloginfo( 'wpurl' ) );
	}
	
	// Direction
	if (!get_option( 'wikio_neighbours_dir' )){
		update_option( wikio_neighbours_dir, 'both' );
	}
	
	// Items max
	if (!get_option( 'wikio_neighbours_items' )){
		update_option( wikio_neighbours_items, 5);
	}
	
// Hook for adding admin menus
	add_action( 'admin_menu', 'wikio_neighbours_add_pages' );

// Add géneral sylesheet ( ref wikio_admin_head() )
	add_action( 'wp_head', 'wikio_neighbours_admin_head' );

	
// action function for above hook
	function wikio_neighbours_add_pages() {
		
		// Add a new submenu under Options:
		add_submenu_page( 'themes.php', 'Wikio - Blogroll', 'Wikio - Blogroll ', 7, __FILE__, 'wikio_neighbours_main_page' );
		
		// Add sylesheet ( ref wikio_admin_head() )
		add_action( 'admin_print_scripts', 'wikio_neighbours_admin_head' );
		
	}

	function wikio_neighbours_admin_head() {
	
		global $wikio_neighbours_plugin_place;
		
		echo '<link type="text/css" rel="stylesheet" href="'.get_bloginfo( 'wpurl' ).'/'.$wikio_neighbours_plugin_place.'/wikio-neighbours-sidebar-basic-style.css" />'."\n";
	}
	


// mt_options_page() displays the page content for the Test Options submenu
	function wikio_neighbours_main_page() {
		
		global $wikio_neighbours_plugin_place;
		global $wikio_neighbours_plugin_image_dir;
		global $wikio_neighbours_domain;
		
		print('<div class="wrap">');
		
		print('<div class="wikio_pack_content">');
		
		?>
		<script type="text/javascript">
			function please_update(lst5)
			{
			 var info5=document.getElementById("post-query-submit-"+lst5);
			 info5.style.display="inline"
			}
		</script>
		
		<?php
		
		
		// Check the post results
		if ($_POST['submit']){
			
			//unset ($wikio_share_option);
			$wikio_tld = htmlentities( $_POST['wikio_tld'] );
			$wikio_neighbours_title = htmlentities( $_POST['wikio_neighbours_title'] );
			$wikio_neighbours_width = intval( $_POST['wikio_neighbours_width'] );
			$wikio_neighbours_style = htmlentities( $_POST['wikio_neighbours_style'] );
			$wikio_neighbours_blog_url = htmlentities( $_POST['wikio_neighbours_blog_url'] );
			$wikio_neighbours_items = htmlentities( $_POST['wikio_neighbours_items'] );
			$wikio_neighbours_dir = htmlentities( $_POST['wikio_neighbours_dir'] );
			
					
			// save automatic option
			update_option( wikio_tld, $wikio_tld );
			update_option( wikio_neighbours_title, $wikio_neighbours_title );
			update_option( wikio_neighbours_width, $wikio_neighbours_width );
			update_option( wikio_neighbours_style, $wikio_neighbours_style );
			update_option( wikio_neighbours_blog_url, $wikio_neighbours_blog_url );
			update_option( wikio_neighbours_items, $wikio_neighbours_items );
			update_option( wikio_neighbours_dir, $wikio_neighbours_dir );
			
			// print ok message
			echo'
			<div id="message" class="updated fade below-h2" style="background-color: rgb(255, 251, 204);">
				<p>
				'.__('Update complete',$wikio_neighbours_domain).'
				</p>
			</div>';
		}
		
		
		// Return all options values
		$wikio_tld = html_entity_decode(get_option( 'wikio_tld' ));
		$wikio_neighbours_title = html_entity_decode(get_option( 'wikio_neighbours_title' ));
		$wikio_neighbours_width = html_entity_decode(get_option( 'wikio_neighbours_width' ));
		$wikio_neighbours_style = html_entity_decode(get_option( 'wikio_neighbours_style' ));
		$wikio_neighbours_blog_url = html_entity_decode(get_option( 'wikio_neighbours_blog_url' ));
		$wikio_neighbours_items = html_entity_decode(get_option( 'wikio_neighbours_items' ));
		$wikio_neighbours_dir = html_entity_decode(get_option( 'wikio_neighbours_dir' ));
		
		// Return Twitter url
		if ( $wikio_tld == "co.uk" ){
			$wikio_twitter_url = "http://twitter.com/Wikio_uk";
		} else if ( $wikio_tld == "com" ){
			$wikio_twitter_url = "http://twitter.com/Wikio_us";
		} else if ( $wikio_tld == "fr" ){
			$wikio_twitter_url = "http://twitter.com/Wikio_fr";
		} else if ( $wikio_tld == "it" ){
			$wikio_twitter_url = "http://twitter.com/Wikio_it";
		} else if ( $wikio_tld == "es" ){
			$wikio_twitter_url = "http://twitter.com/Wikio_es";
		} else if ( $wikio_tld == "de" ){
			$wikio_twitter_url = "http://twitter.com/Wikio_de";
		}
			?>
					
			<h2 id="wikio"><?php _e('Wikio Blogroll Widget',$wikio_neighbours_domain); ?></h2>
			<form name="wikio_share_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Which Wikio do you use',$wikio_neighbours_domain); ?>&nbsp;?</th>
						<td>
						<select name="wikio_tld" id="wikio_tld" onchange="please_update(1);">
							<option value="fr" <?php if ($wikio_tld == "fr"){ echo 'selected="selected"';} ?>><?php _e('Wikio.fr (fr)',$wikio_neighbours_domain); ?></option>
							<option value="it" <?php if ($wikio_tld == "it"){ echo 'selected="selected"';} ?>><?php _e('Wikio.it (it)',$wikio_neighbours_domain); ?></option>
							<option value="es" <?php if ($wikio_tld == "es"){ echo 'selected="selected"';} ?>><?php _e('Wikio.es (es)',$wikio_neighbours_domain); ?></option>
							<option value="de" <?php if ($wikio_tld == "de"){ echo 'selected="selected"';} ?>><?php _e('Wikio.de (de)',$wikio_neighbours_domain); ?></option>
							<option value="com" <?php if ($wikio_tld == "com"){ echo 'selected="selected"';} ?>><?php _e('Wikio.com (us)',$wikio_neighbours_domain); ?></option>
							<option value="co.uk" <?php if ($wikio_tld == "co.uk"){ echo 'selected="selected"';} ?>><?php _e('Wikio.co.uk (uk)',$wikio_neighbours_domain); ?></option>
						</select>
						<input id="post-query-submit-1" class="button-secondary" type="submit" value="<?php _e('Save changes',$wikio_neighbours_domain); ?>" style="display:none;" name="submit" />
						<br />
						<label for="wikio_backlinks_title"><a href="http://www.wikio.<?php echo $wikio_tld; ?>/addblog"><?php _e('Submit your site',$wikio_neighbours_domain); ?>.</a></label>
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Blog url',$wikio_neighbours_domain); ?></th>
						<td>
						<div class="wikio_share_form">
						<input id="wikio_neighbours_blog_url" name="wikio_neighbours_blog_url" type="text" value="<?php echo $wikio_neighbours_blog_url; ?>" onclick="please_update(5);" />
						<br />
						<label for="wikio_neighbours_blog_url"><?php _e('Wordpress suggests:',$wikio_neighbours_domain); ?> <?php echo get_bloginfo( 'wpurl' ); ?></label>
						</div>
						<input id="post-query-submit-5" class="button-secondary" type="submit" value="<?php _e('Save changes',$wikio_neighbours_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
						
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Widget title',$wikio_neighbours_domain); ?></th>
						<td>
						<div class="wikio_share_form">
						<input id="wikio_neighbours_title" name="wikio_neighbours_title" type="text" value="<?php echo $wikio_neighbours_title; ?>" onclick="please_update(2);" />
						<br />
						<label for="wikio_neighbours_title"><?php _e('Give widget a title',$wikio_neighbours_domain); ?>.</label>
						</div>
						<input id="post-query-submit-2" class="button-secondary" type="submit" value="<?php _e('Save changes',$wikio_neighbours_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Style',$wikio_neighbours_domain); ?></th>
						<td>
						<select name="wikio_neighbours_style" id="wikio_neighbours_style" onchange="please_update(4);">
							<option value="raw" <?php if ($wikio_neighbours_style == "raw"){ echo 'selected="selected"';} ?>><?php _e('Raw',$wikio_neighbours_domain); ?></option>
							<option value="light" <?php if ($wikio_neighbours_style == "light"){ echo 'selected="selected"';} ?>><?php _e('Light',$wikio_neighbours_domain); ?></option>
						</select>
						<input id="post-query-submit-4" class="button-secondary" type="submit" value="<?php _e('Save changes',$wikio_neighbours_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Direction',$wikio_neighbours_domain); ?></th>
						<td>
						<select name="wikio_neighbours_dir" id="wikio_neighbours_dir" onchange="please_update(7);">
							<option value="in" <?php if ($wikio_neighbours_dir == "in"){ echo 'selected="selected"';} ?>><?php _e('In',$wikio_neighbours_domain); ?></option>
							<option value="out" <?php if ($wikio_neighbours_dir == "out"){ echo 'selected="selected"';} ?>><?php _e('Out',$wikio_neighbours_domain); ?></option>
							<option value="both" <?php if ($wikio_neighbours_dir == "both"){ echo 'selected="selected"';} ?>><?php _e('Both',$wikio_neighbours_domain); ?></option>
						</select>
						<input id="post-query-submit-4" class="button-secondary" type="submit" value="<?php _e('Save changes',$wikio_neighbours_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Width',$wikio_neighbours_domain); ?></th>
						<td>
						<div class="wikio_share_form">
						<input id="wikio_neighbours_width" name="wikio_neighbours_width" type="text" value="<?php echo $wikio_neighbours_width; ?>" onclick="please_update(3);" />px
						<br />
						<label for="wikio_neighbours_width"><?php _e('Width example: 200',$wikio_neighbours_domain); ?>.</label>
						</div>
						<input id="post-query-submit-3" class="button-secondary" type="submit" value="<?php _e('Save changes',$wikio_neighbours_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Max items',$wikio_neighbours_domain); ?></th>
						<td>
						<div class="wikio_share_form">
						<input id="wikio_neighbours_items" name="wikio_neighbours_items" type="text" value="<?php echo $wikio_neighbours_items; ?>" onclick="please_update(6);" />
						<br />
						<label for="wikio_neighbours_items"><?php _e('Example : 10',$wikio_neighbours_domain); ?>.</label>
						</div>
						<input id="post-query-submit-6" class="button-secondary" type="submit" value="<?php _e('Save changes',$wikio_neighbours_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<div class="submit">
			<input class="button-primary" name="submit" type="submit" value="<?php _e('Save changes',$wikio_neighbours_domain); ?>" />
			</div>
			</form>
			
			<a href="<?php echo $wikio_twitter_url; ?>"><img src="../<?php echo $wikio_neighbours_plugin_place; ?>/images/Twitter_logo.gif" alt="Follow us on Twitter" /></a>
			
			<?php
	
		//print('</div>');
		
	}

class wikio_neighbours_sub_widget {

	function wikio_neighbours_sub_widget() {
		add_action( 'widgets_init', array(&$this, 'init_widget' ));
	}

	function init_widget() {
		
		if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;
		
		register_sidebar_widget( array(__('Blogroll',$wikio_neighbours_domain),'widgets'),array(&$this, 'widget') );
		register_widget_control( array(__('Blogroll',$wikio_neighbours_domain), 'widgets'), array(&$this, 'widget_options') );
	}

	function widget($args) {
		//global $wpdb;
		$wikio_tld = urlencode(html_entity_decode(get_option( 'wikio_tld' )));
		$wikio_neighbours_width = urlencode(html_entity_decode(get_option( 'wikio_neighbours_width' )));
		$wikio_neighbours_items = urlencode(html_entity_decode(get_option( 'wikio_neighbours_items' )));
		$wikio_neighbours_blog_url = urlencode(html_entity_decode(get_option( 'wikio_neighbours_blog_url' )));
		$wikio_neighbours_dir = urlencode(html_entity_decode(get_option( 'wikio_neighbours_dir' )));
		$WidgetTitle = html_entity_decode(get_option( 'wikio_neighbours_title' ));
		
		$WidgetTitle = stripslashes($WidgetTitle);
		$wikio_neighbours_style = urlencode(html_entity_decode(get_option( 'wikio_neighbours_style' )));
		
		// Hack for the language / country
		if ( $wikio_tld == "co.uk" ){
			$wikio_country = "uk";
		}
		else if ( $wikio_tld == "com" ){
			$wikio_country = "uk";
		} else {
			$wikio_country = $wikio_tld;
		}
		
				
		extract($args);
		
		// Hack for the title
		if ($wikio_neighbours_style == "light"){ $WidgetTitle2 = ''; } else { $WidgetTitle2 = $WidgetTitle;}
		echo $before_widget.$before_title.$WidgetTitle2.$after_title;
		
		// widget abo
			// Return all options values
			$wikio_widgets_options = get_option( 'wikio_widgets_options' );
			
			foreach ( $wikio_widgets_options as $key_w=>$value_w ){
				
				$widgets.= $value_w.'+';
				
			}
			
			?>
			
			<a href="http://www.wikio.<?php echo $wikio_tld; ?>" class="wikio-neighbours"><?php _e('neighbours widget by Wikio'); ?></a>
			<script type="text/javascript" src="http://widgets.wikio.fr/js/source/neighbours?
			style=<?php echo $wikio_neighbours_style; ?>&wtag=wp&dir=in&country=<?php echo $wikio_country; ?>&items=20&source=1&width=<?php echo $wikio_neighbours_width; ?>&date=1&content=1&items=<?php echo $wikio_neighbours_items; ?>&dir=<?php echo $wikio_neighbours_dir; ?>&url=<?php echo $wikio_neighbours_blog_url; ?><?php if ($wikio_neighbours_style == "light"){echo '&title='.urlencode($WidgetTitle);} ?>" charset="utf-8">
			</script>

		<?php
				
		echo $after_widget;
	}

	function widget_options() {
		
		if ($_POST['wikio_neighbours_title']) {
			
			$option = $_POST['wikio_neighbours_title'];
			update_option( 'wikioneighbours_title', $option );
			
		}
		
		echo '<p><a href="themes.php?page='.dirname(plugin_basename(__FILE__)).'/wikio-neighbours-sidebar-basic.php">'.__('Click here to configure widget!',$wikio_neighbours_domain).'</a></p>';
	}
	
}



// All the class
$wikio_neighbours_sub_widget &= new wikio_neighbours_sub_widget();
?>