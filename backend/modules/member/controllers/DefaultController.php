<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace backend\modules\member\controllers;

/**
 * Class DefaultController.
 */
class DefaultController extends UController
{
    /**
     * Renders the index view for the module.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
