<?php
/*
Plugin Name: Macro Expander
Plugin URI: http://www.hollemansproductions.com/wordpress-macro-expander-plugin.html
Description: Replaces user-defined keywords in a blog post with the output from the corresponding user-defined PHP function.
Version: 1.1
Author: Matthijs Hollemans
Author URI: http://www.hollemansproductions.com
*/

/* ADD YOUR OWN MACRO FUNCTIONS BELOW THIS LINE ============================= */

function macro_test($name='world', $weather='sunny')
{
	return "Hello, <b>$name</b>! The weather is $weather.";
}

/* ADD YOUR OWN MACRO FUNCTIONS ABOVE THIS LINE ============================= */

/*
Copyright (c) 2007 Matthijs Hollemans

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

function expand_the_macros($content, $with_rss)
{
	$output = '';
	$offset = 0;

	while (($pos = strpos($content, "[[", $offset)) !== false) 
	{
		$output .= substr($content, $offset, $pos - $offset);
		$offset = $pos + 2;  // skip the [[

		if (($pos = strpos($content, "]]", $offset)) !== false)
		{
			$macro_full = substr($content, $offset, $pos - $offset);
			if ($macro_full != '')
			{
				if (($sep = strpos($macro_full, "][")) !== false)
				{
					$macro_name = substr($macro_full, 0, $sep);
					$params = substr($macro_full, $sep);

					if (preg_match_all("/\]\[([^\]]+)/", $params, $matches))
					{
						$args = $matches[1];
					}
				}
				else
				{
					$macro_name = $macro_full;
					$args = array();
				}

				if ($macro_name != '')
				{
					if ($with_rss === true)
					{
						$func_name = 'macro_rss_' . $macro_name;
					}
					else
					{
						$func_name = 'macro_' . $macro_name;
					}

					if (function_exists($func_name))
					{
						$output .= call_user_func_array($func_name, $args);
					}
				}
			}

			$offset = $pos + 2;  // skip the ]]
		}
	}

	$output .= substr($content, $offset);
	return $output;
}

function expand_macros($content)
{
	return expand_the_macros($content, false);
}

function expand_macros_rss($content)
{
	return expand_the_macros($content, true);
}

add_filter('the_content', 'expand_macros');
add_filter('the_content_rss', 'expand_macros_rss');

?>
