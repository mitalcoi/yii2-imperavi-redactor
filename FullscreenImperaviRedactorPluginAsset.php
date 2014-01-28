<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace mitalcoi\imperavi;
use yii\web\AssetBundle;

/**
 * @author Alexander Yaremchuk <alwex10@gmail.com>
 * @since 1.0
 */
class FullscreenImperaviRedactorPluginAsset extends AssetBundle
{
    public $sourcePath = '@mitalcoi/imperavi/assets/plugins/fullscreen';
    public $js = [
        'fullscreen.js'
    ];
    public $css = [

    ];
    public $depends = [
        'mitalcoi\imperavi\ImperaviRedactorAsset'
    ];
}
