=== Easy Video Player ===
Contributors: naa986
Donate link: http://noorsplugin.com/
Tags: video, wpvideo, flash, html5, iPad, iphone, ipod, mobile, playlists, embed video, flowplayer, video html5, flash player, player, video player
Requires at least: 4.3
Tested up to: 4.5
Stable tag: 1.1.3
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Easy Video Player is a WordPress video player that allows you to embed videos into your WordPress site.

== Description ==

Easy Video Player is a user-friendly WordPress video plugin to showcase your videos. You can embed both self-hosted videos or videos that are external hosted using direct links.

= Easy Video Player Features =

* Embed MP4 videos into your blog
* Embed responsive videos for a better user experience while viewing from a mobile device
* Embed HTML5 videos which are compatible with all major browsers
* Embed videos with poster images
* Embed videos with autoplay
* Embed videos with loop
* Embed videos with muted enabled
* Customize the video player using modifier classes
* Embed videos using three different skins
* Embed videos using MediaElement player or default WordPress video player

= Easy Video Player Plugin Usage =

**Settings Configuration**

It's pretty easy to set up this video player plugin. Once you have installed the plugin simply navigate to the Settings menu where you will be able to configure some options. Mostly you just to need check the "Enable jQuery" option. That will allow the plugin to make use of jQuery library.

**Embedding Shortcodes for the Videos**

Now it's time to finally embed a video shortcode. To do this create a new post/page and use the following shortcode:

`[evp_embed_video url="http://example.com/wp-content/uploads/videos/myvid.mp4"]`

here, url is a shortcode parameter that you need to replace the actual URL of the video file.

**Video Autoplay**

If you want a particular video to start playing when the page loads you can set the "autoplay" option to "true":

`[evp_embed_video url="http://example.com/wp-content/uploads/videos/myvid.mp4" autoplay="true"]`

**Control Size**

By default, the player takes up the full width of the content area. You can easily control the size by specifying a width for it:

`[evp_embed_video url="http://example.com/wp-content/uploads/videos/myvid.mp4" width="500"]`

The height will be automatically determined based on the ratio (please see the "Control Player Ratio section" for details).

**Control Player Ratio**

The player ratio is set to "0.417" by default. But you can override it by specifying a different ratio in the shortcode:

`[evp_embed_video url="http://example.com/wp-content/uploads/videos/myvid.mp4" ratio="0.345"]`

**Control Player Skin**

By default, the player uses the "minimalist" skin. But you can override it by specifying a different skin in the shortcode:

`[evp_embed_video url="http://example.com/wp-content/uploads/videos/myvid.mp4" class="functional"]`

**Video Loop**

If you want a particular video to start playing again when it ends you can set the "loop" option to "true":

`[evp_embed_video url="http://example.com/wp-content/uploads/videos/myvid.mp4" loop="true"]`

**Video Muted**

If you want a particular video to play without any audio output you can set the "muted" option to "true":

`[evp_embed_video url="http://example.com/wp-content/uploads/videos/myvid.mp4" muted="true"]`

**Video Player Template**

If you want to use a different video player template you can specify it in the "template" parameter:

`[evp_embed_video url="http://example.com/wp-content/uploads/videos/myvid.mp4" template="mediaelement"]`

By default, the mediaelement template only loads the "metadata" of a video when the page loads. You can set it to "auto" or "none" with the preload parameter in the shortcode.

`[evp_embed_video url="http://example.com/wp-content/uploads/videos/myvid.mp4" preload="auto" template="mediaelement"]`

For detailed documentation please visit the [Easy Video Player](http://noorsplugin.com/wordpress-video-plugin/ "Video Plugin for WordPress") plugin page

= Plugin Language Translation =

If you are a non-English speaker please help [translate Easy Video Player](https://translate.wordpress.org/projects/wp-plugins/easy-video-player) into your language.

= Recommended Reading =

* Easy Video Player [Documentation](http://noorsplugin.com/wordpress-video-plugin/)
* My Other [Free WordPress Plugins](http://noorsplugin.com/wordpress-plugins/)

== Installation ==

1. Go to the Add New plugins screen in your WordPress Dashboard
1. Click the upload tab
1. Browse for the plugin file (easy-video-player.zip) on your computer
1. Click "Install Now" and then hit the activate button
1. Now, go to the settings menu of the plugin and follow the instructions for embedding videos.

== Frequently Asked Questions ==

= Can this plugin be used to embed videos on my WordPress blog? =

Yes.

= Are the videos embedded by this plugin playable on iOS devices? =

Yes.

= Can I autoplay a video? =

Yes.

= Can I embed responsive videos using this plugin? =

Yes.

== Screenshots ==

1. Easy Video Player Demo
2. Easy Video Player Demo With MediaElement Template

== Upgrade Notice ==
none

== Changelog ==

= 1.1.3 =
* mediaelement template now supports the video preload attribute

= 1.1.2 =
* Added translation option so the plugin can take advantage of language packs

= 1.1.1 =
* Added a new shortcode parameter "muted" to disable the audio output of the video

= 1.1.0 =
* Added a new video player template - MediaElement

= 1.0.9 =
* Easy Video Player is now compatible with WordPress 4.3

= 1.0.8 =
* Added a new shortcode parameter "loop" to start playback again from the beginning when the video ends

= 1.0.7 =
* Video shortcode now accepts custom class names which can be used to customize the player

= 1.0.6 =
* Updated flowplayer library to version 5.5.2
* Disabled external embedding option in the player

= 1.0.5 =
* Video shortcode can now be embedded in a text widget

= 1.0.4 =
* Easy video player is now compatible with WordPress 4.0
* Added a new parameter in the shortcode to accept poster image for a video

= 1.0.3 =
* Easy video player is now compatible with WordPress 3.9

= 1.0.2 =
* The plugin can now automatically start playing a video
* The player can be resized using a specific width and height
* The ratio of each video can be customized

= 1.0.1 =
* First commit
