<?php
/**
 * @package Sj Gallery Pro
 * @version 2.5
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;

require_once JPATH_SITE.'/libraries/joomla/filesystem/folder.php';
JLoader::register('ImageHelper', __DIR__.'/helper_image.php');

if (!class_exists('SjGalleryProReader')){
abstract class SjGalleryProReader{
		public static function getList(&$params){
			$images = array();
			if (($params->get('folder')) && file_exists($params->get('folder'))){
				if ($handle = opendir($params->get('folder'))) {
					while (false !== ($file = readdir($handle))) {
						$current_file = JPath::clean($params->get('folder') . '/' . $file);//var_dump($current_file); die("ancn");
						//var_dump($current_file); die("anbcn");
						if (!is_file($current_file)){
							continue;
						}
						
						$extension = substr($file, strrpos($file, '.')); // Gets the File Extension
						$extension = strtolower($extension);
						if (!in_array($extension, array(
								'.jpeg',
								'.jpg',
								'.gif',
								'.png'
						))){
							continue;
						}

						$image = array();
						$image['image'] = str_replace('\\', '/', $current_file);
						$filename = basename($current_file, $extension);
						$filename = str_replace('_', ' ', $filename);
						$image['title'] = ucwords($filename);
						$image['modified'] = filemtime($current_file);
						$image['url'] = JURI::base(true) . '/' . str_replace('\\', '/', $current_file);
						$images[] = $image;
					}
					closedir($handle);
				}

				if (count($images)>0){
					// sort image files
					if (($params->get('orderby'))){
						$is_sort_desc = ($params->get('sort'))&&(int)$params->get('sort') ? ((int)$params->get('sort')==2) : false;
						switch ($params->get('orderby')){
							case 1:
								if ($is_sort_desc){
									usort($images, create_function('$a, $b', 'return ($a["modified"] == $b["modified"]) ? strcmp($a["title"], $b["title"]) : ($a["modified"] < $b["modified"]);'));
								} else {
									usort($images, create_function('$a, $b', 'return ($a["modified"] == $b["modified"]) ? strcmp($a["title"], $b["title"]) : ($a["modified"] > $b["modified"]);'));
								}
								break;
							case 2:
								if ($is_sort_desc){
									usort($images, create_function('$a, $b', 'return strcmp($b["title"], $a["title"]);'));
								} else {
									usort($images, create_function('$a, $b', 'return strcmp($a["title"], $b["title"]);'));
								}
								break;
							case 3:
								shuffle($images);
								break;
						}
					}
					
					// get by limit
					if (($params->get('numberImage')) && (int)$params->get('numberImage')){
						$images = array_slice($images, 0, (int)$params->get('numberImage'));
					}
				}
			}
			
			return $images;
		}

		public static function imageTag($image, $options=array()){
			return ImageHelper::init($image, $options)->tag();
		}		
		
		
	}
}