<?php
/**
 * @package Sj K2 Slick Slider
 * @version 3.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;
jimport('joomla.filesystem.file');

require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'utilities.php');

include_once dirname(__FILE__).'/helper_base.php';


abstract class K2SlickSliderHelper extends K2SlickSliderBaseHelper {
	public static function getList(&$params)
	{
		
		$mainframe = JFactory::getApplication();
		$limit = $params->get('itemCount', 5);
		$cid = $params->get('category_id', NULL);
		$ordering = $params->get('itemsOrdering', '');
		
		$user = JFactory::getUser();
		$aid = $user->get('aid');
		$db = JFactory::getDBO();

		$jnow = JFactory::getDate();
		$now =  K2_JVERSION == '15'?$jnow->toMySQL():$jnow->toSql();
		$nullDate = $db->getNullDate();

		if ($params->get('source') == 'specific')
		{

			$value = $params->get('items');
			$current = array();
			if (is_string($value) && !empty($value))
				$current[] = $value;
			if (is_array($value))
				$current = $value;

			$items = array();

			foreach ($current as $id)
			{

				$query = "SELECT i.*, c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams 
				FROM #__k2_items as i 
				LEFT JOIN #__k2_categories c ON c.id = i.catid 
				WHERE i.published = 1 ";
				if (K2_JVERSION != '15')
				{
					$query .= " AND i.access IN(".implode(',', $user->getAuthorisedViewLevels()).") ";
				}
				else
				{
					$query .= " AND i.access<={$aid} ";
				}
				$query .= " AND i.trash = 0 AND c.published = 1 ";
				if (K2_JVERSION != '15')
				{
					$query .= " AND c.access IN(".implode(',', $user->getAuthorisedViewLevels()).") ";
				}
				else
				{
					$query .= " AND c.access<={$aid} ";
				}
				$query .= " AND c.trash = 0 
				AND ( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." ) 
				AND ( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." ) 
				AND i.id={$id}";
				if (K2_JVERSION != '15')
				{
					if ($mainframe->getLanguageFilter())
					{
						$languageTag = JFactory::getLanguage()->getTag();
						$query .= " AND c.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').") AND i.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').")";
					}
				}
				$db->setQuery($query);
				$item = $db->loadObject();
				if ($item)
					$items[] = $item;

			}
		}

		else
		{
			$query = "SELECT i.*, CASE WHEN i.modified = 0 THEN i.created ELSE i.modified END as lastChanged, c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams";

			if ($ordering == 'best')
				$query .= ", (r.rating_sum/r.rating_count) AS rating";

			if ($ordering == 'comments')
				$query .= ", COUNT(comments.id) AS numOfComments";

			$query .= " FROM #__k2_items as i RIGHT JOIN #__k2_categories c ON c.id = i.catid";

			if ($ordering == 'best')
				$query .= " LEFT JOIN #__k2_rating r ON r.itemID = i.id";

			if ($ordering == 'comments')
				$query .= " LEFT JOIN #__k2_comments comments ON comments.itemID = i.id";

			if (K2_JVERSION != '15')
			{
				$query .= " WHERE i.published = 1 AND i.access IN(".implode(',', $user->getAuthorisedViewLevels()).") AND i.trash = 0 AND c.published = 1 AND c.access IN(".implode(',', $user->getAuthorisedViewLevels()).")  AND c.trash = 0";
			}
			else
			{
				$query .= " WHERE i.published = 1 AND i.access <= {$aid} AND i.trash = 0 AND c.published = 1 AND c.access <= {$aid} AND c.trash = 0";
			}

			$query .= " AND ( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." )";
			$query .= " AND ( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." )";

			if ($params->get('catfilter'))
			{
				if (!is_null($cid))
				{
					if (is_array($cid))
					{
						if ($params->get('getChildren'))
						{
							$itemListModel = K2Model::getInstance('Itemlist', 'K2Model');
							$categories = $itemListModel->getCategoryTree($cid);
							$sql = @implode(',', $categories);
							$query .= " AND i.catid IN ({$sql})";

						}
						else
						{
							JArrayHelper::toInteger($cid);
							$query .= " AND i.catid IN(".implode(',', $cid).")";
						}

					}
					else
					{
						if ($params->get('getChildren'))
						{
							$itemListModel = K2Model::getInstance('Itemlist', 'K2Model');
							$categories = $itemListModel->getCategoryTree($cid);
							$sql = @implode(',', $categories);
							$query .= " AND i.catid IN ({$sql})";
						}
						else
						{
							$query .= " AND i.catid=".(int)$cid;
						}

					}
				}
			}

			if ($params->get('FeaturedItems') == '0')
				$query .= " AND i.featured != 1";

			if ($params->get('FeaturedItems') == '2')
				$query .= " AND i.featured = 1";

			if ($params->get('videosOnly'))
				$query .= " AND (i.video IS NOT NULL AND i.video!='')";

			if ($ordering == 'comments')
				$query .= " AND comments.published = 1";

			if (K2_JVERSION != '15')
			{
				if ($mainframe->getLanguageFilter())
				{
					$languageTag = JFactory::getLanguage()->getTag();
					$query .= " AND c.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').") AND i.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').")";
				}
			}

			switch ($ordering)
			{

				case 'date' :
					$orderby = 'i.created ASC';
					break;

				case 'rdate' :
					$orderby = 'i.created DESC';
					break;

				case 'alpha' :
					$orderby = 'i.title';
					break;

				case 'ralpha' :
					$orderby = 'i.title DESC';
					break;

				case 'order' :
					if ($params->get('FeaturedItems') == '2')
						$orderby = 'i.featured_ordering';
					else
						$orderby = 'i.ordering';
					break;

				case 'rorder' :
					if ($params->get('FeaturedItems') == '2')
						$orderby = 'i.featured_ordering DESC';
					else
						$orderby = 'i.ordering DESC';
					break;

				case 'hits' :
					if ($params->get('popularityRange'))
					{
						$datenow = JFactory::getDate();
						$date =  K2_JVERSION == '15'?$datenow->toMySQL():$datenow->toSql();
						$query .= " AND i.created > DATE_SUB('{$date}',INTERVAL ".$params->get('popularityRange')." DAY) ";
					}
					$orderby = 'i.hits DESC';
					break;

				case 'rand' :
					$orderby = 'RAND()';
					break;

				case 'best' :
					$orderby = 'rating DESC';
					break;

				case 'comments' :
					if ($params->get('popularityRange'))
					{
						$datenow = JFactory::getDate();
						$date =  K2_JVERSION == '15'?$datenow->toMySQL():$datenow->toSql();
						$query .= " AND i.created > DATE_SUB('{$date}',INTERVAL ".$params->get('popularityRange')." DAY) ";
					}
					$query .= " GROUP BY i.id ";
					$orderby = 'numOfComments DESC';
					break;

				case 'modified' :
					$orderby = 'lastChanged DESC';
					break;

				case 'publishUp' :
					$orderby = 'i.publish_up DESC';
					break;

				default :
					$orderby = 'i.id DESC';
					break;
			}

			$query .= " ORDER BY ".$orderby;
			// $sql = str_replace('#__','jos_',$query);
			// echo $sql;die;
			//var_dump($limit);
			$db->setQuery($query, 0, $limit);
			$items = $db->loadObjectList();
		}

		$model = K2Model::getInstance('Item', 'K2Model');
		$show_introtext = $params->get('item_desc_display', 0);		
		$introtext_limit = $params->get('item_desc_max_characs', 100);
		
		$show_title = $params->get('item_title_display', 1);
		$title_limit = $params->get('item_title_max_characs', 20);
		
		$item_title_ending_char = $params->get('item_title_ending_char', '');
		$item_desc_ending_char = $params->get('item_desc_ending_char', '');
		
	
		if (count($items))
		{

			foreach ($items as $item)
			{

				//Clean title
				$item->title = JFilterOutput::ampReplace($item->title);
				
				$item->displaytitle = $show_title ? self::truncate($item->title, $title_limit, $item_title_ending_char) : '';	
				
				//Read more link
				$item->link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid.':'.urlencode($item->categoryalias))));

				//Tags
				$item->tags = '';
				if ($params->get('item_tags_display'))
				{
					$tags = $model->getItemTags($item->id);
					for ($i = 0; $i < sizeof($tags); $i++)
					{
						$tags[$i]->link = JRoute::_(K2HelperRoute::getTagRoute($tags[$i]->name));
					}
					$item->tags = $tags;
				}else{
					$item->tags = '';
				}

                // Restore the intotext variable after plugins execution
				self::getK2Images($item, $params);
				//Clean the plugin tags
				$item->introtext = preg_replace("#{(.*?)}(.*?){/(.*?)}#s", '', $item->introtext);
				if($item->fulltext != ''){
					$item->fulltext = preg_replace("#{(.*?)}(.*?){/(.*?)}#s", '', $item->fulltext);
					$item->introtext = self::_cleanText($item->introtext.$item->fulltext);
				}else{
					$item->introtext = self::_cleanText($item->introtext);
				}	
				$item->displayIntrotext = $show_introtext ? self::truncate($item->introtext, $introtext_limit, $item_desc_ending_char) : '';	
				$rows[] = $item;
			}
			return $rows;
		}

	}

}
