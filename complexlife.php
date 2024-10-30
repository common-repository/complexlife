<?php
/*
Plugin Name: ComplexLife
Version: 0.9.8
Plugin URI: http://dbzer0.com/the-penguin-migration/complexlife
Description: Complexlife is a fork of <a href="http://kierandelaney.net/blog/projects/simplelife/">SimpleLife</a> and like it, it is a fully configurable simplepie based plugin to produce a lifestream on your 
wordpress powered blog. It makes use of the excellent <a href="http://simplepie.org/">SimplePie</a>. Either use the widget or place <code>&lt;?php complexlife(); ?></code> in a page template.
Author: Db0
Original Author: Kieran Delaney
Author URI: http://dbzer0.com

    Copyleft 2008 Konstantine Thoukydidis :) (email : mail@dbzer0.com)
    Copyright 2007  Kieran Delaney  (email : hello@kierandelaney.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program (license.txt); if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//code for stripos for php4 installations 
if (!function_exists("stripos")) {
    function stripos($haystack, $needle, $offset=0) {
        return strpos(strtolower($haystack), strtolower($needle), $offset);
    }
}


//timezone code
if (get_option('simple_tz')){
if (function_exists("date_default_timezone_set")) {
  date_default_timezone_set(get_option('simple_tz'));   
}else{
   putenv('TZ='.get_option('simple_tz'));
}
}

//Function: Add Color Picker Javascript to admin head
add_action('admin_head', 'simple_title_colour_js');
function simple_title_colour_js() { 
echo '<script src="'.get_bloginfo('home').'/wp-content/plugins/complexlife/201a.js" type="text/javascript"></script>'; } 

//create options page
function complexlifeOptions() {
   if (function_exists('add_options_page')) {
		add_options_page('ComplexLife Options', 'ComplexLife', 8, basename(__FILE__), 'complexlifeOptionsPage');
    }
}

function complexlifeOptionsPage() {
  if (isset($_POST['info_update'])) { ?>
		<div id="message" class="updated fade">
		<p><strong>
<?php

                if(!$_POST['advanced_options']){
                   update_option('advanced_options', 0);
                }else {
                   update_option('advanced_options', 1);}

                if($_POST['s_flickr']){
                   update_option('s_flickr', $_POST['s_flickr']);
                    if(!$_POST['flickrback'] || !$_POST['flickrtext']){
                    _e('Warning: You\'ve given me a Flickr ID - but you\'ve not chosen all the style info!<br />', 'English');
                    }
                   update_option('flickrback', $_POST['flickrback']);
                   update_option('flickrtext', $_POST['flickrtext']);
                }else{
                   update_option('s_flickr', '');
                   update_option('flickrtext', '');
                   update_option('flickrback', '');
                }
                if ( isset( $_POST['s_flickr_thumbs'] ) )
			update_option('s_flickr_thumbs', 'true' );
		else
			update_option('s_flickr_thumbs', 'false' );

                if ( isset( $_POST['s_flickr_title'] ) )
			update_option('s_flickr_title', 'true' );
		else
			update_option('s_flickr_title', 'false' );

                if($_POST['s_delicious']){
                   update_option('s_delicious', $_POST['s_delicious']);
                    if(!$_POST['delback'] || !$_POST['deltext']){
                    _e('Warning: You\'ve given me a Delicious Username - but you\'ve not chosen all the style info!<br />', 'English');
                    }
                   update_option('delback', $_POST['delback']);
                   update_option('deltext', $_POST['deltext']);
                   update_option('del_extra_text', $_POST['del_extra_text']);
                   update_option('del_title', $_POST['del_title']);
                }else{
                   update_option('s_delicious', '');
                   update_option('deltext', '');
                   update_option('delback', '');
                   update_option('del_extra_text', '');
                   update_option('del_title', '');
                }

                if($_POST['s_blog']){
                   update_option('s_blog', $_POST['s_blog']);
                    if(!$_POST['blogback'] || !$_POST['blogtext']){
                    _e('Warning: You\'ve given me a blog feed - but you\'ve not chosen all the style info!<br />', 'English');
                    }
                    if(!$_POST['blogico']){
                    _e('Warning: You\'ve given me a blog feed - but you\'ve not chosen an icon!<br />', 'English');
                    }
                   update_option('blogico', $_POST['blogico']);
                   update_option('blogback', $_POST['blogback']);
                   update_option('blogtext', $_POST['blogtext']);
                   update_option('blog_title', $_POST['blog_title']);
                   update_option('blog_extra_text', $_POST['blog_extra_text']);

                }else{
                   update_option('s_blog', '');
                   update_option('blogtext', '');
                   update_option('blogback', '');
                   update_option('blogico', $_POST['blogico']);
                   update_option('blog_title', '');
                   update_option('blog_extra_text', '');
                }

                if($_POST['s_lastfm']){
                   update_option('s_lastfm', $_POST['s_lastfm']);
                    if(!$_POST['lastback'] || !$_POST['lasttext']){
                    _e('Warning: You\'ve given me a Last.fm Username - but you\'ve not chosen all the style info!<br />', 'English');
                    }
                   update_option('lastback', $_POST['lastback']);
                   update_option('lasttext', $_POST['lasttext']);
                }else{
                   update_option('s_lastfm', '');
                   update_option('lasttext', '');
                   update_option('lastback', '');
                }
                if ( isset( $_POST['lastfm_recent_tracks'] ) )
			update_option('lastfm_recent_tracks', 'true' );
		else
			update_option('lastfm_recent_tracks', 'false' );

                if($_POST['s_facebook'] || $_POST['facebook_posted']){
                   update_option('s_facebook', $_POST['s_facebook']);
                   update_option('facebook_posted', $_POST['s_facebook_posted']);
                    if(!$_POST['faceback'] || !$_POST['facetext']){
                    _e('Warning: You\'ve given me a Facebook Status Feed - but you\'ve not chosen all the style info!<br />', 'English');
                    }
                   update_option('faceback', $_POST['faceback']);
                   update_option('facetext', $_POST['facetext']);
                }else{
                   update_option('s_facebook', '');
                   update_option('facebook_posted', '');
                   update_option('facetext', '');
                   update_option('faceback', '');
                }

                if($_POST['simple_feed1']){
                   update_option('simple_feed1', $_POST['simple_feed1']);
                    if(!$_POST['simple_back1'] || !$_POST['simple_text1']){
                    _e('Warning: You\'ve added an additional feed (Exra Feed 1) - but you\'ve not chosen all the style info!<br />', 'English');
                    }
                    if(!$_POST['simple_ico1']){
                    _e('Warning: You\'ve defined an additional feed - but you\'ve not chosen an icon!<br />', 'English');
                    }
                   update_option('simple_ico1', $_POST['simple_ico1']);
                   update_option('simple_back1', $_POST['simple_back1']);
                   update_option('simple_text1', $_POST['simple_text1']);
                   update_option('f1_extra_text', $_POST['f1_extra_text']);
                   update_option('f1_title', $_POST['f1_title']);
                }else{
                   update_option('simple_feed1', '');
                   update_option('simple_text1', '');
                   update_option('simple_back1', '');
                   update_option('simple_ico1', $_POST['simple_ico1']);
                   update_option('f1_extra_text', '');
                   update_option('f1_title', '');
                }

                if($_POST['simple_feed2']){
                   update_option('simple_feed2', $_POST['simple_feed2']);
                    if(!$_POST['simple_back2'] || !$_POST['simple_text2']){
                    _e('Warning: You\'ve added an additional feed (Exra Feed 2) - but you\'ve not chosen all the style info!<br />', 'English');
                    }
                    if(!$_POST['simple_ico2']){
                    _e('Warning: You\'ve defined an additional feed - but you\'ve not chosen an icon!<br />', 'English');
                    }
                   update_option('simple_ico2', $_POST['simple_ico2']);
                   update_option('simple_back2', $_POST['simple_back2']);
                   update_option('simple_text2', $_POST['simple_text2']);
                   update_option('f2_extra_text', $_POST['f2_extra_text']);
                   update_option('f2_title', $_POST['f2_title']);
                }else{
                   update_option('simple_feed2', '');
                   update_option('simple_text2', '');
                   update_option('simple_back2', '');
                   update_option('simple_ico2', $_POST['simple_ico2']);
                   update_option('f2_extra_text', '');
                   update_option('f2_title', '');
                }

                if($_POST['simple_feed3']){
                   update_option('simple_feed3', $_POST['simple_feed3']);
                    if(!$_POST['simple_back3'] || !$_POST['simple_text3']){
                    _e('Warning: You\'ve added an additional feed (Exra Feed 3) - but you\'ve not chosen all the style info!<br />', 'English');
                    }
                    if(!$_POST['simple_ico3']){
                    _e('Warning: You\'ve defined an additional feed - but you\'ve not chosen an icon!<br />', 'English');
                    }
                   update_option('simple_ico3', $_POST['simple_ico3']);
                   update_option('simple_back3', $_POST['simple_back3']);
                   update_option('simple_text3', $_POST['simple_text3']);
                   update_option('f3_extra_text', $_POST['f3_extra_text']);
                   update_option('f3_title', $_POST['f3_title']);
                }else{
                   update_option('simple_feed3', '');
                   update_option('simple_text3', '');
                   update_option('simple_back3', '');
                   update_option('simple_ico3', $_POST['simple_ico3']);
                   update_option('f3_extra_text', '');
                   update_option('f3_title', '');
                }

                if($_POST['simple_feed4']){
                   update_option('simple_feed4', $_POST['simple_feed4']);
                    if(!$_POST['simple_back4'] || !$_POST['simple_text4']){
                    _e('Warning: You\'ve added an additional feed (Exra Feed 4) - but you\'ve not chosen all the style info!<br />', 'English');
                    }
                    if(!$_POST['simple_ico4']){
                    _e('Warning: You\'ve defined an additional feed - but you\'ve not chosen an icon!<br />', 'English');
                    }
                   update_option('simple_ico4', $_POST['simple_ico4']);
                   update_option('simple_back4', $_POST['simple_back4']);
                   update_option('simple_text4', $_POST['simple_text4']);
                   update_option('f4_extra_text', $_POST['f4_extra_text']);
                   update_option('f4_title', $_POST['f4_title']);
                }else{
                   update_option('simple_feed4', '');
                   update_option('simple_text4', '');
                   update_option('simple_back4', '');
                   update_option('simple_ico4', $_POST['simple_ico4']);
                   update_option('f4_extra_text', '');
                   update_option('f4_title', '');
                }

                if($_POST['simple_feed5']){
                   update_option('simple_feed5', $_POST['simple_feed5']);
                    if(!$_POST['simple_back5'] || !$_POST['simple_text5']){
                    _e('Warning: You\'ve added an additional feed (Exra Feed 5) - but you\'ve not chosen all the style info!<br />', 'English');
                    }
                    if(!$_POST['simple_ico5']){
                    _e('Warning: You\'ve defined an additional feed - but you\'ve not chosen an icon!<br />', 'English');
                    }
                   update_option('simple_ico5', $_POST['simple_ico5']);
                   update_option('simple_back5', $_POST['simple_back5']);
                   update_option('simple_text5', $_POST['simple_text5']);
                   update_option('f5_extra_text', $_POST['f5_extra_text']);
                   update_option('f5_title', $_POST['f5_title']);
                }else{
                   update_option('simple_feed5', '');
                   update_option('simple_text5', '');
                   update_option('simple_back5', '');
                   update_option('simple_ico5', $_POST['simple_ico5']);
                   update_option('f5_extra_text', '');
                   update_option('f5_title', '');
                }

                if($_POST['greader_shared']){
                   update_option('greader_shared', $_POST['greader_shared']);
                    if(!$_POST['greader_shared_back'] || !$_POST['greader_shared_text']){
                    _e('Warning: You\'ve added a google reader shared items feed - but you\'ve not chosen all the style info!<br />', 'English');
                    }
                   update_option('greader_shared_back', $_POST['greader_shared_back']);
                   update_option('greader_shared_text', $_POST['greader_shared_text']);
                   update_option('greader_shared_extra_text', $_POST['greader_shared_extra_text']);
                   update_option('greader_shared_nr', $_POST['greader_shared_nr']);
                }else{
                   update_option('greader_shared', '');
                   update_option('greader_shared_nr', '');
                   update_option('greader_shared_back', '');
                   update_option('greader_shared_text', '');
                }


                if($_POST['greader_comments']){
                   update_option('greader_comments', $_POST['greader_comments']);
                    if(!$_POST['comments_back'] || !$_POST['comments_text']){
                    _e('Warning: You\'ve added a google reader comment feed - but you\'ve not chosen all the style info!<br />', 'English');
                    }
                    if(!$_POST['greader_comments_author']){
                    _e('Warning: You\'ve added an google reader comment feed - but you\'ve not typed in an author alias. No comments will be displayed!<br />', 'English');
                    }
                    if(!$_POST['greader_comments_nr']){
                    _e('Warning: You\'ve added a google reader comments feed - but you\'ve not adeed a number of items. Since the default is 20, you might see less than you expect, especially if you are tracking a lot of conversations!<br />', 'English');
                    }
                   update_option('comments_back', $_POST['comments_back']);
                   update_option('comments_text', $_POST['comments_text']);
                   update_option('greader_comments_author', $_POST['greader_comments_author']);
                   update_option('comments_extra_text', $_POST['comments_extra_text']);
                   update_option('comments_title', $_POST['comments_title']);
                   update_option('greader_comments_nr', $_POST['greader_comments_nr']);
                }else{
                   update_option('comments_back', $_POST['comments_back']);
                   update_option('comments_text', $_POST['comments_text']);
                   update_option('comments_extra_text', $_POST['comments_extra_text']);
                   update_option('comments_title', $_POST['comments_title']);
                }


                if($_POST['greader_lifestream']){
                   update_option('greader_lifestream', $_POST['greader_lifestream']);
                    if(!$_POST['greader_lifestream_nr']){
                    _e('Warning: You\'ve added a google reader lifestream feed - but you\'ve not adeed a number of items. Since the default is 20, you might see less than you expect, especially if you have a lot of feeds in it!<br />', 'English');
                    }
                   update_option('greader_lifestream_nr', $_POST['greader_lifestream_nr']);
                   update_option('twitback', $_POST['twitback']);
                   update_option('twittext', $_POST['twittext']);
                   update_option('twitter_extra_text', $_POST['twitter_extra_text']);
                   update_option('twitter_title', $_POST['twitter_title']);
                   update_option('twitter_username', $_POST['twitter_username']);
                   update_option('suback', $_POST['suback']);
                   update_option('sutext', $_POST['sutext']);
                   update_option('su_extra_text', $_POST['su_extra_text']);
                   update_option('su_title', $_POST['su_title']);
                   update_option('su_username', $_POST['su_username']);
                   update_option('redditback', $_POST['redditback']);
                   update_option('reddittext', $_POST['reddittext']);
                   update_option('reddit_extra_text', $_POST['reddit_extra_text']);
                   update_option('reddit_title', $_POST['reddit_title']);
                   update_option('reddit_username', $_POST['reddit_username']);
                   update_option('gsfn_back', $_POST['gsfn_back']);
                   update_option('gsfn_text', $_POST['gsfn_text']);
                   update_option('gsfn_extra_text', $_POST['gsfn_extra_text']);
                   update_option('gsfn_title', $_POST['gsfn_title']);
                   update_option('gsfn_username', $_POST['gsfn_username']);
                   update_option('pmog_back', $_POST['pmog_back']);
                   update_option('pmog_text', $_POST['pmog_text']);
                   update_option('pmog_extra_text', $_POST['pmog_extra_text']);
                   update_option('pmog_title', $_POST['pmog_title']);
                   update_option('pmog_username', $_POST['pmog_username']);

                   update_option('greader_custom1_back', $_POST['greader_custom1_back']);
                   update_option('greader_custom1_text', $_POST['greader_custom1_text']);
                   update_option('greader_custom1_extra_text', $_POST['greader_custom1_extra_text']);
                   update_option('greader_custom1_title', $_POST['greader_custom1_title']);
                   update_option('greader_custom1_keyword', $_POST['greader_custom1_keyword']);
                   update_option('greader_custom1_crop', $_POST['greader_custom1_crop']);
                   update_option('greader_custom1_ico', $_POST['greader_custom1_ico']);

                   update_option('greader_custom2_back', $_POST['greader_custom2_back']);
                   update_option('greader_custom2_text', $_POST['greader_custom2_text']);
                   update_option('greader_custom2_extra_text', $_POST['greader_custom2_extra_text']);
                   update_option('greader_custom2_title', $_POST['greader_custom2_title']);
                   update_option('greader_custom2_keyword', $_POST['greader_custom2_keyword']);
                   update_option('greader_custom2_crop', $_POST['greader_custom2_crop']);
                   update_option('greader_custom2_ico', $_POST['greader_custom2_ico']);

                   update_option('greader_custom3_back', $_POST['greader_custom3_back']);
                   update_option('greader_custom3_text', $_POST['greader_custom3_text']);
                   update_option('greader_custom3_extra_text', $_POST['greader_custom3_extra_text']);
                   update_option('greader_custom3_title', $_POST['greader_custom3_title']);
                   update_option('greader_custom3_keyword', $_POST['greader_custom3_keyword']);
                   update_option('greader_custom3_crop', $_POST['greader_custom3_crop']);
                   update_option('greader_custom3_ico', $_POST['greader_custom3_ico']);
                }else{
                   update_option('greader_lifestream', '');
                   update_option('greader_lifestream_nr', '');
                }


                if($_POST['s_digg']){
                   update_option('s_digg', $_POST['s_digg']);
                    if(!$_POST['diggback'] || !$_POST['diggtext']){
                    _e('Warning: You\'ve given me a digg Username - but you\'ve not chosen all the style info!<br />', 'English');
                    }
                   update_option('diggback', $_POST['diggback']);
                   update_option('diggtext', $_POST['diggtext']);
                   update_option('digg_extra_text', $_POST['digg_extra_text']);
                   update_option('digg_title', $_POST['digg_title']);
                }else{
                   update_option('s_digg', '');
                   update_option('diggtext', '');
                   update_option('diggback', '');
                   update_option('digg_extra_text', '');
                   update_option('digg_title', '');
                }

                if($_POST['simple_flimit']){
                   update_option('simple_flimit', $_POST['simple_flimit']);
                }else{
                   update_option('simple_flimit', '0');
                }

                if($_POST['simple_datelimit']){
                   update_option('simple_datelimit', $_POST['simple_datelimit']);
                }else{
                   update_option('simple_datelimit', '0');
                }

                if($_POST['simple_cache']){
                   update_option('simple_cache', $_POST['simple_cache']);
                }else{
                   update_option('simple_cache', '0');
                }

                if($_POST['default_back']){
                   update_option('default_back', $_POST['default_back']);
                }

                if($_POST['default_text']){
                   update_option('default_text', $_POST['default_text']);
                }

                if($_POST['extra_prep_text']){
                   update_option('extra_prep_text', $_POST['extra_prep_text']);
                }

                if(!$_POST['big_chart_enabled']){
                   update_option('big_chart_enabled', 0);
                }else {
                   update_option('big_chart_enabled', 1);}
		update_option('big_chart_background', $_POST['big_chart_background']);
		update_option('big_chart_colour1', $_POST['big_chart_colour1']);
		update_option('big_chart_colour2', $_POST['big_chart_colour2']);
		update_option('big_chart_colour3', $_POST['big_chart_colour3']);
		update_option('big_chart_size', $_POST['big_chart_size']);

                if(!$_POST['small_chart_enabled']){
                   update_option('small_chart_enabled', 0);
                }else {
                   update_option('small_chart_enabled', 1);}
		update_option('small_chart_background', $_POST['small_chart_background']);
		update_option('small_chart_colour', $_POST['small_chart_colour']);
		update_option('small_chart_size', $_POST['small_chart_size']);

                if($_POST['simplehovertext']){
                   update_option('simplehovertext', $_POST['simplehovertext']);
                }else{
                   _e('Warning: You\'ve not chosen a text color for the hover style. Things will get ugly.<br />', 'English');
                   update_option('simplehovertext', '');
                }

                if($_POST['simplehoverback']){
                   update_option('simplehoverback', $_POST['simplehoverback']);
                }else{
                   _e('Warning: You\'ve not chosen a background color for the hover style. Things will get ugly.<br />', 'English');
                   update_option('simplehoverback', '');
                }

                if($_POST['simple_hoverborder']){
                   update_option('simple_hoverborder', $_POST['simple_hoverborder']);
                }else{
                   _e('Warning: You\'ve not chosen a border color for the hover style. Things will get ineresting.<br />', 'English');
                   update_option('simple_hoverborder', '');
                }

                if($_POST['simple_time']){
                   update_option('simple_time', $_POST['simple_time']);
                }else{
                   _e('Warning: You\'ve not chosen a time format - resetting to default<br />', 'English');
                   update_option('simple_time', 'H:i');
                }

                if($_POST['simple_date']){
                   update_option('simple_date', $_POST['simple_date']);
                }else{
                   _e('Warning: You\'ve not chosen a date format - resetting to default<br />', 'English');
                   update_option('simple_date', 'M jS');
                }

                if($_POST['simple_tz']){
                   update_option('simple_tz', $_POST['simple_tz']);
                }else{
                   _e('Warning: You\'ve not chosen a timezone - using server default.<br />', 'English');
                   update_option('simple_tz', '');
                }


?>OPTIONS UPDATED
                </strong></p>
                </div>
<?php } ?>

<div id="colorpicker201" class="colorpicker201"></div>
  	<div class=wrap>
	<form method="post">
        <?php echo '<h2>ComplexLife Options</h2>'; ?>
        <?php _e('ComplexLife combines your data feeds (in <em>most</em> feed formats) from around the web, orders them, styles them and presents them as a Lifestream in your wordpress blog. After setting the options below, use the function <code>&lt;?php complexlife(); ?></code> - See the <a href="http://dbzer0.com/complexlife">ComplexLife Plugin Homepage</a> or the <a href="http://kierandelaney.net/blog/projects/simplelife/">SimpleLife WP Plugin Website</a> for documentation and updates. Insert your lifestream into your sidebar, or construct an entire recent web history all with one simple plugin. Read the instructions, and provide exactly what you are asked for - its not all usernames! Feel free to use the remaining spare feeds for any service missing. Choosing a text and background colour for the entries in the lifestream will show you that color. Click update and the username box will give you a preview of the styles for that service.<br /><br />
        Remember, insert <code>&lt;?php complexlife(); ?></code> into any page template to insert the lifestream, or use the sidebar widget.<br /><br />
        <h3>Legend</h3><ul>
        <li>Username: Your username for that service. We use that to draw the correct feed or crop it from the description.</li>
        <li>Feed Address: The full feed url of that service. Grab it as with any other feed reader.</li>
        <li>Feed Icon: The icon displayed next to each item of this type.</li>
        <li>Extra Pepended Text: This text will be prepended with the same colour always at the start of each item that has it defined.This might help in readability.</li>
        <li>Title: This text will appear as the Pie Chart Title and as the link title for each item of this feed. That is, every time one rolls the mouse over it. If not given the default title of the feed will be used.</li>
        </ul>', 'English'); ?>

     <div class="submit"><input type="submit" name="info_update" value="<?php _e('Update Options', 'English'); ?> &raquo;" /></div>

	<table>
	  <tr><td><h3><?php _e('General Settings', 'English'); ?></h3></td>
          <td>&nbsp;</td></tr>
	  <tr><td><label for="advanced_options"><?php _e('Advanced Options? If you feel overwhelmed by the number of options provided, uncheck this. This will hide the small chart, the prepended texts and title textboxes. <b>Warning:</b> If you uncheck this, the hidden fields will be cleared!', 'English') ?></label></td><td><input type="checkbox" name="advanced_options" id="advanced_options" <?php if(get_option('advanced_options') == 1){echo 'checked="checked"';} ?> value="1" /></td></tr>
          <td>&nbsp;</td></tr>
	  <tr><td><label for="simple_flimit"><?php _e('Max No. Of Items To Show (0 = Unlimited): ', 'English') ?></label></td><td><input type="text" name="simple_flimit" id="simple_flimit" maxlength="3" size="3" value="<?php if(get_option('simple_flimit')){ echo get_option('simple_flimit');} else { echo '0';} ?>" /></td></tr>

	  <tr><td><label for="simple_datelimit"><?php _e('Number of day history to show (0 = Unlimited): ', 'English') ?></label></td><td><input type="text" name="simple_datelimit" id="simple_datelimit" maxlength="3" size="3" value="<?php if(get_option('simple_datelimit')){ echo get_option('simple_datelimit');} else { echo '0';} ?>" /></td></tr>
          <tr><td><label for="simple_cache"><?php _e('Cache Feeds For (Min): ', 'English') ?></label></td><td><input type="text" name="simple_cache" id="simple_cache" maxlength="2" size="2" value="<?php if(get_option('simple_cache')){ echo get_option('simple_cache');} else { echo '0';} ?>" /></td></tr>
<tr><td><label for="simple_time"><?php _e('Time Format: ', 'English') ?></label></td><td><input type="text" name="simple_time" id="simple_time" maxlength="10" size="10" value="<?php echo get_option('simple_time'); ?>" /></td></tr><tr><td>&nbsp;</td><td>Output: <strong><?php echo date(get_option('simple_time')); ?></strong></td></tr>	
<tr><td><label for="simple_date"><?php _e('Date Format: ', 'English') ?></label><br /><a href="http://uk3.php.net/date">Date/Time Format Documentation</a><br /><em>Update options to update time/date previews.</em></td><td><input type="text" name="simple_date" id="simple_date" maxlength="10" size="10" value="<?php echo get_option('simple_date'); ?>" /><br />Output: <strong><?php echo date(get_option('simple_date')); ?></strong></td></tr>
<tr><td><label for="simple_tz"><?php _e('Timezone: ', 'English') ?></label><br /><a href="http://uk3.php.net/manual/en/timezones.php">Timezones</a></td><td><input type="text" name="simple_tz" id="simple_tz" maxlength="20" size="20" value="<?php echo get_option('simple_tz'); ?>" /></td></tr>
	   <tr><td colspan=2><?php _e('<strong>Warning:</strong> Simplelife uses PHP5 to force a specific timezone. If you do not run on PHP5, in an attempt to be as wide reaching as possible Simplelife will attempt to set the environment variable. This occasionaly gets messy depending on your platform (some windows servers for example). <a href="http://php.net/#2007-07-13-1">PHP4 is dead anyway</a> - upgrade.', 'English') ?></td></tr>
   
	  <tr><td><h3><?php _e('Chart Settings', 'English'); ?></h3></td>
          <td>&nbsp;</td></tr>
	  <tr><td><label for="big_chart_enabled"><?php _e('Enable Large Chart? ', 'English') ?></label></td><td><input type="checkbox" name="big_chart_enabled" id="big_chart_enabled" <?php if(get_option('big_chart_enabled') == 1){echo 'checked="checked"';} ?> value="1" /></td></tr>
	   <tr><td colspan=2><?php _e('The large chart is positioned at the end of your lifestream and is supposed to show a nice fat pie chart of your activities that is easy to read. You can select three colours to be used in your chart. Remember that for the charts to be active you need to have a blog feed.', 'English') ?></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('big_chart_background','big_chart_background');">Select Background:</a>&nbsp;</td><td><input type="text" id="big_chart_background" name="big_chart_background" size="7" <?php if(get_option('big_chart_background')) echo 'style="background-color: '. get_option('big_chart_background') .';"'; ?> value="<?php echo get_option('big_chart_background') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('big_chart_colour1','big_chart_colour1');">Select Colour 1:</a>&nbsp;</td><td><input type="text" id="big_chart_colour1" name="big_chart_colour1" size="7" <?php if(get_option('big_chart_colour1')) echo 'style="background-color: '. get_option('big_chart_colour1') .';"'; ?> value="<?php echo get_option('big_chart_colour1') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('big_chart_colour2','big_chart_colour2');">Select Colour 2:</a>&nbsp;</td><td><input type="text" id="big_chart_colour2" name="big_chart_colour2" size="7" <?php if(get_option('big_chart_colour2')) echo 'style="background-color: '. get_option('big_chart_colour2') .';"'; ?> value="<?php echo get_option('big_chart_colour2') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('big_chart_colour3','big_chart_colour3');">Select Colour 3:</a>&nbsp;</td><td><input type="text" id="big_chart_colour3" name="big_chart_colour3" size="7" <?php if(get_option('big_chart_colour3')) echo 'style="background-color: '. get_option('big_chart_colour3') .';"'; ?> value="<?php echo get_option('big_chart_colour3') ?>"></td></tr>
           <tr><td><label for="big_chart_size"><?php _e('Size (example: 800x200): ', 'English') ?></label></td><td><input type="text" name="big_chart_size" id="big_chart_size" maxlength="9" size="9" value="<?php echo get_option('big_chart_size'); ?>" /></td></tr>

          <?php if(get_option('advanced_options') == 1): ?>
          <td>&nbsp;</td></tr>
	  <tr><td><label for="small_chart_enabled"><?php _e('Enable Small Chart? ', 'English') ?></label></td><td><input type="checkbox" name="small_chart_enabled" id="small_chart_enabled" <?php if(get_option('small_chart_enabled') == 1){echo 'checked="checked"';} ?> value="1" /></td></tr>
	   <tr><td colspan=2><?php _e('The small chart can be positioned anywhere in the page with your lifestream by modifyng the number of pixels you want it to be away from the right or top of the screen.', 'English') ?></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('small_chart_background','small_chart_background');">Select Background:</a>&nbsp;</td><td><input type="text" id="small_chart_background" name="small_chart_background" size="7" <?php if(get_option('small_chart_background')) echo 'style="background-color: '. get_option('small_chart_background') .';"'; ?> value="<?php echo get_option('small_chart_background') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('small_chart_colour','small_chart_colour');">Select Colour :</a>&nbsp;</td><td><input type="text" id="small_chart_colour" name="small_chart_colour" size="7" <?php if(get_option('small_chart_colour')) echo 'style="background-color: '. get_option('small_chart_colour') .';"'; ?> value="<?php echo get_option('small_chart_colour') ?>"></td></tr>
           <tr><td><label for="small_chart_size"><?php _e('Size (example: 300x150): ', 'English') ?></label></td><td><input type="text" name="small_chart_size" id="small_chart_size" maxlength="9" size="9" value="<?php echo get_option('small_chart_size'); ?>" /></td></tr>
           <?php endif; ?>

           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td><h3><?php _e('Default Colours', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>	   
	   <tr><td colspan=2><?php _e('These are the colours that the lifestream entries will use when nothing has been set or can be matched for that item (i.e. in a google reader lifestream).', 'English') ?></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('default_back','default_back');">Select Background:</a>&nbsp;</td><td><input type="text" id="default_back" name="default_back" size="7" <?php if(get_option('default_back')) echo 'style="background-color: '. get_option('default_back') .';"'; ?> value="<?php echo get_option('default_back') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('default_text','default_text');">Select Text:</a>&nbsp;</td><td><input type="text" id="default_text" name="default_text" size="7" <?php if(get_option('default_text')) echo 'style="background-color: '. get_option('default_text') .';"'; ?> value="<?php echo get_option('default_text') ?>"></td></tr>
	   <tr><td colspan=2><?php _e('The following is the colour for the extra prepended text that you may specify at the start of each item.', 'English') ?></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('extra_prep_text','extra_prep_text');">Select Text:</a>&nbsp;</td><td><input type="text" id="extra_prep_text" name="extra_prep_text" size="7" <?php if(get_option('extra_prep_text')) echo 'style="background-color: '. get_option('extra_prep_text') .';"'; ?> value="<?php echo get_option('extra_prep_text') ?>"></td></tr>
           <?php endif; ?>


           <tr><td><h3><?php _e('Hover Styles', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>	   
	   <tr><td colspan=2><?php _e('These are the styles that the lifestream entries will assume when you hover over them. The top and bottom have a 1px border, you can color the background and color the text.', 'English') ?></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('simplehoverback','simplehoverback');">Select Background:</a>&nbsp;</td><td><input type="text" id="simplehoverback" name="simplehoverback" size="7" <?php if(get_option('simplehoverback')) echo 'style="background-color: '. get_option('simplehoverback') .';"'; ?> value="<?php echo get_option('simplehoverback') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('simplehovertext','simplehovertext');">Select Text:</a>&nbsp;</td><td><input type="text" id="simplehovertext" name="simplehovertext" size="7" <?php if(get_option('simplehovertext')) echo 'style="background-color: '. get_option('simplehovertext') .';"'; ?> value="<?php echo get_option('simplehovertext') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('simple_hoverborder','simple_hoverborder');">Select Border:</a>&nbsp;</td><td><input type="text" id="simple_hoverborder" name="simple_hoverborder" size="7" <?php if(get_option('simple_hoverborder')) echo 'style="background-color: '. get_option('simple_hoverborder') .';"'; ?> value="<?php echo get_option('simple_hoverborder') ?>"></td></tr>

	  <tr><td><h3><?php _e('Flickr Photos', 'English'); ?></h3></td>
	  <td>&nbsp;</td></tr>
          <tr><td><label for="s_flickr"><?php _e('Your Flickr ID (Try <a href="http://idgettr.com/">idgettr</a>): ', 'English') ?></label></td><td><input type="text" name="s_flickr" id="s_flickr" maxlength="20" size="20" <?php echo 'style="background-color: '. get_option('flickrback') .'; color: '. get_option('flickrtext') .';"'; ?> value="<?php if(get_option('s_flickr')) echo get_option('s_flickr'); ?>" /></td></tr>
          <tr><td><a href="javascript:onclick=showColorGrid2('flickrback','flickrback');">Select Background:</a>&nbsp;</td><td><input type="text" id="flickrback" name="flickrback" size="7" <?php if(get_option('flickrback')) echo 'style="background-color: '. get_option('flickrback') .';"'; ?> value="<?php echo get_option('flickrback') ?>"></td></tr>
          <tr><td><a href="javascript:onclick=showColorGrid2('flickrtext','flickrtext');">Select Text:</a>&nbsp;</td><td><input type="text" id="flickrtext" name="flickrtext" size="7" <?php if(get_option('flickrtext')) echo 'style="background-color: '. get_option('flickrtext') .';"'; ?> value="<?php echo get_option('flickrtext') ?>"></td></tr>
<tr><td><label><input name="s_flickr_thumbs" id="s_flickr_thumbs" value="true" type="checkbox" <?php if ( get_option('s_flickr_thumbs') == 'true' ) echo ' checked="checked" '; ?> /> <?php _e('Show Flickr Thumbnails'); ?></label></td></tr>          
<tr><td><label><input name="s_flickr_title" id="s_flickr_title" value="true" type="checkbox" <?php if ( get_option('s_flickr_title') == 'true' ) echo ' checked="checked" '; ?> /> <?php _e('Show Photo Titles (Sometimes ugly next to thumbnails...)'); ?></label></td></tr>      


           <tr><td><h3><?php _e('<a href="http://del.icio.us">del.icio.us</a> Bookmarks', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>
	   <tr><td><label for="s_delicious"><?php _e('Your Delicious Username: ', 'English') ?></label></td><td><input type="text" name="s_delicious" id="s_delicious" maxlength="20" size="20" <?php echo 'style="background-color: '. get_option('delback') .'; color: '. get_option('deltext') .';"'; ?> value="<?php echo get_option('s_delicious'); ?>" /></td></tr>
           <tr><td><a href="javascript:onclick=showColorGrid2('delback','delback');">Select Background:</a>&nbsp;</td><td><input type="text" id="delback" name="delback" size="7" <?php if(get_option('delback')) echo 'style="background-color: '. get_option('delback') .';"'; ?> value="<?php echo get_option('delback') ?>"></td></tr>
           <tr><td><a href="javascript:onclick=showColorGrid2('deltext','deltext');">Select Text:</a>&nbsp;</td><td><input type="text" id="deltext" name="deltext" size="7" <?php if(get_option('deltext')) echo 'style="background-color: '. get_option('deltext') .';"'; ?> value="<?php echo get_option('deltext') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="del_extra_text" name="del_extra_text" size="20" <?php if(get_option('del_extra_text')) echo 'style="background-color: '. get_option('del_extra_text') .';"'; ?> value="<?php echo get_option('del_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="del_title" name="del_title" size="50" <?php if(get_option('del_title')) echo 'style="background-color: '. get_option('del_title') .';"'; ?> value="<?php echo get_option('del_title') ?>"></td></tr>
           <?php endif; ?>
	        
           <tr><td><h3><?php _e('Personal Blog', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>
       	   <tr><td><label for="s_blog"><?php _e('Your Blog\'s Feed Address: ', 'English') ?></label></td><td><input type="text" name="s_blog" id="s_blog" maxlength="60" size="60" <?php echo 'style="background-color: '. get_option('blogback') .'; color: '. get_option('blogtext') .';"'; ?> value="<?php echo get_option('s_blog'); ?>" /></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('blogback','blogback');">Select Background:</a>&nbsp;</td><td><input type="text" id="blogback" name="blogback" size="7" <?php if(get_option('blogback')) echo 'style="background-color: '. get_option('blogback') .';"'; ?> value="<?php echo get_option('blogback') ?>"><br /></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('blogtext','blogtext');">Select Text:</a>&nbsp;</td><td><input type="text" id="blogtext" name="blogtext" size="7" <?php if(get_option('blogtext')) echo 'style="background-color: '. get_option('blogtext') .';"'; ?> value="<?php echo get_option('blogtext') ?>"></td></tr>
           <tr><td colspan=2><?php _e('The variable below is the filename (including extension) of your blog icon. You need to upload this to the <code>plugins/complexlife</code> directory. I\'ve included a samlple icon already which you are free to use or change.', 'English') ?></td></tr>
           <tr><td>Blog Icon Name:&nbsp;</td><td><input type="text" id="blogico" name="blogico" size="15" <?php if(get_option('blogico')) echo 'style="background-color: '. get_option('blogico') .';"'; ?> value="<?php echo get_option('blogico') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="blog_extra_text" name="blog_extra_text" size="20" <?php if(get_option('blog_extra_text')) echo 'style="background-color: '. get_option('blog_extra_text') .';"'; ?> value="<?php echo get_option('blog_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="blog_title" name="blog_title" size="50" <?php if(get_option('blog_title')) echo 'style="background-color: '. get_option('blog_title') .';"'; ?> value="<?php echo get_option('blog_title') ?>"></td></tr>
           <?php endif; ?>

	   <tr><td><h3><?php _e('Last.fm Music', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>	   
           <tr><td><label for="s_lastfm"><?php _e('Your Last.fm Username: ', 'English') ?></label></td><td><input type="text" name="s_lastfm" id="s_lastfm" maxlength="20" size="20" <?php echo 'style="background-color: '. get_option('lastback') .'; color: '. get_option('lasttext') .';"'; ?> value="<?php echo get_option('s_lastfm'); ?>" /></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('lastback','lastback');">Select Background:</a>&nbsp;</td><td><input type="text" id="lastback" name="lastback" size="7" <?php if(get_option('lastback')) echo 'style="background-color: '. get_option('lastback') .';"'; ?> value="<?php echo get_option('lastback') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('lasttext','lasttext');">Select Text:</a>&nbsp;</td><td><input type="text" id="lasttext" name="lasttext" size="7" <?php if(get_option('lasttext')) echo 'style="background-color: '. get_option('lasttext') .';"'; ?> value="<?php echo get_option('lasttext') ?>"></td></tr>
<tr><td><label><input name="lastfm_recent_tracks" id="lastfm_recent_tracks" value="true" type="checkbox" <?php if ( get_option('lastfm_recent_tracks') == 'true' ) echo ' checked="checked" '; ?> /> <?php _e('Show Recent Tracks'); ?></label></td></tr>          

	   <tr><td><h3><?php _e('Facebook Status Updates & Posted Items', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>	   
	   <tr><td colspan=2><?php _e('Facebooks easy, but there are a few steps, as your status feed is prety well hidden! Go to your own facebook profile, go to your mini feed and choose "see all" from the top right. Now choose "Status Stories" from the right hand menu. Finally, bottom of the right hand menu, copy the link location of "My Status" and paste it here - ', 'English') ?></td></tr>
           <tr><td><label for="s_facebook"><?php _e('Facebook Status Updates Feed: ', 'English') ?></label></td><td><input type="text" name="s_facebook" id="s_facebook" size="60" <?php echo 'style="background-color: '. get_option('faceback') .'; color: '. get_option('facetext') .';"'; ?> value="<?php echo get_option('s_facebook'); ?>" /></td></tr>
	   <tr><td colspan=2><?php _e('Facebooks\s posted items are not easy to find either. Go to your profile, the click "see all" on posted items, then copy the url of "My posted items" under "Subscribe to Posted Items"', 'English') ?></td></tr>
           <tr><td><label for="facebook_posted"><?php _e('Facebook Posted Items Address: ', 'English') ?></label></td><td><input type="text" name="facebook_posted" id="facebook_posted" size="60" <?php echo 'style="background-color: '. get_option('faceback') .'; color: '. get_option('facetext') .';"'; ?> value="<?php echo get_option('facebook_posted'); ?>" /></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('faceback','faceback');">Select Background:</a>&nbsp;</td><td><input type="text" id="faceback" name="faceback" size="7" <?php if(get_option('faceback')) echo 'style="background-color: '. get_option('faceback') .';"'; ?> value="<?php echo get_option('faceback') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('facetext','facetext');">Select Text:</a>&nbsp;</td><td><input type="text" id="facetext" name="facetext" size="7" <?php if(get_option('facetext')) echo 'style="background-color: '. get_option('facetext') .';"'; ?> value="<?php echo get_option('facetext') ?>"></td></tr>

	   <tr><td><h3><?php _e('Digg Activity', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>	   
           <tr><td><label for="s_digg"><?php _e('Your Digg Username: ', 'English') ?></label></td><td><input type="text" name="s_digg" id="s_digg" maxlength="20" size="20" <?php echo 'style="background-color: '. get_option('diggback') .'; color: '. get_option('diggtext') .';"'; ?> value="<?php echo get_option('s_digg'); ?>" /></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('diggback','diggback');">Select Background:</a>&nbsp;</td><td><input type="text" id="diggback" name="diggback" size="7" <?php if(get_option('diggback')) echo 'style="background-color: '. get_option('diggback') .';"'; ?> value="<?php echo get_option('diggback') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('diggtext','diggtext');">Select Text:</a>&nbsp;</td><td><input type="text" id="diggtext" name="diggtext" size="7" <?php if(get_option('diggtext')) echo 'style="background-color: '. get_option('diggtext') .';"'; ?> value="<?php echo get_option('diggtext') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="digg_extra_text" name="digg_extra_text" size="20" <?php if(get_option('digg_extra_text')) echo 'style="background-color: '. get_option('digg_extra_text') .';"'; ?> value="<?php echo get_option('digg_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="digg_title" name="digg_title" size="50" <?php if(get_option('digg_title')) echo 'style="background-color: '. get_option('digg_title') .';"'; ?> value="<?php echo get_option('digg_title') ?>"></td></tr>
           <?php endif; ?>

	   <tr><td><h3><?php _e('Google Reader Shared Items', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>	
	   <tr><td><label for="greader_shared"><?php _e('Add the full address of your google reader shared items feed:', 'English') ?></label></td><td><input type="text" name="greader_shared" id="greader_shared" size="60" <?php echo 'style="background-color: '. get_option('greader_shared_back') .'; color: '. get_option('greader_shared_text') .';"'; ?> value="<?php echo get_option('greader_shared'); ?>" /></td></tr>
	   <tr><td><label for="greader_shared_nr"><?php _e('Put the number of items we should bring from your shared items. You will need more of them, depending on how many you share, but the more we parse the slower it gets. Suggested value is 20.', 'English') ?></label></td><td><input type="text" name="greader_shared_nr" id="greader_shared_nr" size="4" value="<?php echo get_option('greader_shared_nr'); ?>" /></td></tr>
           <tr><td><a href="javascript:onclick=showColorGrid2('greader_shared_back','greader_shared_back');">Select Background:</a>&nbsp;</td><td><input type="text" id="greader_shared_back" name="greader_shared_back" size="7" <?php if(get_option('greader_shared_back')) echo 'style="background-color: '. get_option('greader_shared_back') .';"'; ?> value="<?php echo get_option('greader_shared_back') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('greader_shared_text','greader_shared_text');">Select Text:</a>&nbsp;</td><td><input type="text" id="greader_shared_text" name="greader_shared_text" size="7" <?php if(get_option('greader_shared_text')) echo 'style="background-color: '. get_option('greader_shared_text') .';"'; ?> value="<?php echo get_option('greader_shared_text') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="greader_shared_extra_text" name="greader_shared_extra_text" size="20" <?php if(get_option('greader_shared_extra_text')) echo 'style="background-color: '. get_option('greader_shared_extra_text') .';"'; ?> value="<?php echo get_option('greader_shared_extra_text') ?>"></td></tr>
           <?php endif; ?>

	   <tr><td><h3><?php _e('Comments via Google Reader', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>	
	   <tr><td><label for="greader_comments"><?php _e('Add the full address of your google reader comment feed:', 'English') ?></label></td><td><input type="text" name="greader_comments" id="greader_comments" size="60" <?php echo 'style="background-color: '. get_option('comments_back') .'; color: '. get_option('comments_text') .';"'; ?> value="<?php echo get_option('greader_comments'); ?>" /></td></tr>
	   <tr><td><label for="greader_comments_nr"><?php _e('Put the number of items we should bring from your comments feed. You will need more of them, depending on how many comment threads you are subscribed and how populat they are. but the more we parse the slower it gets. Suggested value is 100 but if you stop seeing comments that you should, then increase this value.', 'English') ?></label></td><td><input type="text" name="greader_comments_nr" id="greader_comments_nr" size="4" value="<?php echo get_option('greader_comments_nr'); ?>" /></td></tr>
           <tr><td colspan=2><?php _e('The variable below is the common alias that you use when you post comments. It is case insensitive so if you happen to forget to capitalise a character in your name, it will be caught. This must be defined if you are to grab comments from google reader.', 'English') ?></td></tr>
           <tr><td>Author alias:&nbsp;</td><td><input type="text" id="greader_comments_author" name="greader_comments_author" size="20" <?php if(get_option('greader_comments_author')) echo 'style="background-color: '. get_option('greader_comments_author') .';"'; ?> value="<?php echo get_option('greader_comments_author') ?>"></td></tr>
           <tr><td><a href="javascript:onclick=showColorGrid2('comments_back','comments_back');">Select Background:</a>&nbsp;</td><td><input type="text" id="comments_back" name="comments_back" size="7" <?php if(get_option('comments_back')) echo 'style="background-color: '. get_option('comments_back') .';"'; ?> value="<?php echo get_option('comments_back') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('comments_text','comments_text');">Select Text:</a>&nbsp;</td><td><input type="text" id="comments_text" name="comments_text" size="7" <?php if(get_option('comments_text')) echo 'style="background-color: '. get_option('comments_text') .';"'; ?> value="<?php echo get_option('comments_text') ?>"></td></tr>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="comments_extra_text" name="comments_extra_text" size="20" <?php if(get_option('comments_extra_text')) echo 'style="background-color: '. get_option('comments_extra_text') .';"'; ?> value="<?php echo get_option('comments_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="comments_title" name="comments_title" size="50" <?php if(get_option('comments_title')) echo 'style="background-color: '. get_option('comments_title') .';"'; ?> value="<?php echo get_option('comments_title') ?>"></td></tr>

	   <tr><td><h2><?php _e('Google Reader Lifestream Archive', 'English'); ?></h3></td>
           <tr><td colspan=2><?php _e('The google reader lifestream archive is a simple way to get a longer archive of your various feeds. This is needed because most feeds give the most recent 10 or 20 actions which makes your lifestream incorrect/inaccurate if you have it showing, say, the last 15 days. Since Google Reader archives everything, this allows us to keep an timeline as far back as we want.<br/><br/>In order to use this, create a Google Reader account (if you do not have one already) and create a new folder for your lifestream and make it public. After that grab the public rss feed and put in the textbox below. Add any of the supported feeds services to the folder and you are good to go. ', 'English') ?></td></tr>
	   <tr><td><label for="greader_lifestream"><?php _e('Add the full address of your google reader lifestream feed:', 'English') ?></label></td><td><input type="text" name="greader_lifestream" id="greader_lifestream" size="60" value="<?php echo get_option('greader_lifestream'); ?>" /></td></tr>
	   <tr><td><label for="greader_lifestream_nr"><?php _e('Put the number of items we should bring from your lifestream. You need more of them, if you have lots of feeds in it but the more we parse the slower it gets. Start with at least 50 and try to have 30 more for each feed', 'English') ?></label></td><td><input type="text" name="greader_lifestream_nr" id="greader_lifestream_nr" size="4" value="<?php echo get_option('greader_lifestream_nr'); ?>" /></td></tr>
           <td>&nbsp;</td></tr>	
	   <tr><td><h3><?php _e('<a href="http://intensedebate.com">Intense Debate</a> Comments', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>	
           <tr><td colspan=2><?php _e('These are automatically formatted as per your Google Reader comments above. Put your options there.<br/> You can subscribe to your personal comment feed from your IDC profile page.', 'English') ?></td></tr>
	   <tr><td><h3><?php _e('<a href="http://cocomment.com">Cocomments</a>', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>	
           <tr><td colspan=2><?php _e('Same as Intense Debate comments.<br/> You can subscribe to your personal comment feed by going to this feed and replacing [USERNAME] with your cocomment username: http://www.cocomment.com/myRss/[USERNAME].rss.', 'English') ?></td></tr>

	   <tr><td><h3><?php _e('Twitter Status Updates', 'English'); ?></h3></td>
	   <td>&nbsp;</td></tr>
           <tr><td colspan=2><?php _e('There\'s no need for a feed. Just add it to your Google Reader lifestream and we\'ll parse it from there :).', 'English') ?></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('twitback','twitback');">Select Background:</a>&nbsp;</td><td><input type="text" id="twitback" name="twitback" size="7" <?php if(get_option('twitback')) echo 'style="background-color: '. get_option('twitback') .';"'; ?> value="<?php echo get_option('twitback') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('twittext','twittext');">Select Text:</a>&nbsp;</td><td><input type="text" id="twittext" name="twittext" size="7" <?php if(get_option('twittext')) echo 'style="background-color: '. get_option('twittext') .';"'; ?> value="<?php echo get_option('twittext') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="twitter_extra_text" name="twitter_extra_text" size="20" <?php if(get_option('twitter_extra_text')) echo 'style="background-color: '. get_option('twitter_extra_text') .';"'; ?> value="<?php echo get_option('twitter_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="twitter_title" name="twitter_title" size="50" <?php if(get_option('twitter_title')) echo 'style="background-color: '. get_option('twitter_title') .';"'; ?> value="<?php echo get_option('twitter_title') ?>"></td></tr>
           <?php endif; ?>
           <tr><td><label for="twitter_username"><?php _e('Username:', 'English') ?></label></td><td><input type="text" id="twitter_username" name="twitter_username" size="20" <?php if(get_option('twitter_username')) echo 'style="background-color: '. get_option('twitter_username') .';"'; ?> value="<?php echo get_option('twitter_username') ?>"></td></tr>

	   <tr><td><h3><?php _e('Stumbleupon Activity', 'English'); ?></h3></td>
	   <td>&nbsp;</td></tr>
           <tr><td colspan=2><?php _e('Like above just add it to your Google Reader lifestream and we\'ll parse it. You can get both your review activity and your voting activity but I don not suggest you get both comments and review feeds.', 'English') ?></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('suback','suback');">Select Background:</a>&nbsp;</td><td><input type="text" id="suback" name="suback" size="7" <?php if(get_option('suback')) echo 'style="background-color: '. get_option('suback') .';"'; ?> value="<?php echo get_option('suback') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('sutext','sutext');">Select Text:</a>&nbsp;</td><td><input type="text" id="sutext" name="sutext" size="7" <?php if(get_option('sutext')) echo 'style="background-color: '. get_option('sutext') .';"'; ?> value="<?php echo get_option('sutext') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="su_extra_text" name="su_extra_text" size="20" <?php if(get_option('su_extra_text')) echo 'style="background-color: '. get_option('su_extra_text') .';"'; ?> value="<?php echo get_option('su_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="su_title" name="su_title" size="50" <?php if(get_option('su_title')) echo 'style="background-color: '. get_option('su_title') .';"'; ?> value="<?php echo get_option('su_title') ?>"></td></tr>
           <?php endif; ?>
           <tr><td><label for="su_username"><?php _e('Username:', 'English') ?></label></td><td><input type="text" id="su_username" name="su_username" size="20" <?php if(get_option('su_username')) echo 'style="background-color: '. get_option('su_username') .';"'; ?> value="<?php echo get_option('su_username') ?>"></td></tr>


	   <tr><td><h3><?php _e('Reddit History', 'English'); ?></h3></td>
	   <td>&nbsp;</td></tr>
           <tr><td colspan=2><?php _e('Just grab your reddit history feed by going to your username and grabbing the automatically provided feed. Put that in your google reader lifestream tag ang you are good to go.', 'English') ?></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('redditback','redditback');">Select Background:</a>&nbsp;</td><td><input type="text" id="redditback" name="redditback" size="7" <?php if(get_option('redditback')) echo 'style="background-color: '. get_option('redditback') .';"'; ?> value="<?php echo get_option('redditback') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('reddittext','reddittext');">Select Text:</a>&nbsp;</td><td><input type="text" id="reddittext" name="reddittext" size="7" <?php if(get_option('reddittext')) echo 'style="background-color: '. get_option('reddittext') .';"'; ?> value="<?php echo get_option('reddittext') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="reddit_extra_text" name="reddit_extra_text" size="20" <?php if(get_option('reddit_extra_text')) echo 'style="background-color: '. get_option('reddit_extra_text') .';"'; ?> value="<?php echo get_option('reddit_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="reddit_title" name="reddit_title" size="50" <?php if(get_option('reddit_title')) echo 'style="background-color: '. get_option('reddit_title') .';"'; ?> value="<?php echo get_option('reddit_title') ?>"></td></tr>
           <?php endif; ?>
           <tr><td><label for="reddit_username"><?php _e('Username:', 'English') ?></label></td><td><input type="text" id="reddit_username" name="reddit_username" size="20" <?php if(get_option('reddit_username')) echo 'style="background-color: '. get_option('reddit_username') .';"'; ?> value="<?php echo get_option('reddit_username') ?>"></td></tr>

	   <tr><td><h3><?php _e('<a href="http://getsatisfaction.com">Get Satisfaction</a> Activity', 'English'); ?></h3></td>
	   <td>&nbsp;</td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('gsfn_back','gsfn_back');">Select Background:</a>&nbsp;</td><td><input type="text" id="gsfn_back" name="gsfn_back" size="7" <?php if(get_option('gsfn_back')) echo 'style="background-color: '. get_option('gsfn_back') .';"'; ?> value="<?php echo get_option('gsfn_back') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('gsfn_text','gsfn_text');">Select Text:</a>&nbsp;</td><td><input type="text" id="gsfn_text" name="gsfn_text" size="7" <?php if(get_option('gsfn_text')) echo 'style="background-color: '. get_option('gsfn_text') .';"'; ?> value="<?php echo get_option('gsfn_text') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="gsfn_extra_text" name="gsfn_extra_text" size="20" <?php if(get_option('gsfn_extra_text')) echo 'style="background-color: '. get_option('gsfn_extra_text') .';"'; ?> value="<?php echo get_option('gsfn_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="gsfn_title" name="gsfn_title" size="50" <?php if(get_option('gsfn_title')) echo 'style="background-color: '. get_option('gsfn_title') .';"'; ?> value="<?php echo get_option('gsfn_title') ?>"></td></tr>
           <?php endif; ?>
           <tr><td><label for="gsfn_username"><?php _e('Username:', 'English') ?></label></td><td><input type="text" id="gsfn_username" name="gsfn_username" size="20" <?php if(get_option('gsfn_username')) echo 'style="background-color: '. get_option('gsfn_username') .';"'; ?> value="<?php echo get_option('gsfn_username') ?>"></td></tr>

	   <tr><td><h3><?php _e('<a href="http://pmog.com">PMOG</a> Activity', 'English'); ?></h3></td>
	   <td>&nbsp;</td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('pmog_back','pmog_back');">Select Background:</a>&nbsp;</td><td><input type="text" id="pmog_back" name="pmog_back" size="7" <?php if(get_option('pmog_back')) echo 'style="background-color: '. get_option('pmog_back') .';"'; ?> value="<?php echo get_option('pmog_back') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('pmog_text','pmog_text');">Select Text:</a>&nbsp;</td><td><input type="text" id="pmog_text" name="pmog_text" size="7" <?php if(get_option('pmog_text')) echo 'style="background-color: '. get_option('pmog_text') .';"'; ?> value="<?php echo get_option('pmog_text') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="pmog_extra_text" name="pmog_extra_text" size="20" <?php if(get_option('pmog_extra_text')) echo 'style="background-color: '. get_option('pmog_extra_text') .';"'; ?> value="<?php echo get_option('pmog_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="pmog_title" name="pmog_title" size="50" <?php if(get_option('pmog_title')) echo 'style="background-color: '. get_option('pmog_title') .';"'; ?> value="<?php echo get_option('pmog_title') ?>"></td></tr>
           <?php endif; ?>
           <tr><td><label for="pmog_username"><?php _e('Username:', 'English') ?></label></td><td><input type="text" id="pmog_username" name="pmog_username" size="20" <?php if(get_option('pmog_username')) echo 'style="background-color: '. get_option('pmog_username') .';"'; ?> value="<?php echo get_option('pmog_username') ?>"></td></tr>

           <td>&nbsp;</td></tr>	
           <tr><td colspan=2><?php _e('Use the below custom feeds for other services you want to track through your google lifestream feed. Doing it this way will allow you to keep a larger history than with a normal custom feed.<br/><br/> These feeds have two extra fields. Keyword is how the system is going to tell what is what. You should use a word that is part of the feed url. For example if your feed is "http://blah.com/rss2.xml" your keyword should probably be blah or blah.com<br/>"Word to Crop" is an optional word that you may wish to remove from the items of this feed. Many feeds for example always write the name of the user in the front, and you might not want that as you are using the prepended text. Any word put here will be removed from the item description.', 'English') ?></td></tr>

	   <tr><td><h3><?php _e('Extra Archived Feed 1', 'English'); ?></h3></td>
	   <td>&nbsp;</td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('greader_custom1_back','greader_custom1_back');">Select Background:</a>&nbsp;</td><td><input type="text" id="greader_custom1_back" name="greader_custom1_back" size="7" <?php if(get_option('greader_custom1_back')) echo 'style="background-color: '. get_option('greader_custom1_back') .';"'; ?> value="<?php echo get_option('greader_custom1_back') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('greader_custom1_text','greader_custom1_text');">Select Text:</a>&nbsp;</td><td><input type="text" id="greader_custom1_text" name="greader_custom1_text" size="7" <?php if(get_option('greader_custom1_text')) echo 'style="background-color: '. get_option('greader_custom1_text') .';"'; ?> value="<?php echo get_option('greader_custom1_text') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="greader_custom1_extra_text" name="greader_custom1_extra_text" size="20" <?php if(get_option('greader_custom1_extra_text')) echo 'style="background-color: '. get_option('greader_custom1_extra_text') .';"'; ?> value="<?php echo get_option('greader_custom1_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="greader_custom1_title" name="greader_custom1_title" size="50" <?php if(get_option('greader_custom1_title')) echo 'style="background-color: '. get_option('greader_custom1_title') .';"'; ?> value="<?php echo get_option('greader_custom1_title') ?>"></td></tr>
           <tr><td><label for="greader_custom1_crop"><?php _e('Word to Crop:', 'English') ?></label></td><td><input type="text" id="greader_custom1_crop" name="greader_custom1_crop" size="20" <?php if(get_option('greader_custom1_crop')) echo 'style="background-color: '. get_option('greader_custom1_crop') .';"'; ?> value="<?php echo get_option('greader_custom1_crop') ?>"></td></tr>
           <?php endif; ?>
           <tr><td><label for="greader_custom1_keyword"><?php _e('Keyword:', 'English') ?></label></td><td><input type="text" id="greader_custom1_keyword" name="greader_custom1_keyword" size="20" <?php if(get_option('greader_custom1_keyword')) echo 'style="background-color: '. get_option('greader_custom1_keyword') .';"'; ?> value="<?php echo get_option('greader_custom1_keyword') ?>"></td></tr>
           <tr><td>Feed Icon:&nbsp;</td><td><input type="text" id="greader_custom1_ico" name="greader_custom1_ico" size="15" <?php if(get_option('greader_custom1_ico')) echo 'style="background-color: '. get_option('greader_custom1_ico') .';"'; ?> value="<?php echo get_option('greader_custom1_ico') ?>"></td></tr>
           <td>&nbsp;</td></tr>	
	   <tr><td><h3><?php _e('Extra Archived Feed 2', 'English'); ?></h3></td>
	   <td>&nbsp;</td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('greader_custom2_back','greader_custom2_back');">Select Background:</a>&nbsp;</td><td><input type="text" id="greader_custom2_back" name="greader_custom2_back" size="7" <?php if(get_option('greader_custom2_back')) echo 'style="background-color: '. get_option('greader_custom2_back') .';"'; ?> value="<?php echo get_option('greader_custom2_back') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('greader_custom2_text','greader_custom2_text');">Select Text:</a>&nbsp;</td><td><input type="text" id="greader_custom2_text" name="greader_custom2_text" size="7" <?php if(get_option('greader_custom2_text')) echo 'style="background-color: '. get_option('greader_custom2_text') .';"'; ?> value="<?php echo get_option('greader_custom2_text') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="greader_custom2_extra_text" name="greader_custom2_extra_text" size="20" <?php if(get_option('greader_custom2_extra_text')) echo 'style="background-color: '. get_option('greader_custom2_extra_text') .';"'; ?> value="<?php echo get_option('greader_custom2_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="greader_custom2_title" name="greader_custom2_title" size="50" <?php if(get_option('greader_custom2_title')) echo 'style="background-color: '. get_option('greader_custom2_title') .';"'; ?> value="<?php echo get_option('greader_custom2_title') ?>"></td></tr>
           <tr><td><label for="greader_custom2_crop"><?php _e('Word to Crop:', 'English') ?></label></td><td><input type="text" id="greader_custom2_crop" name="greader_custom2_crop" size="20" <?php if(get_option('greader_custom2_crop')) echo 'style="background-color: '. get_option('greader_custom2_crop') .';"'; ?> value="<?php echo get_option('greader_custom2_crop') ?>"></td></tr>
           <?php endif; ?>
           <tr><td><label for="greader_custom2_keyword"><?php _e('Keyword:', 'English') ?></label></td><td><input type="text" id="greader_custom2_keyword" name="greader_custom2_keyword" size="20" <?php if(get_option('greader_custom2_keyword')) echo 'style="background-color: '. get_option('greader_custom2_keyword') .';"'; ?> value="<?php echo get_option('greader_custom2_keyword') ?>"></td></tr>
           <tr><td>Feed Icon:&nbsp;</td><td><input type="text" id="greader_custom2_ico" name="greader_custom2_ico" size="25" <?php if(get_option('greader_custom2_ico')) echo 'style="background-color: '. get_option('greader_custom2_ico') .';"'; ?> value="<?php echo get_option('greader_custom2_ico') ?>"></td></tr>
           <td>&nbsp;</td></tr>	
	   <tr><td><h3><?php _e('Extra Archived Feed 3', 'English'); ?></h3></td>
	   <td>&nbsp;</td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('greader_custom3_back','greader_custom3_back');">Select Background:</a>&nbsp;</td><td><input type="text" id="greader_custom3_back" name="greader_custom3_back" size="7" <?php if(get_option('greader_custom3_back')) echo 'style="background-color: '. get_option('greader_custom3_back') .';"'; ?> value="<?php echo get_option('greader_custom3_back') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('greader_custom3_text','greader_custom3_text');">Select Text:</a>&nbsp;</td><td><input type="text" id="greader_custom3_text" name="greader_custom3_text" size="7" <?php if(get_option('greader_custom3_text')) echo 'style="background-color: '. get_option('greader_custom3_text') .';"'; ?> value="<?php echo get_option('greader_custom3_text') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="greader_custom3_extra_text" name="greader_custom3_extra_text" size="20" <?php if(get_option('greader_custom3_extra_text')) echo 'style="background-color: '. get_option('greader_custom3_extra_text') .';"'; ?> value="<?php echo get_option('greader_custom3_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="greader_custom3_title" name="greader_custom3_title" size="50" <?php if(get_option('greader_custom3_title')) echo 'style="background-color: '. get_option('greader_custom3_title') .';"'; ?> value="<?php echo get_option('greader_custom3_title') ?>"></td></tr>
           <tr><td><label for="greader_custom3_crop"><?php _e('Word to Crop:', 'English') ?></label></td><td><input type="text" id="greader_custom3_crop" name="greader_custom3_crop" size="20" <?php if(get_option('greader_custom3_crop')) echo 'style="background-color: '. get_option('greader_custom3_crop') .';"'; ?> value="<?php echo get_option('greader_custom3_crop') ?>"></td></tr>
           <?php endif; ?>
           <tr><td><label for="greader_custom3_keyword"><?php _e('Keyword:', 'English') ?></label></td><td><input type="text" id="greader_custom3_keyword" name="greader_custom3_keyword" size="20" <?php if(get_option('greader_custom3_keyword')) echo 'style="background-color: '. get_option('greader_custom3_keyword') .';"'; ?> value="<?php echo get_option('greader_custom3_keyword') ?>"></td></tr>
           <tr><td>Feed Icon:&nbsp;</td><td><input type="text" id="greader_custom3_ico" name="greader_custom3_ico" size="35" <?php if(get_option('greader_custom3_ico')) echo 'style="background-color: '. get_option('greader_custom3_ico') .';"'; ?> value="<?php echo get_option('greader_custom3_ico') ?>"></td></tr>
           <td>&nbsp;</td></tr>	

	   <tr><td><h2><?php _e('Custom Feeds', 'English'); ?></h3></td>
           <tr><td colspan=2><?php _e('Below you can configure and use 5 extra feeds for anything else you want', 'English') ?></td></tr>
           <td>&nbsp;</td></tr>	
	   <tr><td><h3><?php _e('Extra Feed 1', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>	
	   <tr><td><label for="simple_feed1"><?php _e('Add the full address of any feed here -', 'English') ?></label></td><td><input type="text" name="simple_feed1" id="simple_feed1" size="60" <?php echo 'style="background-color: '. get_option('simple_back1') .'; color: '. get_option('simple_text1') .';"'; ?> value="<?php echo get_option('simple_feed1'); ?>" /></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('simple_back1','simple_back1');">Select Background:</a>&nbsp;</td><td><input type="text" id="simple_back1" name="simple_back1" size="7" <?php if(get_option('simple_back1')) echo 'style="background-color: '. get_option('simple_back1') .';"'; ?> value="<?php echo get_option('simple_back1') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('simple_text1','simple_text1');">Select Text:</a>&nbsp;</td><td><input type="text" id="simple_text1" name="simple_text1" size="7" <?php if(get_option('simple_text1')) echo 'style="background-color: '. get_option('simple_text1') .';"'; ?> value="<?php echo get_option('simple_text1') ?>"></td></tr>
           <tr><td colspan=2><?php _e('The variable below is the filename (including extension) of your extra feed icon. You need to upload this to the <code>plugins/complexlife</code> directory.', 'English') ?></td></tr>
           <tr><td>Feed Icon:&nbsp;</td><td><input type="text" id="simple_ico1" name="simple_ico1" size="15" <?php if(get_option('simple_ico1')) echo 'style="background-color: '. get_option('simple_ico1') .';"'; ?> value="<?php echo get_option('simple_ico1') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="f1_extra_text" name="f1_extra_text" size="20" <?php if(get_option('f1_extra_text')) echo 'style="background-color: '. get_option('f1_extra_text') .';"'; ?> value="<?php echo get_option('f1_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="f1_title" name="f1_title" size="50" <?php if(get_option('f1_title')) echo 'style="background-color: '. get_option('f1_title') .';"'; ?> value="<?php echo get_option('f1_title') ?>"></td></tr>
           <?php endif; ?>

	   <tr><td><h3><?php _e('Extra Feed 2', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>	
	   <tr><td><label for="simple_feed2"><?php _e('Add the full address of any feed here -', 'English') ?></label></td><td><input type="text" name="simple_feed2" id="simple_feed2" size="60" <?php echo 'style="background-color: '. get_option('simple_back2') .'; color: '. get_option('simple_text2') .';"'; ?> value="<?php echo get_option('simple_feed2'); ?>" /></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('simple_back2','simple_back2');">Select Background:</a>&nbsp;</td><td><input type="text" id="simple_back2" name="simple_back2" size="7" <?php if(get_option('simple_back2')) echo 'style="background-color: '. get_option('simple_back2') .';"'; ?> value="<?php echo get_option('simple_back2') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('simple_text2','simple_text2');">Select Text:</a>&nbsp;</td><td><input type="text" id="simple_text2" name="simple_text2" size="7" <?php if(get_option('simple_text2')) echo 'style="background-color: '. get_option('simple_text2') .';"'; ?> value="<?php echo get_option('simple_text2') ?>"></td></tr>
           <tr><td colspan=2><?php _e('The variable below is the filename (including extension) of your extra feed icon. You need to upload this to the <code>plugins/complexlife</code> directory.', 'English') ?></td></tr>
           <tr><td>Feed Icon:&nbsp;</td><td><input type="text" id="simple_ico1" name="simple_ico2" size="15" <?php if(get_option('simple_ico2')) echo 'style="background-color: '. get_option('simple_ico2') .';"'; ?> value="<?php echo get_option('simple_ico2') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="f2_extra_text" name="f2_extra_text" size="20" <?php if(get_option('f2_extra_text')) echo 'style="background-color: '. get_option('f2_extra_text') .';"'; ?> value="<?php echo get_option('f2_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="f2_title" name="f2_title" size="50" <?php if(get_option('f2_title')) echo 'style="background-color: '. get_option('f2_title') .';"'; ?> value="<?php echo get_option('f2_title') ?>"></td></tr>
           <?php endif; ?>

	   <tr><td><h3><?php _e('Extra Feed 3', 'English'); ?></h3></td>
	   <td>&nbsp;</td></tr>	
           <tr><td><label for="simple_feed3"><?php _e('Add the full address of any feed here -', 'English') ?></label></td><td><input type="text" name="simple_feed3" id="simple_feed3" size="60" <?php echo 'style="background-color: '. get_option('simple_back3') .'; color: '. get_option('simple_text3') .';"'; ?> value="<?php echo get_option('simple_feed3'); ?>" /></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('simple_back3','simple_back3');">Select Background:</a>&nbsp;</td><td><input type="text" id="simple_back3" name="simple_back3" size="7" <?php if(get_option('simple_back3')) echo 'style="background-color: '. get_option('simple_back3') .';"'; ?> value="<?php echo get_option('simple_back3') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('simple_text3','simple_text3');">Select Text:</a>&nbsp;</td><td><input type="text" id="simple_text3" name="simple_text3" size="7" <?php if(get_option('simple_text3')) echo 'style="background-color: '. get_option('simple_text3') .';"'; ?> value="<?php echo get_option('simple_text3') ?>"></td></tr>
           <tr><td colspan=2><?php _e('The variable below is the filename (including extension) of your extra feed icon. You need to upload this to the <code>plugins/complexlife</code> directory.', 'English') ?></td></tr>
           <tr><td>Feed Icon:&nbsp;</td><td><input type="text" id="simple_ico1" name="simple_ico3" size="15" <?php if(get_option('simple_ico3')) echo 'style="background-color: '. get_option('simple_ico3') .';"'; ?> value="<?php echo get_option('simple_ico3') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="f3_extra_text" name="f3_extra_text" size="20" <?php if(get_option('f3_extra_text')) echo 'style="background-color: '. get_option('f3_extra_text') .';"'; ?> value="<?php echo get_option('f3_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="f3_title" name="f3_title" size="50" <?php if(get_option('f3_title')) echo 'style="background-color: '. get_option('f3_title') .';"'; ?> value="<?php echo get_option('f3_title') ?>"></td></tr>
           <?php endif; ?>

	   <tr><td><h3><?php _e('Extra Feed 4', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>	
	   <tr><td><label for="simple_feed4"><?php _e('Add the full address of any feed here -', 'English') ?></label></td><td><input type="text" name="simple_feed4" id="simple_feed4" size="60" <?php echo 'style="background-color: '. get_option('simple_back4') .'; color: '. get_option('simple_text4') .';"'; ?> value="<?php echo get_option('simple_feed4'); ?>" /></td></tr>
           <tr><td><a href="javascript:onclick=showColorGrid2('simple_back4','simple_back4');">Select Background:</a>&nbsp;</td><td><input type="text" id="simple_back4" name="simple_back4" size="7" <?php if(get_option('simple_back4')) echo 'style="background-color: '. get_option('simple_back4') .';"'; ?> value="<?php echo get_option('simple_back4') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('simple_text4','simple_text4');">Select Text:</a>&nbsp;</td><td><input type="text" id="simple_text4" name="simple_text4" size="7" <?php if(get_option('simple_text4')) echo 'style="background-color: '. get_option('simple_text4') .';"'; ?> value="<?php echo get_option('simple_text4') ?>"></td></tr>
           <tr><td colspan=2><?php _e('The variable below is the filename (including extension) of your extra feed icon. You need to upload this to the <code>plugins/complexlife</code> directory.', 'English') ?></td></tr>
           <tr><td>Feed Icon:&nbsp;</td><td><input type="text" id="simple_ico4" name="simple_ico4" size="15" <?php if(get_option('simple_ico4')) echo 'style="background-color: '. get_option('simple_ico4') .';"'; ?> value="<?php echo get_option('simple_ico4') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="f4_extra_text" name="f4_extra_text" size="20" <?php if(get_option('f4_extra_text')) echo 'style="background-color: '. get_option('f4_extra_text') .';"'; ?> value="<?php echo get_option('f4_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="f4_title" name="f4_title" size="50" <?php if(get_option('f4_title')) echo 'style="background-color: '. get_option('f4_title') .';"'; ?> value="<?php echo get_option('f4_title') ?>"></td></tr>
           <?php endif; ?>

	   <tr><td><h3><?php _e('Extra Feed 5', 'English'); ?></h3></td>
           <td>&nbsp;</td></tr>	
	   <tr><td><label for="simple_feed5"><?php _e('Add the full address of any feed here -', 'English') ?></label></td><td><input type="text" name="simple_feed5" id="simple_feed5" size="60" <?php echo 'style="background-color: '. get_option('simple_back5') .'; color: '. get_option('simple_text5') .';"'; ?> value="<?php echo get_option('simple_feed5'); ?>" /></td></tr>
           <tr><td><a href="javascript:onclick=showColorGrid2('simple_back5','simple_back5');">Select Background:</a>&nbsp;</td><td><input type="text" id="simple_back5" name="simple_back5" size="7" <?php if(get_option('simple_back5')) echo 'style="background-color: '. get_option('simple_back5') .';"'; ?> value="<?php echo get_option('simple_back5') ?>"></td></tr>
	   <tr><td><a href="javascript:onclick=showColorGrid2('simple_text5','simple_text5');">Select Text:</a>&nbsp;</td><td><input type="text" id="simple_text5" name="simple_text5" size="7" <?php if(get_option('simple_text5')) echo 'style="background-color: '. get_option('simple_text5') .';"'; ?> value="<?php echo get_option('simple_text5') ?>"></td></tr>
           <tr><td colspan=2><?php _e('The variable below is the filename (including extension) of your extra feed icon. You need to upload this to the <code>plugins/complexlife</code> directory.', 'English') ?></td></tr>
           <tr><td>Feed Icon:&nbsp;</td><td><input type="text" id="simple_ico5" name="simple_ico5" size="15" <?php if(get_option('simple_ico5')) echo 'style="background-color: '. get_option('simple_ico5') .';"'; ?> value="<?php echo get_option('simple_ico5') ?>"></td></tr>
           <?php if(get_option('advanced_options') == 1): ?>
           <tr><td>Extra prepended text:&nbsp;</td><td><input type="text" id="f5_extra_text" name="f5_extra_text" size="20" <?php if(get_option('f5_extra_text')) echo 'style="background-color: '. get_option('f5_extra_text') .';"'; ?> value="<?php echo get_option('f5_extra_text') ?>"></td></tr>
           <tr><td>Title:&nbsp;</td><td><input type="text" id="f5_title" name="f5_title" size="50" <?php if(get_option('f5_title')) echo 'style="background-color: '. get_option('f5_title') .';"'; ?> value="<?php echo get_option('f5_title') ?>"></td></tr>
           <?php endif; ?>

</table>

     <div class="submit"><input type="submit" name="info_update" value="<?php _e('Update Options', 'English'); ?> &raquo;" /></div>
</form>
</div>

<?php   
}

function complexlife(){
$i=0 // Added this to start a counter of items
?>
<a name="lifestream"></a><div id="complexlife">
<!-- Lifestream-->
<ul>

<style type="text/css">
/* Lifestream Style Info Below */
#complexlife ul a:link, #complexlife ul a:visited {
	text-decoration: none;
	color: #DFDFDF;
}

#complexlife ul, #complexlife li, #complexlife ol {
	margin: 0;
	padding: 0;
        width: 95%;
}

#complexlife ul {	
	list-style-type: none;
	list-style-position: outside;
}

/* Date Format */
ul .datesf {
  display: block;
  width: 100%;
  color: #444;
  font-size: 1.5em;
  text-align: left;
  padding: 0 0 1px 0 ! important;
  margin: 10px 0 0 0 !important;
  border-top: 1px solid #fff;	
  border-bottom: 1px solid #AAA3A1;
  font-weight: bold;
}

/* Time Format */
ul .timesf {
padding: 0 0 0 5px !important;
color: #555;
font-weight: bold;
}

/* Extra Text format */
ul .extratext {
padding: 0 2px 0 2px !important;
color: <?php echo get_option('extra_prep_text') ?>;
font-variant: small-caps;
}

#complexlife li a:link, #complexlife li a:visited {
  display: block;
  margin: 0;
  width: 100%;
  padding: 1px 35px;
}

/* Classes for all links - define your extra classes below */
a.defaulted {
  border-top: 1px solid #000000 !important;	
  border-bottom: 1px solid #000000 !important;
  background: <?php echo get_option('default_back') ?> !important;
  color: <?php echo get_option('default_text') ?> !important;
  width: 95%;
}

a.lastfm {
  background: <?php echo get_option('lastback') ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/lastfm.png) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('lastback') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('lastback') ?> !important;
  color: <?php echo get_option('lasttext') ?> !important;
}

a.delicious {
  border-top: 1px solid <?php echo get_option('delback'); ?> !important;	
  border-bottom: 1px solid <?php echo get_option('delback'); ?> !important;
  background: <?php echo get_option('delback'); ?> url(http://del.icio.us/favicon.ico) no-repeat 10px 50% !important;
  color: <?php echo get_option('deltext'); ?> !important;
}

a.flickr {
  background: <?php echo get_option('flickrback') ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/flickr.gif) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('flickrback') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('flickrback') ?> !important;
  color: <?php echo get_option('flickrtext') ?> !important;
}

a.facebook {
  background: <?php echo get_option('faceback') ?> url(http://www.facebook.com/favicon.ico) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('faceback') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('faceback') ?> !important;
  color: <?php echo get_option('facetext') ?> !important;
}

a.blog {
  background: <?php echo get_option('blogback') ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/<?php echo get_option('blogico'); ?>) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('blogback') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('blogback') ?> !important;
  color: <?php echo get_option('blogtext') ?> !important;
}

a.twitter {
  background: <?php echo get_option('twitback') ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/icon_twitter.png) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('twitback') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('twitback') ?> !important;
  color: <?php echo get_option('twittext') ?> !important;
}

a.su {
  background: <?php echo get_option('suback') ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/su.png) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('suback') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('suback') ?> !important;
  color: <?php echo get_option('sutext') ?> !important;
}

a.reddit {
  background: <?php echo get_option('redditback') ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/reddit.ico) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('redditback') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('redditback') ?> !important;
  color: <?php echo get_option('reddittext') ?> !important;
}

a.simple_feed1 {
  background: <?php echo get_option('simple_back1') ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/<?php echo get_option('simple_ico1'); ?>) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('simple_back1') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('simple_back1') ?> !important;
  color: <?php echo get_option('simple_text1') ?> !important;

}

a.simple_feed2 {
  background: <?php echo get_option('simple_back2') ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/<?php echo get_option('simple_ico2'); ?>) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('simple_back2') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('simple_back2') ?> !important;
  color: <?php echo get_option('simple_text2') ?> !important;
}

a.simple_feed3 {
  background: <?php echo get_option('simple_back3') ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/<?php echo get_option('simple_ico3'); ?>) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('simple_back3') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('simple_back3') ?> !important;
  color: <?php echo get_option('simple_text3') ?> !important;
}

a.simple_feed4 {
  background: <?php echo get_option('simple_back4') ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/<?php echo get_option('simple_ico4'); ?>) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('simple_back4') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('simple_back4') ?> !important;
  color: <?php echo get_option('simple_text4') ?> !important;
}

a.simple_feed5 {
  background: <?php echo get_option('simple_back5') ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/<?php echo get_option('simple_ico5'); ?>) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('simple_back5') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('simple_back5') ?> !important;
  color: <?php echo get_option('simple_text5') ?> !important;
}

a.digg {
  background: <?php echo get_option('diggback') ?> url(http://digg.com/favicon.ico) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('diggback') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('diggback') ?> !important;
  color: <?php echo get_option('diggtext') ?> !important;
}

a.shared {
  border-top: 1px solid <?php echo get_option('greader_shared_back'); ?> !important;	
  border-bottom: 1px solid <?php echo get_option('greader_shared_back'); ?> !important;
  background: <?php echo get_option('greader_shared_back'); ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/greader.ico) no-repeat 10px 50% !important;
  color: <?php echo get_option('greader_shared_text'); ?> !important;
}

a.comments {
  border-top: 1px solid <?php echo get_option('comments_back'); ?> !important;	
  border-bottom: 1px solid <?php echo get_option('comments_back'); ?> !important;
  background: <?php echo get_option('comments_back'); ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/comments2.png) no-repeat 10px 50% !important;
  color: <?php echo get_option('comments_text'); ?> !important;
}

a.fsd {
  background: <?php echo get_option('simple_back1') ?> url(http://www.fsdaily.com/files/www.fsdaily.com/fsdaily_favicon.ico) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('simple_back1') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('simple_back1') ?> !important;
  color: #94e88a !important;
}

a.pmog {
  background: <?php echo get_option('pmog_back'); ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/pmog.png) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('pmog_back') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('pmog_back') ?> !important;
  color: <?php echo get_option('pmog_text') ?> !important;
}

a.getsatisfaction {
  background: <?php echo get_option('gsfn_back'); ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/getsatiscaction.gif) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('gsfn_back') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('gsfn_back') ?> !important;
  color: <?php echo get_option('gsfn_text') ?> !important;
}

a.greader_custom_feed1 {
  background: <?php echo get_option('greader_custom1_back') ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/<?php echo get_option('greader_custom1_ico'); ?>) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('greader_custom1_back') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('greader_custom1_back') ?> !important;
  color: <?php echo get_option('greader_custom1_text') ?> !important;
}
a.greader_custom_feed2 {
  background: <?php echo get_option('greader_custom2_back') ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/<?php echo get_option('greader_custom2_ico'); ?>) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('greader_custom2_back') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('greader_custom2_back') ?> !important;
  color: <?php echo get_option('greader_custom2_text') ?> !important;
}
a.greader_custom_feed3 {
  background: <?php echo get_option('greader_custom3_back') ?> url(<?php echo get_bloginfo('home'); ?>/wp-content/plugins/complexlife/<?php echo get_option('greader_custom3_ico'); ?>) no-repeat 10px 50% !important;
  border-top: 1px solid <?php echo get_option('greader_custom3_back') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('greader_custom3_back') ?> !important;
  color: <?php echo get_option('greader_custom3_text') ?> !important;
}

img.smallchart {
position:absolute;
right:50px;
top:350px
}

/* Hover for all links */
#complexlife li a:hover {
  background: <?php echo get_option('simplehoverback') ?> !important;
  border-top: 1px solid <?php echo get_option('simple_hoverborder') ?> !important;	
  border-bottom: 1px solid <?php echo get_option('simple_hoverborder') ?> !important;
  color: <?php echo get_option('simplehovertext') ?> !important;
}
</style>


<?php

$df = '';
$ff = '';
$bf = '';
$lf = ''; 
$fbf = '';
$f1 = '';
$f2 = '';
$f3 = '';
$f4 = '';
$f5 = '';
// $getboo_comment_feed = 'http://www.getboo.com/rss/userb.php?uname=db0&tag=mycomments';

/* Init Counters & Titles for Google Charts */
$f1_counter = 0;
$f1_title = '';
$f2_counter = 0;
$f2_title = '';
$f3_counter = 0;
$f3_title = '';
$f4_counter = 0;
$f4_title = '';
$f5_counter = 0;
$f5_title = '';
$greader_custom1_counter = 0;
$greader_custom1_title = '';
$df_counter = 0;
$del_title = '';
$ff_counter = 0;
$ff_title = '';
$bf_counter = 0;
$bf_title = '';
$lf_counter = 0; 
$lf_title = '';
$fbf_counter = 0;
$fbf_title = '';
$tf_counter = 0;
$twitter_title = '';
$su_counter = 0;
$su_title = '';
$reddit_counter = 0;
$reddit_title = '';
$digg_counter = 0;
$digg_title = 'Digg';
$greader_shared_counter = 0;
$greader_shared_title = '';
$comments_counter = 0;
if(get_option('comments_title')) $comments_title = get_option('comments_title'); else $comments_title = 'Comments';
$fsd_counter = 0;
$fsd_title = 'Free Software Daily';
$pmog_counter = 0;
$pmog_title = '';
$gsfn_counter = 0;
$gsfn_title = '';

if(get_option('s_delicious')) $df = 'http://del.icio.us/rss/' . get_option('s_delicious');
if (get_option('s_flickr')) $ff = 'http://api.flickr.com/services/feeds/photos_public.gne?id=' . get_option('s_flickr') .'&lang=en-us&format=rss_200';
if(get_option('s_blog')) $bf = get_option('s_blog');
if (get_option('s_lastfm')) $lf = 'http://pipes.yahoo.com/pipes/pipe.run?_id=16cd2a80dd2fce58df9ea58731c821f3&_render=rss&username='. get_option('s_lastfm');
if (get_option('s_lastfm') && get_option('lastfm_recent_tracks') == 'true') $lastfm_recent = 'http://ws.audioscrobbler.com/1.0/user/'. get_option('s_lastfm') .'/recenttracks.rss';
if (get_option('s_digg')) $digg_feed = 'http://digg.com/users/'. get_option('s_digg') .'/history.rss';
if(get_option('s_facebook')) $fbf = get_option('s_facebook');
if(get_option('facebook_posted')) $fb_posted_items = get_option('facebook_posted');
if(get_option('simple_feed1')) $f1 = get_option('simple_feed1');
if(get_option('simple_feed2')) $f2 = get_option('simple_feed2');
if(get_option('simple_feed3')) $f3 = get_option('simple_feed3');
if(get_option('simple_feed4')) $f4 = get_option('simple_feed4');
if(get_option('simple_feed5')) $f5 = get_option('simple_feed5');
if(get_option('greader_shared')) $greader_shared_feed = get_option('greader_shared') .'?n='. get_option('greader_shared_nr');
if(get_option('greader_comments')) $greader_comment_feed = get_option('greader_comments') .'?n='. get_option('greader_comments_nr');
if(get_option('greader_lifestream')) $greader_lifestream_feed = get_option('greader_lifestream') .'?n='. get_option('greader_lifestream_nr') ;

$feeds = array($df, $ff, $bf, $lf, $lastfm_recent, $fbf, $f1, $f2, $f3, $f4, $f5, $digg_feed, $greader_lifestream_feed, $fb_posted_items, $greader_comment_feed, $greader_shared_feed);
$feeds = array_diff($feeds, array(""));

$feed = new SimplePie($feeds, CACHEDIR, 60*get_option('simple_cache'));

// Set up date variable.
$stored_date = '';
// Prepare date limit 
$date_limit = get_option('simple_datelimit')*86400;
 
// Go through all of the items in the feed
foreach ($feed->get_items(0,get_option('simple_flimit')) as $item)
{
	// What is the date of the current feed item?
	$item_date = $item->get_date(get_option('simple_date'));
        $class = 'defaulted';
 
        // Is the item's date older than what we want? Then skip.
        if ($item->get_date(U) < date(U)-$date_limit && $date_limit > 0) {continue;}

	// Is the item's date the same as what is already stored?
	// - Yes? Don't display it again because we've already displayed it for this date.
	// - No? So we have something different.  We should display that.
	if ($stored_date != $item_date)
	{
		// Since they're different, let's replace the old stored date with the new one
		$stored_date = $item_date;
 		// Display it on the page
		echo '<li class="datesf">' . $stored_date . '</li>' . "\r\n";
	}

        //Decide where the link came from and set class accordingly.
        //Just add an extra if section, with a segment of the permalink to set a new class.
        //EG, flickr feed links to flickr.com delicious links everywhere, so we treat any unknown as delicious link, but anything containing flickr.com as flickr.

$url = $item->get_permalink(); // We need this to get the url where the item is *pointing at*
$feedurl = $item->get_feed()->subscribe_url(); // The url of the feed itself. We use this to compare with the one the user gave us.
$extra_text = ''; // We nullify the text at the beggining of our item.
$current_title = $item->get_feed()->get_title(); // We need this to set a default title for items the user hasn't written one
$item_title = $item->get_title(); // I put this variable here because I sometimes need to change the titles. i.e. for comments.

// First check so that our feed includes only the past week
 
// We check now each item for conditions. I should possible change this into a switch format eventually but if statements give me more freedom of checks.
// Extra comments on the first sample ;)
if (preg_match("*flickr*i", $url)) {  
$class = 'flickr'; // We set the class from one we've setup above
$ff_counter = $ff_counter+1; // We increase our counter so that we gets stats with google charts
$ff_title = $item->get_feed()->get_title(); // Once again, this is needed for google charts beatification.
// Attemptint to copy simplelife's flickr thumbnail code
$description = $item->get_description();
$smpflickimg = preg_match('/img src="(.*)\.jpg"/', $description, $matches);
$smpflickimg = $matches[1].".jpg";
if($smpflickimg == '.jpg'){
  $smpflickimg = '';
  $class = 'defaulted';
  }
// Hardcode size square "s", thumb "t", small "m", medium "", large "b" or original "o"?
$size = "t";
// Alter the path to point to the required size of the image
if ($size != "") {
  $smpflickimg = preg_replace('/_m\.jpg/', '_'.$size.'.jpg', $smpflickimg);
  } else {
  $smpflickimg = preg_replace('/_m\.jpg/', '.jpg', $smpflickimg);
  }
$smpflickimg = preg_replace('/width="[0-9]+"/', '', $smpflickimg);
$smpflickimg = preg_replace('/height="[0-9]+"/', '', $smpflickimg);
unset($matches);
}


if ($feedurl == $df) { // We check the current item's feed's subscription url with one of our options.
$class = 'delicious';
$extra_text = get_option('del_extra_text');
$df_counter = $df_counter+1;
if(get_option('del_title')) $del_title = $current_title = get_option('del_title'); else $del_title = $item->get_feed()->get_title();
}
if ($feedurl == $bf) {
$class = 'blog';
$bf_counter = $bf_counter+1;
$extra_text = get_option('blog_extra_text');
if(get_option('blog_title')) $bf_title = $current_title = get_option('blog_title'); else $bf_title = $item->get_feed()->get_title();
}
if (stripos($feedurl, '16cd2a80dd2fce58df9ea58731c821f3') !== false || $feedurl == $lastfm_recent) {
$class = 'lastfm';
$lf_counter = $lf_counter+1;
$lf_title = $item->get_feed()->get_title();
}
// if ($feedurl == $fbf) {$class = 'facebook';}
if (stripos($url, 'facebook') !== false) { // had to use stripos because a perfect match was not possible with facebook's special chars in the url.
$class = 'facebook';
$fbf_counter = $fbf_counter+1;
$fbf_title = $item->get_feed()->get_title();
}
if ($feedurl == $f1) {
$class = 'simple_feed1'; 
$extra_text = get_option('f1_extra_text');
$f1_counter = $f1_counter+1;
if(get_option('f1_title')) $f1_title = $current_title = get_option('f1_title'); else $f1_title = $item->get_feed()->get_title();
}
if ($feedurl == $f2) {
$class = 'simple_feed2'; 
$extra_text = get_option('f2_extra_text');
$f2_counter = $f2_counter+1;
if(get_option('f2_title')) $f2_title = $current_title = get_option('f2_title'); else $f2_title = $item->get_feed()->get_title();
}
if ($feedurl == $f3) {
$class = 'simple_feed3'; 
$extra_text = get_option('f3_extra_text');
$f3_counter = $f3_counter+1;
if(get_option('f3_title')) $f3_title = $current_title = get_option('f3_title'); else $f3_title = $item->get_feed()->get_title();
}
if ($feedurl == $f4) {
$class = 'simple_feed4'; 
$extra_text = get_option('f4_extra_text');
$f4_counter = $f4_counter+1;
if(get_option('f4_title')) $f4_title = $current_title = get_option('f4_title'); else $f4_title = $item->get_feed()->get_title();
}
if ($feedurl == $f5) {
$class = 'simple_feed5'; 
$extra_text = get_option('f5_extra_text');
$f5_counter = $f5_counter+1;
if(get_option('f5_title')) $f5_title = $current_title = get_option('f5_title'); else $f5_title = $item->get_feed()->get_title();
}
if ($feedurl == $digg_feed) {
$class = 'digg';
$extra_text = get_option('digg_extra_text');
$digg_counter = $digg_counter+1;
if(get_option('digg_title')) $digg_title = $current_title = get_option('digg_title'); else $digg_title = $item->get_feed()->get_title();
}
if ($feedurl == $greader_shared_feed) {
$class = 'shared'; 
$extra_text = get_option('greader_shared_extra_text');
$greader_shared_counter = $greader_shared_counter+1;
$greader_shared_title = $item->get_feed()->get_title();
}
// The following code is only if you are using a google reader comments feed
if ($feedurl == $greader_comment_feed) { 
  if ($author = $item->get_author()) { // Checking to see if the author field exists
    $name = strtolower($author->get_name()); // Put the human readable name in a variable
    if ($name == get_option('greader_comments_author')) { // Check if the name of the author matches the one we are looking for.
      $class = 'comments';
      $extra_text = get_option('comments_extra_text');
      $item_title_crops = array('Comments on:', 'Comments on', 'Comments for', 'Σχόλια στο:', 'Latest posts from topic'); // The strings we are removing from comment feed titles (so as to look nicer with the extra text)
      $item_title = str_replace($item_title_crops,'',$item->get_source()->get_title()); // Removing the strings
      $comments_counter = $comments_counter+1;
      $current_title = $comments_title;
    }
    else {continue;}
  }  
}
// The following code is only if you are using a google reader lifestream tag feed
if ($feedurl == $greader_lifestream_feed) { 
// First we check if the current item has a source url in the atom rss properties and as an added bonus also set the $source variable. 
// If this is does not give an error, we get the permalink of the original feed google reader is reading from.
  if ($source = $item->get_source()) {$source_url = $source->get_permalink();}
// We use the stripos function to search the original feed url for keywords of where it's coming from.
  if (stripos($source_url, 'twitter') !== false) { // For example, all twitter updated come from twitter.com so that will do for now.
    $class = 'twitter';
    $extra_text = get_option('twitter_extra_text'); 
    $tf_counter = $tf_counter+1;
    if(get_option('twitter_title')) $twitter_title = $current_title = get_option('twitter_title'); else $twitter_title = $item->get_feed()->get_title(); //We're checking to see if the user has provided a title. If they haven't we grab whatever title the feed has by default.
    $item_title = str_replace(get_option('twitter_username').': ','',$item->get_title()); // Cropping the username
  }
  if (stripos($source_url, 'stumbleupon') !== false) { 
    $class = 'su';
    $extra_text = get_option('su_extra_text');
    $su_counter = $su_counter+1;
    if(get_option('su_title')) $su_title = $current_title = get_option('su_title'); else $su_title = $current_title = $source->get_title();
  }
  if (stripos($source_url, 'reddit') !== false) { 
    $class = 'reddit';
    $extra_text = get_option('reddit_extra_text');
    $reddit_counter = $reddit_counter+1;
    if(get_option('reddit_title')) $reddit_title = $current_title = get_option('reddit_title'); else $reddit_title = $current_title = $source->get_title();
    $item_title = str_replace(get_option('reddit_username'),'commented',$item->get_title()); // Cropping the username
  }
  if (stripos($url, 'IDComment') !== false) { // Intense Debate always has "IDComment" in the end so it's easy to grab.
    $class = 'comments';
      $comments_counter = $comments_counter+1;
      $current_title = $comments_title;
      $extra_text = get_option('comments_extra_text');
  }

  if (stripos($source_url, 'cocomment') !== false) { 
    $class = 'comments';
      $comments_counter = $comments_counter+1;
      $current_title = $comments_title;
      $extra_text = get_option('comments_extra_text');
  }

  if (stripos($url, get_option('greader_custom1_keyword')) !== false) { // The custom greader feeds start here
      $class = 'greader_custom_feed1';
      $greader_custom1_counter = $greader_custom1_counter+1;
      $extra_text = get_option('greader_custom1_extra_text'); //Set the extra prepended text
      if(get_option('greader_custom1_title')) $greader_custom1_title = $current_title = get_option('greader_custom1_title'); else $greader_custom1_title = $current_title = $source->get_title(); //If the title is not set, grab the one from the feed.
      $item_title = str_replace(get_option('greader_custom1_crop'),'',$item->get_title()); // Cropping the username
  }
  if (stripos($url, get_option('greader_custom2_keyword')) !== false) { 
      $class = 'greader_custom_feed2';
      $greader_custom2_counter = $greader_custom2_counter+1;
      $extra_text = get_option('greader_custom2_extra_text'); 
      if(get_option('greader_custom2_title')) $greader_custom2_title = $current_title = get_option('greader_custom2_title'); else $greader_custom2_title = $current_title = $source->get_title(); 
      $item_title = str_replace(get_option('greader_custom2_crop'),'',$item->get_title()); 
  }
  if (stripos($url, get_option('greader_custom3_keyword')) !== false) { 
      $class = 'greader_custom_feed3';
      $greader_custom3_counter = $greader_custom3_counter+1;
      $extra_text = get_option('greader_custom3_extra_text'); 
      if(get_option('greader_custom3_title')) $greader_custom3_title = $current_title = get_option('greader_custom3_title'); else $greader_custom3_title = $current_title = $source->get_title(); 
      $item_title = str_replace(get_option('greader_custom3_crop'),'',$item->get_title()); 
  }

  if (stripos($source_url, 'pmog') !== false) { 
    $class = 'pmog';
    $pmog_counter = $pmog_counter+1;
    $item_title = str_replace('a href=','span',$item->get_title()); // Replacing the link tags because they break the format
    $item_title = str_replace('</a>','</span>',$item_title); // Replacing the link tags
    $item_title_crops = array(get_option('pmog_username').' just', get_option('pmog_username').'  just');
    $item_title = str_replace($item_title_crops,'',$item_title); // Cropping needless strings
    if(get_option('pmog_title')) $pmog_title = $current_title = get_option('pmog_title'); else $pmog_title = $current_title = $source->get_title();
    $extra_text = get_option('pmog_extra_text');
  }
  if (stripos($source_url, 'getsatisfaction.com') !== false) { 
    if (stripos($item_title, get_option('gsfn_username')) !== 0) {continue;}
    $class = 'getsatisfaction';
    $gsfn_counter = $gsfn_counter+1;
    if(get_option('gsfn_title')) $gsfn_title = $current_title = get_option('gsfn_title'); else $gsfn_title = $current_title = $source->get_title();
    $extra_text = get_option('gsfn_extra_text');
    $item_title = str_replace(get_option('gsfn_username'),'',$item->get_title()); // Cropping the username
  }

// Since I am using getboo to get tag specific feeds, I can search the feed permalink for the tag. The same works for Del.icio.us
  if (stripos($source_url, 'mycomments') !== false) { // In this instance I am looking for the mycomments tag in the url which tells me this item is a comment I left.
// *************This is only used for comments I cannot get through a feed - DEPRECATED************
    continue;
    $class = 'comments';
    $getboo_comment_feed_counter = $getboo_comment_feed_counter+1;
    $current_title = 'Comments Elsewhere';
  }
  if (stripos($source_url, 'fsd') !== false) { // Now I am looking for the FSD tag which means that it's an article I've dugg, buried or commented on FSD.
    $class = 'fsd';
    $fsd_counter = $fsd_counter+1;
  }
// The following code only works if you are using getboo as I do not know if del.icio.us uses the same format.
  if (stripos($source_url, 'getboo') !== false) { // First we check if we are looking at a getboo item.
    foreach ($item->get_categories() as $category) { // Then we iterate through each category of the item
      switch ($category->get_label()) { // Finally we check each category for matches and set the appropriate extra text and title.
					// This allows a lot of freedom to add more description without increasing the code exponentially.
	case 'fsd_vote_up':
	  $extra_text = 'Voted up: ';
          $current_title = 'Voted up a Free Software Daily Article';
	  break;
	case 'fsd_buried':
	  $extra_text = 'Buried: ';
          $current_title = 'Voted up a Free Software Daily Article';
	  break;
	case 'fsd_comment':
	  $extra_text = 'Commented on: ';
          $current_title = 'Commented on a Free Software Daily Article';
	  break;
	case 'blogcomment':
	  $extra_text = 'Commented on: ';
          $current_title = 'Comment left on a Blog';
	  break;
	case 'forumcomment':
	  $extra_text = 'Commented on: ';
          $current_title = 'Comment left on a Forum';
	  break;
      }
    }
  }
}

// Display the feed item. I've managed to allow extra text and a title through variables.	
echo '<li class="item ' . ++$i . '"><a class="' . $class . '" href="' . $item->get_permalink() . '" title="' . $current_title . '"><span class="timesf ' . $i . '">' . $item->get_date(get_option('simple_time')) . '</span><span class="extratext ' . $i . '"> ' . $extra_text . '</span>'; 

if($class == 'flickr' && $smpflickimg !== '' && get_option('s_flickr_thumbs') == 'true'){
  echo ' <img src="' . $smpflickimg . '" style="vertical-align:middle" />';
}

if($class !== 'flickr' || get_option('s_flickr_title') == 'true'){
  echo ' ' . $item_title; 
}

echo '</a></li>' . "\r\n";

}


/* Begin Google Charts code */
if (get_option('big_chart_enabled') == 1) {
echo '<a name="chart"></a>';
echo '
<img src="http://chart.apis.google.com/chart?
chs=' . get_option('big_chart_size') .'
&amp;chd=t:
';
if ($f1_counter > 0) {echo $f1_counter . ',';} // Check if we actually have any such items before we add them to the charts.
if ($f2_counter > 0) {echo $f2_counter . ',';}
if ($f3_counter > 0) {echo $f3_counter . ',';}
if ($f4_counter > 0) {echo $f4_counter . ',';}
if ($f5_counter > 0) {echo $f5_counter . ',';}
if ($greader_custom1_counter > 0) {echo $greader_custom1_counter . ',';}
if ($greader_custom2_counter > 0) {echo $greader_custom2_counter . ',';}
if ($greader_custom3_counter > 0) {echo $greader_custom3_counter . ',';}
if ($df_counter > 0) {echo $df_counter . ',';}
if ($ff_counter > 0) {echo $ff_counter . ',';}
if ($lf_counter > 0) {echo $lf_counter . ',';}
if ($fbf_counter > 0) {echo $fbf_counter . ',';}
if ($tf_counter > 0) {echo $tf_counter . ',';}
if ($su_counter > 0) {echo $su_counter . ',';}
if ($reddit_counter > 0) {echo $reddit_counter . ',';}
if ($digg_counter > 0) {echo $digg_counter . ',';}
if ($pmog_counter > 0) {echo $pmog_counter . ',';}
if ($gsfn_counter > 0) {echo $gsfn_counter . ',';}
if ($greader_shared_counter > 0) {echo $greader_shared_counter . ',';}
if ($comments_counter > 0) {echo $comments_counter . ',';}
if ($bf_counter > 0) {echo $bf_counter;}
echo '
&amp;cht=p3
&amp;chco=
' . str_replace('#','',get_option('big_chart_colour1')) .',
' . str_replace('#','',get_option('big_chart_colour2')) .',
' . str_replace('#','',get_option('big_chart_colour3')) .'
&amp;chf=bg,s,
' . str_replace('#','',get_option('big_chart_background')) .'
&amp;chl=
';
if ($f1_counter > 0) {echo $f1_title . '+(' . $f1_counter . ')|';} //Check if we actually have any such items before we add a title.
if ($f2_counter > 0) {echo $f2_title . '+(' . $f2_counter . ')|';}
if ($f3_counter > 0) {echo $f3_title . '+(' . $f3_counter . ')|';}
if ($f4_counter > 0) {echo $f4_title . '+(' . $f4_counter . ')|';}
if ($f5_counter > 0) {echo $f5_title . '+(' . $f5_counter . ')|';}
if ($greader_custom1_counter > 0) {echo $greader_custom1_title . '+(' . $greader_custom1_counter . ')|';}
if ($greader_custom2_counter > 0) {echo $greader_custom2_title . '+(' . $greader_custom2_counter . ')|';}
if ($greader_custom3_counter > 0) {echo $greader_custom3_title . '+(' . $greader_custom3_counter . ')|';}
if ($df_counter > 0) {echo $del_title . '+(' . $df_counter . ')|';}
if ($ff_counter > 0) {echo $ff_title . '+(' . $ff_counter . ')|';}
if ($lf_counter > 0) {echo $lf_title . '+(' . $lf_counter . ')|';}
if ($fbf_counter > 0) {echo $fbf_title . '+(' . $fbf_counter . ')|';}
if ($tf_counter > 0) {echo $twitter_title . '+(' . $tf_counter . ')|';}
if ($su_counter > 0) {echo $su_title . '+(' . $su_counter . ')|';}
if ($reddit_counter > 0) {echo $reddit_title . '+(' . $reddit_counter . ')|';}
if ($digg_counter > 0) {echo $digg_title . '+(' . $digg_counter . ')|';}
if ($pmog_counter > 0) {echo $pmog_title . '+(' . $pmog_counter . ')|';}
if ($gsfn_counter > 0) {echo $gsfn_title . '+(' . $gsfn_counter . ')|';}
if ($greader_shared_counter > 0) {echo $greader_shared_title . '+(' . $greader_shared_counter . ')|';}
if ($comments_counter > 0) {echo $comments_title . '+(' . $comments_counter . ')|';}
if ($bf_counter > 0) {echo $bf_title . '+(' . $bf_counter . ')';}
echo <<<END
" alt="DB0 Lifestream Pie Chart" /><br/><br/>
END;
}

/* Begin Google Small Chart code */
if (get_option('small_chart_enabled') == 1) {
echo '
<a href="#chart" title="A chart of my recent activities"><img class="smallchart" src="http://chart.apis.google.com/chart?
chs=' . get_option('small_chart_size') .'
&amp;chd=t:
';
if ($f1_counter > 0) {echo $f1_counter . ',';}
if ($f2_counter > 0) {echo $f2_counter . ',';}
if ($f3_counter > 0) {echo $f3_counter . ',';}
if ($f4_counter > 0) {echo $f4_counter . ',';}
if ($f5_counter > 0) {echo $f5_counter . ',';}
if ($greader_custom1_counter > 0) {echo $greader_custom1_counter . ',';}
if ($greader_custom2_counter > 0) {echo $greader_custom2_counter . ',';}
if ($greader_custom3_counter > 0) {echo $greader_custom3_counter . ',';}
if ($df_counter > 0) {echo $df_counter . ',';}
if ($ff_counter > 0) {echo $ff_counter . ',';}
if ($lf_counter > 0) {echo $lf_counter . ',';}
if ($fbf_counter > 0) {echo $fbf_counter . ',';}
if ($tf_counter > 0) {echo $tf_counter . ',';}
if ($su_counter > 0) {echo $su_counter . ',';}
if ($reddit_counter > 0) {echo $reddit_counter . ',';}
if ($digg_counter > 0) {echo $digg_counter . ',';}
if ($pmog_counter > 0) {echo $pmog_counter . ',';}
if ($gsfn_counter > 0) {echo $gsfn_counter . ',';}
if ($greader_shared_counter > 0) {echo $greader_shared_counter . ',';}
if ($comments_counter > 0) {echo $comments_counter . ',';}
if ($bf_counter > 0) {echo $bf_counter;}
echo '
&amp;cht=p
&amp;chco=
' . str_replace('#','',get_option('small_chart_colour')) .'
&amp;chf=bg,s,
' . str_replace('#','',get_option('small_chart_background')) .'
&amp;chl=
';
if ($f1_counter > 0) {echo '[' . $f1_counter . ']|';}
if ($f2_counter > 0) {echo '[' . $f2_counter . ']|';}
if ($f3_counter > 0) {echo '[' . $f3_counter . ']|';}
if ($f4_counter > 0) {echo '[' . $f4_counter . ']|';}
if ($f5_counter > 0) {echo '[' . $f5_counter . ']|';}
if ($greader_custom1_counter > 0) {echo '[' . $greader_custom1_counter . ']|';}
if ($greader_custom2_counter > 0) {echo '[' . $greader_custom2_counter . ']|';}
if ($greader_custom3_counter > 0) {echo '[' . $greader_custom3_counter . ']|';}
if ($df_counter > 0) {echo '[' . $df_counter . ']|';}
if ($ff_counter > 0) {echo '[' . $ff_counter . ']|';}
if ($lf_counter > 0) {echo '[' . $lf_counter . ']|';}
if ($fbf_counter > 0) {echo '[' . $fbf_counter . ']|';}
if ($tf_counter > 0) {echo '[' . $tf_counter . ']|';}
if ($su_counter > 0) {echo '[' . $su_counter . ']|';}
if ($reddit_counter > 0) {echo '[' . $reddit_counter . ']|';}
if ($digg_counter > 0) {echo '[' . $digg_counter . ']|';}
if ($pmog_counter > 0) {echo '[' . $pmog_counter . ']|';}
if ($gsfn_counter > 0) {echo '[' . $gsfn_counter . ']|';}
if ($greader_shared_counter > 0) {echo '[' . $greader_shared_counter . ']|';}
if ($comments_counter > 0) {echo '[' . $comments_counter . ']|';}
if ($bf_counter > 0) {echo '[' . $bf_counter . ']';}
echo <<<END
" alt="A Chart of my recent activities" /></a>
END;
}

?>

</ul>
<br />
<br />
<em>Lifestream powered from a <a href="http://dbzer0.com/complexlife">Complexlife</a>.</em>
</div>

<?php }

//set initial defaults for feeds
add_option('s_flickr', '');
add_option('flickrback', '');
add_option('flickrtext', '');
add_option('s_flickr_thumbs', 'true');
add_option('s_flickr_title', 'false');

add_option('s_delicious', '');
add_option('delback', '');
add_option('deltext', '');
add_option('del_extra_text', '');
add_option('del_title', '');

add_option('s_blog', '');
add_option('blogback', '');
add_option('blogtext', '');
add_option('blogico', 'blog.gif');
add_option('blog_title', '');
add_option('blog_extra_text', 'Blogged:');

add_option('s_lastfm', '');
add_option('lastback', '');
add_option('lasttext', '');
add_option('lastfm_recent_tracks', 'false');

add_option('s_digg', '');
add_option('diggback', '');
add_option('diggtext', '');
add_option('digg_extra_text', '');
add_option('digg_title', '');

add_option('s_facebook', '');
add_option('facebook_posted', '');
add_option('faceback', '');
add_option('facetext', '');

add_option('simple_feed1', '');
add_option('simple_back1', '');
add_option('simple_text1', '');
add_option('simple_ico1', '');
add_option('f1_extra_text', '');
add_option('f1_title', '');

add_option('simple_feed2', '');
add_option('simple_back2', '');
add_option('simple_text2', '');
add_option('simple_ico2', '');
add_option('f2_extra_text', '');
add_option('f2_title', '');

add_option('simple_feed3', '');
add_option('simple_back3', '');
add_option('simple_text3', '');
add_option('simple_ico3', '');
add_option('f3_extra_text', '');
add_option('f3_title', '');

add_option('simple_feed4', '');
add_option('simple_back4', '');
add_option('simple_text4', '');
add_option('simple_ico4', '');
add_option('f4_extra_text', '');
add_option('f4_title', '');

add_option('simple_feed5', '');
add_option('simple_back5', '');
add_option('simple_text5', '');
add_option('simple_ico5', '');
add_option('f5_extra_text', '');
add_option('f5_title', '');

add_option('greader_shared', '');
add_option('greader_shared_nr', '');
add_option('greader_shared_back', '');
add_option('greader_shared_text', '');
add_option('greader_shared_extra_text', '');

add_option('greader_comments', '');
add_option('greader_comments_nr', '');
add_option('comments_back', '');
add_option('comments_text', '');
add_option('greader_comments_author', '');
add_option('comments_extra_text', '');
add_option('comments_title', '');

add_option('greader_lifestream', '');
add_option('greader_lifestream_nr', '');
add_option('twitback', '');
add_option('twittext', '');
add_option('twitter_extra_text', '');
add_option('twitter_title', '');
add_option('twitter_username', '');
add_option('suback', '');
add_option('sutext', '');
add_option('su_extra_text', '');
add_option('su_title', '');
add_option('su_username', '');
add_option('redditback', '');
add_option('reddittext', '');
add_option('reddit_extra_text', '');
add_option('reddit_title', '');
add_option('reddit_username', '');
add_option('gsfn_back', '');
add_option('gsfn_text', '');
add_option('gsfn_extra_text', '');
add_option('gsfn_title', '');
add_option('gsfn_username', '');
add_option('pmog_back', '');
add_option('pmog_text', '');
add_option('pmog_extra_text', '');
add_option('pmog_title', '');
add_option('pmog_username', '');

add_option('greader_custom1_back', '');
add_option('greader_custom1_text', '');
add_option('greader_custom1_extra_text', '');
add_option('greader_custom1_title', '');
add_option('greader_custom1_keyword', '');
add_option('greader_custom1_crop', '');
add_option('greader_custom1_ico', '');

add_option('greader_custom2_back', '');
add_option('greader_custom2_text', '');
add_option('greader_custom2_extra_text', '');
add_option('greader_custom2_title', '');
add_option('greader_custom2_keyword', '');
add_option('greader_custom2_crop', '');
add_option('greader_custom2_ico', '');

add_option('greader_custom2_back', '');
add_option('greader_custom2_text', '');
add_option('greader_custom2_extra_text', '');
add_option('greader_custom2_title', '');
add_option('greader_custom2_keyword', '');
add_option('greader_custom2_crop', '');
add_option('greader_custom2_ico', '');

add_option('default_back', '');
add_option('default_text', '');
add_option('extra_prep_text', '#bfbfbf');

add_option('simplehoverback', '');
add_option('simplehovertext', '');
add_option('simple_hoverborder', '');

add_option('simple_flimit', '0');
add_option('simple_datelimit', '0');
add_option('simple_cache', '15');

add_option('simple_time', 'H:i');
add_option('simple_date', 'M jS');

add_option('big_chart_enabled', '0');
add_option('big_chart_colour1', '#ff0000');
add_option('big_chart_colour2', '#00ff00');
add_option('big_chart_colour3', '#0000ff');
add_option('big_chart_background', '#000000');
add_option('big_chart_size', '800x200');
add_option('small_chart_enabled', '0');
add_option('small_chart_colour', '#0000ff');
add_option('small_chart_background', '#000000');
add_option('small_chart_size', '300x150');
add_option('small_chart_right', '50');
add_option('small_chart_top', '350');

add_option('advanced_options', '1');

add_option('simple_tz', 'Europe/London');

//cache me up
define('WP_CONTENT', dirname(dirname(str_replace(array('http://' . $_SERVER['HTTP_HOST'], 'https://' . $_SERVER['HTTP_HOST']), $_SERVER['DOCUMENT_ROOT'], get_bloginfo('template_url')))));
define('CACHEDIR', WP_CONTENT . '/cache');

//simplepie load
//if(!class_exists("SimplePie")){
//    include_once('simplepie.inc');
//}

function doSimpleWidget()
{
	if (function_exists('register_sidebar_widget')){
	register_sidebar_widget('ComplexLife', 'simpleWidget');
	}
}

function simpleWidget($args)
{
	extract($args);

	echo $before_widget;
	echo $before_title;
	echo '<a href="http://dbzer0.com/complexlife/">Lifestream</a>';
	echo $after_title;

        complexlife();

	echo $after_widget;
}

//add menu
add_action('admin_menu', 'complexlifeOptions');
add_action('plugins_loaded', 'doSimpleWidget');

?>
