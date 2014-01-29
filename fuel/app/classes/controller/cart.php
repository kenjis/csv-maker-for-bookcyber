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

class Controller_Cart extends Controller_Rest
{
	protected $format = 'json';
	
	public function post_add()
	{
		$isbn = Input::post('isbn');
		$title = Input::post('title');
		
		$cart = Session::get('cart');
		$cart[$isbn] = $title;
		Session::set('cart', $cart);
		
		return array('status' => '『' . $title . '』を追加しました');
	}
	
		public function post_delete()
	{
		$isbn = Input::post('isbn');
		$title = Input::post('title');
		
		$cart = Session::get('cart');
		unset($cart[$isbn]);
		Session::set('cart', $cart);
		
		return array('status' => '『' . $title . '』を削除しました');
	}
	
	public function get_get()
	{
		$output = array();
		$cart = Session::get('cart');
		foreach ($cart as $isbn => $title) {
			$output[] = array($title, $isbn);
		}
		//var_dump($output);
		$response = Response::forge(Format::forge($output)->to_csv());
		$response->set_header('Content-Type', 'application/csv');
		$response->set_header('X-Content-Type-Options', 'nosniff');
		$response->set_header('Content-Disposition', 'attachment; filename="books.csv"');
		$response->set_header('Content-Transfer-Encoding', 'binary');
		$response->set_header('Cache-Control', 'no-store, no-cache, must-revalidate');
		
		return $response;
	}
}
