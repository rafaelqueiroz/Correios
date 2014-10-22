<?php
/**
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*
* @license MIT License (http://www.opensource.org/licenses/mit-license.php)
*/

App::uses('Component', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Xml', 'Utility');

/**
 * Correios Component
 *
 * @author Rafael F Queiroz <rafaelfqf@gmail.com>
 */
class CorreiosComponent extends Component {

	/**
	 * Version.
	 */
	const VERSION = '1.0';

	/**
	 * Domains
	 *
	 * @var array
	 */
	public static $DOMAINS = array(
		"correios" => "http://ws.correios.com.br/calculador/",
		"republicavirtual" => "http://cep.republicavirtual.com.br/"
	);

	/**
	 * Constructor
	 *
	 * @param ComponentCollection $collection 
	 * @param array $settings
	 * @return CorreiosComponent
	 */
	public function __construct(ComponentCollection $collection, $settings) {
		
	}

	/**
	 * Method of CalcPrecoPrazo
	 *
	 * @var array $data
	 * @return array
	 */
	public function calcPrecoPrazo($data) {
	}

	/**
	 * Method of CalcPreco
	 *
	 * @var array $data
	 * @return array
	 */
	public function calcPreco($data) {

	}

	/**
	 * Method of CalcPrazo
	 *
	 * @var array $data
	 * @return array
	 */
	public function calcPrazo($data) {

	}

	/**
	 * Method of CEP
	 *
	 * @param array $data
	 * @param array $params
	 * @return mixed
	 */
	public function cep($data, $params=array('formato' => 'json')) {
		$url = $this->getUrl("republicavirtual", "web_cep.php");
		$request = $this->makeRequest ($url, array_merge($data, $params));
		if (!$request->isOk()) {
			throw new Excpetion('Correios Request Invalid');
		}

		if ($params['formato'] === 'json')
			return (array) json_decode($request->body);

		return $request->body;
	}

	/**
	 * Builder the URL.
	 *
	 * @param string $name
	 * @param string $url
	 * @return string
	 */
	protected function getUrl($name, $url) {
		return self::$DOMAINS[$name] . $url;
	}

	/**
	 * Make a Request.
	 *
	 * @var string $name
	 * @var array  $params
	 * @return 
	 */
	protected function makeRequest($url, $params) {
		$http = new HttpSocket();
		debug (http_build_query($params, null, '&'));
		return $http->get($url, http_build_query($params, null, '&'));
	}

}