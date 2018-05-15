<?php

namespace common\components\widgets\junction_loader;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the javascript files for the JunctionLoader widget
 *
 * @author Prabowo Murti <prabowo.murti@gmail.com>
 */
class JunctionViewAsset extends AssetBundle
{
    public $sourcePath = '@common/components/widgets/junction_loader';
    public $js = [
        'junction.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    public $publishOptions = [
        'forceCopy' => YII_DEBUG
    ];
}
