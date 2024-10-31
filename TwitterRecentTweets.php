<?php

/*
Plugin Name: Recently on Twitter
Plugin URI: http://gregorytomlinson.com/encoded/recently-on-twitter/
Description: Let's you display your most recent tweets in the sidebar of your blog, useful if you use WP-Cache / Super Cache and want the feed to be fresh
Author: Gregory Tomlinson
Author URI: http://www.gregorytomlinson.com/encoded/
Version: 0.0.1

Copyright Gregory Tomlinson (email : gregory.tomlinson [at] gmail [dot] com | http://gregorytomlinson.com/encoded/)

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


class TwitterRecentTweetsWidget {

	var $name = 'Recently on Twitter';
	var $safe_name = 'recenlty_on_twitter_widget';
	var $twitter_profile_base_url = 'http://twitter.com/';
	var $user_db_options = 'recenlty_on_twitter_widget';	
	var $user_db_option_count = 'recenlty_on_twitter_widget_count';
	var $pluginURL;		

	function TwitterRecentTweets() { $this->__construct(); }

	function __construct() {
	
		$this->pluginURL = WP_CONTENT_URL . "/plugins/" . plugin_basename(dirname(__FILE__));	
	
		add_action("wp_head", array(&$this,"serveHeader"));
//		$widget_ops = array('description' => __('Arbitrary text or HTML'));		
		register_sidebar_widget($this->name, array( &$this, 'widget_twitterrecenttweets' ));
		register_widget_control($this->name, array( &$this, 'widget_twitterrecenttweets_controls'));			
		// make sure it has jquery -- 2.7
		wp_enqueue_script("jquery", false, false, "1.3.2");	
	}

	function activate() {
	}

	function deactivate() {
	}

	function widget_twitterrecenttweets( $args ) {
		extract( $args );
		$db_data = get_option($this->safe_name);
		//print_r($args);
		$user = ( isset( $db_data['user_id'] ) ) ? $db_data['user_id'] : 'gregory80';
		$count = ( isset( $db_data['count'] ) ) ? $db_data['count'] : '5';		
        $widget_body = <<<EOD
        $before_widget
        <style type="text/css">
        	<!--
				.secondary ul li.recentlyOnTwitterListItem { padding-bottom:9px;}
			-->
        </style>
        $before_title 
        	<a class="recentlyOnTwitterHeaderLink" style="display:none;" href="$this->twitter_profile_base_url$user" target="_blank">$this->name</a>
        $after_title
        <ul id='recentlyOnTwitterListDisplayContainer'></ul>
        <script type="text/javascript">
            jQuery(function() {
                jQuery('#recentlyOnTwitterListDisplayContainer').recentTweets( '$user', { params : { count : "$count" } } )
                    .bind('recentTweetsLoaded', function() {
                        jQuery('.recentlyOnTwitterHeaderLink').fadeIn('normal')
                    });
            });
        	
        </script>
        $after_widget
EOD;

        if( $user != '' ) { echo $widget_body; }
	}

	function widget_twitterrecenttweets_controls() {
		//
		
		$count_nums = array('1', '5', '10', '15', '20');
		
		$db_data = get_option($this->safe_name);
		$image_url = $this->pluginURL . '/images/twitter.png';
		$user = $db_data['user_id'];
		$count = $db_data['count'];		
		
		$options_string = '';
		for( $i=0; $i<count( $count_nums ); $i++ ) {
			$options_string .= '<option value="'. $count_nums[$i] . '" ';
			
			if( $count_nums[$i] == $count ) { $options_string .= ' selected="selected"'; }
			
			$options_string .= "> " . $count_nums[$i] . " </option>";
		}
		
		
		$data = <<<EOD
		<p><label><img src="$image_url" border="0" /> Twitter username<input type="text" name="$this->user_db_options" value="$user" /> </label></p>
		<p><label>Count <select name="$this->user_db_option_count">
			$options_string
		</select> </label></p>		
EOD;

		echo $data;

		if (isset($_POST[$this->user_db_options])){
		
			$db_data['user_id'] = attribute_escape($_POST[$this->user_db_options]);
			$db_data['count'] = attribute_escape($_POST[$this->user_db_option_count]);			

			update_option( $this->safe_name, $db_data );
		}		
	}

	
	function serveHeader() {
		$siteurl = get_option('siteurl');
	  $async = <<<EOT
<!--      <script type="text/javascript" src="$this->pluginURL/js/jquery.recentTweets.js"></script>
      <script type="text/javascript" src="$this->pluginURL/js/jquery.timeFormat.js"></script>	  -->
      
      <script type="text/javascript" src="$this->pluginURL/js/recenttwitter_compressed.js"></script>
	  
EOT;
		echo $async;	
	
	}

}


add_action('plugins_loaded', 'twitterrecenttweetswidget_loadplugin');
function twitterrecenttweetswidget_loadplugin() {
	
if (class_exists('TwitterRecentTweetsWidget')) {
     $TwitterRecentTweetsWidget = new TwitterRecentTweetsWidget();
		
		if( function_exists("register_activation_hook") ) {		
			register_activation_hook( __FILE__, array(&$TwitterRecentTweetsWidget, 'activate'));

		}
		if( function_exists("register_deactivation_hook") ) {		
			register_deactivation_hook( __FILE__, array(&$TwitterRecentTweetsWidget, 'deactivate'));
		}

		
	}
}



?>