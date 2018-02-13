<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace api\modules\v1\controllers;

use api\controllers\AController;

/**
 * 默认控制器.
 *
 * Class DefaultController
 */
class DefaultController extends AController
{
    public $modelClass = 'common\models\member\Member';

    /**
     * 测试查询方法.
     *
     * @return string
     */
    public function actionSearch()
    {
        return '测试查询';
    }
}
