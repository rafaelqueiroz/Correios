Correios Plugin
========

Correios Plugin for CakePHP

Requirements
------------

* CakePHP 2.x
* PHP 5

Installation
------------

To install the plugin, place the files in a directory labelled "Correios/" in your "app/Plugin/" directory.

Usage
-----

Controllers that will be using correios require the Correios Component to be included.

```php
public $components = array('Correios.Correios');
```

Example #1

```php
$cep = array('cep' => '29100200');
$this->Correios->cep($cep);
````

The above example will output:

```php
array(
	'resultado' => '1',
	'resultado_txt' => 'sucesso - cep completo',
	'uf' => 'ES',
	'cidade' => 'Vila Velha',
	'bairro' => 'Centro',
	'tipo_logradouro' => 'Avenida',
	'logradouro' => 'Luciano das Neves'
)
````

Example #2

```php
$data = array(
	'nCdServico' => '40010',
	'sCepOrigem' => '70002900',
	'sCepDestino' => '71939360',
	'nVlPeso' => '1',
	'nCdFormato' => 1,
	'nVlComprimento' => 20,
	'nVlAltura' => 5,
	'nVlLargura' => 15,
	'nVlDiametro' => 0,
	'sCdMaoPropria' => 'n',
	'nVlValorDeclarado' => 0,
	'sCdAvisoRecebimento' => 'n',
	'StrRetorno' => 'XML',
);
$this->Correios->calcPrecoPrazo($data);
````

The above example will output:

```php
array(
	'Servicos' => array(
		'cServico' => array(
			'Codigo' => '40010',
			'Valor' => '14,90',
			'PrazoEntrega' => '1',
			'ValorSemAdicionais' => '14,90',
			'ValorMaoPropria' => '0,00',
			'ValorAvisoRecebimento' => '0,00',
			'ValorValorDeclarado' => '0,00',
			'EntregaDomiciliar' => 'S',
			'EntregaSabado' => 'S',
			'Erro' => '0',
			'MsgErro' => ''
		)
	)
)
````

See also for more details:

<a href="http://www.correios.com.br/para-voce/correios-de-a-a-z/pdf/calculador-remoto-de-precos-e-prazos/manual-de-implementacao-do-calculo-remoto-de-precos-e-prazos">Manual de implementação do webservice de cálculo de preços e prazos de encomendas</a>

<a href="http://republicavirtual.com.br/cep/">Busca de CEP - WebService de CEP</a>
