<?php
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2013 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$shortcode_tags = array();

function add_ytshortcode($tag, $func) {
	global $shortcode_tags;

	if(is_callable($func))
		$shortcode_tags[$tag] = $func;
}

function parse_shortcode($content) {
	global $shortcode_tags;
	if(empty($shortcode_tags) || !is_array($shortcode_tags))
		return $content;

	$pattern = get_ytshortcode_regex();
	
	return preg_replace_callback('/' . $pattern . '/s', 'parse_shortcode_tag', $content);
}


function get_ytshortcode_regex() {
	global $shortcode_tags;
	
	$tagnames  = array_keys($shortcode_tags);
	$tagregexp = implode('|', array_map('preg_quote', $tagnames));

	// WARNING! Do not change this regex without changing parse_shortcode_tag() and strip_ytshortcodes()
	return '(.?)\[('.$tagregexp.')\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)';
}


function parse_shortcode_tag($m) {
	global $shortcode_tags;
	
	// allow [[foo]] syntax for escaping a tag
	if($m[1] == '[' && $m[6] == ']') {
		return substr($m[0], 1, -1);
	}

	$tag = $m[2];
	$attr = ytshortcode_parse_atts($m[3]);

	if(isset($m[5])) {
		// enclosing tag - extra parameter
		
		return $m[1] . call_user_func($shortcode_tags[$tag], $attr, $m[5], $tag) . $m[6];
	}else {
		// self-closing tag
		return $m[1] . call_user_func($shortcode_tags[$tag], $attr, NULL,  $tag) . $m[6];
	}
}


function ytshortcode_parse_atts($text) {
	$atts    = array();
	$pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
	$text    = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);

	if(preg_match_all($pattern, $text, $match, PREG_SET_ORDER)) {
		foreach($match as $m) {
			if(!empty($m[1]))
				$atts[strtolower($m[1])] = stripcslashes($m[2]);
			elseif(!empty($m[3]))
				$atts[strtolower($m[3])] = stripcslashes($m[4]);
			elseif(!empty($m[5]))
				$atts[strtolower($m[5])] = stripcslashes($m[6]);
			elseif(isset($m[7]) and strlen($m[7]))
				$atts[] = stripcslashes($m[7]);
			elseif(isset($m[8]))
				$atts[] = stripcslashes($m[8]);
		}
	}
	else {
		$atts = ltrim($text);
	}

	return $atts;
}


function ytshortcode_atts($pairs, $atts) {
	$atts =(array)$atts;
	$out  = array();

	foreach($pairs as $name => $default) {
		if(array_key_exists($name, $atts))
			$out[$name] = $atts[$name];
		else
			$out[$name] = $default;
	}
	return $out;
}


function strip_ytshortcodes($content) {
	global $shortcode_tags;
	
	if(empty($shortcode_tags) || !is_array($shortcode_tags))
		return $content;

	$pattern = get_ytshortcode_regex();

	return preg_replace('/' . $pattern . '/s', '$1$6', $content);
}