<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace mitalcoi\imperavi;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Imperavi Redactor Widget For Yii2 class file.
 *
 * @property array $plugins
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 * @author Alexander Yaremchuk <alwex10@gmail.com>
 *
 * @version 1.1
 *
 * @link https://github.com/asofter/yii2-imperavi-redactor
 * @link http://imperavi.com/redactor
 * @license https://github.com/asofter/yii2-imperavi-redactor/blob/master/LICENSE.md
 */

class Imperavi extends \yii\base\Widget
{
	/**
	 * @var array the HTML options for input
	 */
	public $options = [];

	/**
	 * @var array the options for the Imperavi Redactor.
	 * Please refer to the corresponding [Imperavi Web page](http://imperavi.com/redactor/docs/)  for possible options.
	 */
	public $clientOptions = [];

	/**
	 * @var array plugins that you want to use
	 */
	public $plugins = [];

	/*
	 * @var object model for active text area
	 */
	public $model = null;

	/*
	 * @var string selector for init js scripts
	 */
	protected $selector = null;

	/*
	 * @var string name of textarea tag or name of attribute
	 */
	public $attribute = null;

	/*
	 * @var string value for text area (without model)
	 */
	public $value = '';

	/**
	 * Initializes the widget.
	 * If you override this method, make sure you call the parent implementation first.
	 */
	public function init()
	{
		parent::init();
		if (!isset($this->options['id'])) {
			$this->options['id'] = $this->getId();
		}
	}

	/**
	 * Renders the widget.
	 */
	public function run()
	{
		$this->selector = '#' . $this->getId();

		if (!is_null($this->model)) {
			echo Html::activeTextarea($this->model, $this->attribute, $this->options);
		} else {
			echo Html::textarea($this->attribute, $this->value, $this->options);
		}

		ImperaviRedactorAsset::register($this->getView());
		$this->registerClientScript();
	}

	/**
	 * Registers Imperavi Redactor JS
	 */
	protected function registerClientScript()
	{
		$view = $this->getView();
		/*
		 * Language fix
		 * @author <https://github.com/sim2github>
		 */
		$appLanguage = 'en'; //First 2 letters
		if ($appLanguage != 'en') // By default $language = 'en-US', someone use underscore
		{
			$this->clientOptions['lang'] = $appLanguage;
		}

		// Insert plugins in options
		if (!empty($this->plugins)) {
			$this->clientOptions['plugins'] = $this->plugins;

			foreach ($this->clientOptions['plugins'] as $plugin) {
				$this->registerPlugin($plugin);
			}
		}
		if (!isset($this->clientOptions['minHeight'])) {
			$this->clientOptions['minHeight'] = 300;
		}
		$options = empty($this->clientOptions) ? '' : Json::encode($this->clientOptions);
		$js = "jQuery('" . $this->selector . "').redactor($options);";
		$view->registerJs($js);
	}

	/**
	 * Registers a specific Imperavi plugin and the related events
	 *
	 * @param string $name the name of the Imperavi plugin
	 */
	protected function registerPlugin($name)
	{
		$name = __NAMESPACE__ . ucfirst($name) . "ImperaviRedactorPluginAsset";
		$name::register($this->getView());
	}
}
