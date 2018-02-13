<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace backend\widgets\webuploader\assets;

use yii\web\AssetBundle;

class WebuploaderAsset extends AssetBundle
{
    public $sourcePath = '@backend/widgets/webuploader/statics/webuploader/';

    public $css = [
        'webuploader.css',
    ];

    public $js = [
        'webuploader.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
