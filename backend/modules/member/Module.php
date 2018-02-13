<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace backend\modules\member;

/**
 * Class Module.
 */
class Module extends \yii\base\Module
{
    /**
     * 控制器命名空间.
     *
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\member\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
