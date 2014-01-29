<?php
/**
 * 「売りたい書籍のリスト作成 for 電脳書房」の一部です。
 *
 * @package    csv-maker-for-bookcyber
 * @version    0.1
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2014 Kenji Suzuki
 * @link       https://github.com/kenjis/csv-maker-for-bookcyber
 */

/**
 * 国立国会図書館サーチよりキーワード検索
 * 
 * http://iss.ndl.go.jp/information/api/
 */
class Model_Ndlsearch extends Model
{
	const webapi = 'http://iss.ndl.go.jp/api/opensearch?';
	const xmlns_dc = 'http://purl.org/dc/elements/1.1/';
	
	function search_title($keyword)
	{
		$keyword = trim(mb_strtolower($keyword));
		$cacheKey = 'ndlsearch_' . sha1($keyword);
		
		try
		{
			$xml = Cache::get($cacheKey);
			$rss = simplexml_load_string($xml);
		}
		catch (\CacheNotFoundException $e)
		{
			libxml_disable_entity_loader(true);
			
					$qs = array(
			'title' => $keyword,
			);
			$url = static::webapi . http_build_query($qs);
			$xml = file_get_contents($url);
			$rss = simplexml_load_string($xml);
			//var_dump($rss);
			if ($rss === false) {
				throw new RuntimeException('NDL Web API エラー');
			} else {
				Cache::set($cacheKey, $xml, 3600 * 24);
			}
		}

		// <dc:identifier xsi:type="dcndl:ISBN">9784798119885</dc:identifier>
		// <dc:publisher>翔泳社</dc:publisher>

		$results = array();
		foreach ($rss->channel->item as $item) {
			$pubDate = new DateTime($item->pubDate);
			$pubDate = $pubDate->format('Y-m');
			
			// @TODO linkのバリデーション
			
			$results[] = array(
				'title' => $item->title,
				'isbn' => $item->children(static::xmlns_dc)->identifier,
				'publisher' => $item->children(static::xmlns_dc)->publisher,
				'pubDate' => $pubDate,
				'link' => $item->link,
			);
		}
		
		return $results;
	}
}
