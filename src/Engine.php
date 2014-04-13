<?php
namespace Librette\Texy;

use Librette\Texy\Configurators\OptionsConfigurator;

/**
 * @author David Matejka
 */
class Engine extends \Nette\Object
{

	/** @var ICachingStrategy */
	protected $cachingStrategy;

	/** @var \Librette\Texy\ITexyFactory */
	protected $texyFactory;


	/**
	 * @param ITexyFactory $texyFactory
	 * @param ICachingStrategy $cachingStrategy
	 */
	public function __construct(ITexyFactory $texyFactory, ICachingStrategy $cachingStrategy)
	{
		$this->texyFactory = $texyFactory;
		$this->cachingStrategy = $cachingStrategy;

	}


	/**
	 * @param string $text
	 * @param array $options
	 * @return string
	 */
	public function process($text, $options = array())
	{
		$processCallback = function () use ($text, $options) {
			return $this->getTexy($options)->process($text, isset($options['singleLine']) ? $options['singleLine'] : FALSE);
		};
		$cacheKey = $this->calculateKey($text, $options);

		return $this->cachingStrategy->load($cacheKey, $processCallback);
	}


	/**
	 * @param array $options
	 * @return \Texy\Texy
	 */
	public function getTexy($options = array())
	{
		$texy = $this->texyFactory->create($options);
		if (!empty($options)) {
			$optionsConfigurator = new OptionsConfigurator($options);
			$optionsConfigurator->configure($texy);
		}

		return $texy;
	}


	/**
	 * @param string $text
	 * @param $options
	 * @return array
	 */
	private function calculateKey($text, $options)
	{
		//TODO: key from configurator
		return array("optionmethod" => $options, "text" => $text);
	}

}