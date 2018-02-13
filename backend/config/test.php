<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    'id'         => 'app-backend-tests',
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../../web/backend/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
