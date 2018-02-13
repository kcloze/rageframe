<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace console\controllers;

use jianyan\basics\common\models\wechat\MsgHistory;
use jianyan\basics\common\models\wechat\Setting;
use yii\console\Controller;

/**
 * Class MsgHistory.
 */
class MsgHistoryController extends Controller
{
    /**
     * 清理过期的历史记录.
     */
    public function actionIndex()
    {
        $model = Setting::find()->one();
        if ($model && !empty($model->history)) {
            $history = unserialize($model->history);
            if ($history['msg_history_date']['value'] > 0) {
                $one_day = 60 * 60 * 24;
                $time    = time() - $one_day * $history['msg_history_date']['value'];
                MsgHistory::deleteAll(['<=', 'append', $time]);

                echo date('Y-m-d H:i:s') . ' --- ' . '清理成功;';
                exit();
            }
        }

        echo date('Y-m-d H:i:s') . ' --- ' . '数据设置未清除;';
        exit();
    }
}
