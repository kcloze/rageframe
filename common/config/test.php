<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    'id'         => 'app-common-tests',
    'basePath'   => dirname(__DIR__),
    'components' => [
        'user' => [
            'class'         => 'yii\web\User',
            'identityClass' => 'common\models\User',
        ],
    ],
];
