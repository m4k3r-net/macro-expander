=== Macro Expander ===
Contributors: mahlzeit
Donate link: http://www.hollemansproductions.com/wordpress-macro-expander-plugin.html
Tags: macro, expand, shortcut
Requires at least: 2.0
Tested up to: 2.2
Stable tag: 1.1

Replaces user-defined keywords in a blog post with the output from the corresponding user-defined PHP function.

== Description ==

You invoke a macro by typing a special command in your blog post:

[[keyword]]

Upon reading this command, the PHP function named "macro_keyword" is called and 
its output is inserted on the page.

You can also pass a parameter to the macro:

[[keyword][param]]

Or multiple parameters:

[[keyword][param1][param2]]

The parameters are separated by the ][ characters, or rather, you can look at it 
as a list of things in brackets surrounded by another pair of brackets.

The PHP file for this plugin has an example function that shows you how to write 
macros. It is called "[[test]]" and is defined in the function "macro_test". The 
"test" macro takes up to two parameters, both optional.

New in 1.1: If you want to include the macros in RSS content, you will have to 
define a second function named "macro_rss_keyword". If this function is not 
present, the macro will not be included in the RSS output.


== Installation ==

1. Download the plugin and unzip it.
2. Add your macro code to "macro_expander.php"
3. Put "macro_expander.php" in the "wp-content/plugins/" directory.
4. Activate the plugin from the WordPress control panel.


== Known Issues ==

*	This is a quick hack, not extensively tested but it seems to work for me.

*	WordPress already adds the <p> and </p> tags around the [[keyword]] before
	the plugin is called -- the plugin doesn't remove those.

*	You can't use " and ' (and possibly a handful of other characters) in 
	parameters because WordPress replaces them with curly quotes before the 
	plugin has a chance to parse them. You *can* use spaces, though.

*	Maybe pass an $is_rss parameter instead of using 2 separate functions?

*	Maybe change syntax to: <!--macro:keyword[param][param]--> ?!


== About ==

*	Version 1.1 (8 June 2007) - The parameter separator is now ][ instead of |.
	Added macro_rss_* functions for the RSS content.

*	Version 1.0 (7 June 2007) - First version

Written by Matthijs Hollemans

http://www.hollemansproductions.com/wordpress-macro-expander-plugin.html

