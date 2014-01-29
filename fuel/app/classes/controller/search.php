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

class Controller_Search extends Controller
{
	public function action_index()
	{
		$keyword = Input::get('q');
		$results = null;
		
		$view = View::forge('search/index');
		$view->set('keyword', $keyword);
		if ($keyword) {
			$ndlsearch = new Model_Ndlsearch();
			$results = $ndlsearch->search_title($keyword);
		}
		$view->set('results', $results);
		
		$cart = Session::get('cart');
		is_null($cart) and $cart = array();
		Session::set('cart', $cart);
		//var_dump($cart); exit;
		$view->set('cart', $cart);
		
		return Response::forge($view);
	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(ViewModel::forge('welcome/404'), 404);
	}
}
