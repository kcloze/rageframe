<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class HeadJsAsset.
 */
class HeadJsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';

    public $js = [
        '/resource/backend/js/jquery-2.0.3.min.js',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];
}
