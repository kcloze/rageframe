<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace backend\widgets\webuploader\assets;

use yii\web\AssetBundle;

/**
 * @author Shiyang <dr@shiyang.me>
 */
class FileAsset extends AssetBundle
{
    public $sourcePath = '@backend/widgets/webuploader/statics/';

    public $css = [
        'css/file.css',
    ];

    public $js = [
        'js/uploader.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
