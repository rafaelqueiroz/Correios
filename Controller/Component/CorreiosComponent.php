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
		$url = $this->getUrl("correios", "CalcPrecoPrazo.aspx");
		$request = $this->makeRequest($url, $data);
		if (!$request->isOk())
			throw new CakeException($request->body);

		return Xml::toArray(Xml::build($request->body));
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
		$request = $this->makeRequest($url, array_merge($data, $params));
		if (!$request->isOk())
			throw new CakeException($request->body);

		if ($params['formato'] === 'json')
			return (array) json_decode($request->body);

		return $request->body;
	}

	/**
	 * Method of rastreamento
	 *
	 * @param string $code
	 * @return bool
	 */
	public function rastreamento($code) {
		$url = "http://websro.correios.com.br/sro_bin/txect01$.QueryList?P_LINGUA=001&P_TIPO=001&P_COD_UNI={$code}";
		$request = $this->makeRequest($url);

		$doc = new DOMDocument();
		@$doc->loadHTML($request->body);
		
		$table = $doc->getElementsByTagName('table')->item(0);
		if (is_null($table)) {
			return false;
		}

		$indexes = $results = array();
		foreach ($table->getElementsByTagName('tr') as $index => $column) {
			$values = array();
			foreach ($column->getElementsByTagName('td') as $value) {
				if ($index === 0) {
					$indexes[] = $value->nodeValue;
				} else {
					$values[]  = $value->nodeValue;
				}
			}
			if (!$values) {
				continue;
			}
			$results[] = array_combine($indexes, $values);
		}

		return $results;
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
	protected function makeRequest($url, $params = array()) {
		$http = new HttpSocket();
		return $http->get($url, http_build_query($params));
	}

}