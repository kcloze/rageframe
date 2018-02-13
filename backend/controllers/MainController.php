<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace backend\controllers;

use jianyan\basics\common\models\sys\Manager;
use Yii;

/**
 * 主控制器.
 *
 * Class MainController
 */
class MainController extends MController
{
    /**
     * 主体框架.
     */
    public function actionIndex()
    {
        // 用户ID
        $id   = Yii::$app->user->id;
        $user = Manager::find()
            ->where(['id' => $id])
            ->with('assignment')
            ->asArray()
            ->one();

        return $this->renderPartial('@basics/backend/views/main/index', [
            'user'  => $user,
        ]);
    }

    /**
     * 系统首页.
     */
    public function actionSystem()
    {
        return $this->render('system', [

        ]);
    }
}
