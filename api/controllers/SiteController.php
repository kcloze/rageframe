<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace api\controllers;

use api\models\LoginForm;
use common\models\base\AccessToken;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * 默认登录控制器.
 *
 * Class SiteController
 */
class SiteController extends AController
{
    public $modelClass = '';

    /**
     * 登录根据用户信息返回accessToken.
     *
     * 默认是系统会员
     * 其他类型自行扩展
     *
     * @param int $group 组别 默认是1
     *
     * @throws NotFoundHttpException
     *
     * @return array
     */
    public function actionLogin($group = 1)
    {
        if (Yii::$app->request->isPost) {
            $model             = new LoginForm();
            $model->attributes = Yii::$app->request->post();
            if ($model->validate()) {
                $user = $model->getUser();

                return AccessToken::setMemberInfo($group, $user['id']);
            }

            // 返回数据验证失败
            return $this->setResponse($this->analysisError($model->getFirstErrors()));
        }

        throw new NotFoundHttpException('请求出错!');
    }

    /**
     * 重置令牌.
     *
     * @param string$refresh_token 重置token
     *
     * @throws NotFoundHttpException
     *
     * @return array
     */
    public function actionRefresh($refresh_token)
    {
        $user = AccessToken::find()
            ->where(['refresh_token' => $refresh_token])
            ->one();

        if (!$user) {
            throw new NotFoundHttpException('令牌错误，找不到用户!');
        }

        return AccessToken::setMemberInfo($user['group'], $user['user_id']);
    }

    // ....可以是设置其他用户登陆
}
