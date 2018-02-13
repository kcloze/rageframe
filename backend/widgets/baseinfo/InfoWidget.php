<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace backend\widgets\baseinfo;

use jianyan\basics\common\models\sys\ActionLog;
use jianyan\basics\common\models\sys\Manager;
use yii\base\Widget;

class InfoWidget extends Widget
{
    public function run()
    {
        return $this->render('index', [
            'managerCount'      => Manager::find()->count(),
            'logCount'          => ActionLog::find()->count(),
            'managerVisitor'    => Manager::find()->sum('visit_count'),
        ]);
    }
}
