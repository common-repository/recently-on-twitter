=== Recently on Twitter ===
Contributors: gregory80
Tags: widget, twitter, social media, jsonp, plugin
Requires at least: 2.6
Tested up to: 2.9
Stable tag: trunk

Fast, flash free, non-cached view of your Recent Tweets on Twitter

== Description ==
The Twitter Recent Tweets Plugin / Widget let's you display your tweets in the sidebar of your blog, useful if you use WP-Cache / Super Cache and want the feed to be fresh. It leverages jQuery and JSONP to provide a never-stale, asynchronous connection to Twitter.


== Installation ==

1. Unzip twitter-recent-tweets-widget.zip and upload the entire folder to wp-content/plugins.
1. Activate the plugin through the 'Plugins' menu in WordPress

= Widget Enabled Themes = 
* Go To The Widget Screen Under Appearance. 
* Add The Recently on Twitter Widget.
* Add Your own Twitter username to see your recent tweets.
* Select The number of Recent Tweets you want to display
* Save your changes


= Non Widget Enabled Themes =
* Add the recenttwitter_compressed.js file to the head of your document
* Add The following HTML to your sidebar, replacing &#95;&#95;YOUR_USER_ID&#95;&#95; with your actual Twitter username
* <pre>&lt;div class="RecentlyOnTwitterTweetsBox">
        &lt;style type="text/css">
        	&lt;!--
				.secondary ul li.recentlyOnTwitterListItem {padding-bottom:9px;}
			-->
        &lt;/style>
	&lt;h4>&lt;a href="http://twitter.com/&#95;&#95;YOUR_USER_ID&#95;&#95;" target="_blank">Recently on Twitter&lt;/a>&lt;/h4>
	 &lt;ul id="recentlyOnTwitterListDisplayContainer">&lt;/ul>
	 &lt;script type="text/javascript">
	 	jQuery('#recentlyOnTwitterListDisplayContainer').recentTweets('&#95;&#95;YOUR_USER_ID&#95;&#95;', { params : { count : 5 }})
	 &lt;/script>
&lt;/div&gt;</pre>



== Frequently Asked Questions ==
= How Does It Work =
Magic?! But seriously. The plugin / widget leverages JSONP to connect to the Twitter API for a specified username to provide a never-stale, asynchronous connection to Twitter. 

= What awesome technologies are at play =
jQuery, JSONP, PHP & Wordpress!

= How do I install it =
See the Installation section

= Who do I complain to if it's broken? =
gregory.tomlinson [at] gmail [dot] com

== Screenshots ==
1. View of the widget in the K2 Theme.

