<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace common\controllers;

use common\models\base\ApiLog;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * Class ActiveController.
 */
class ActiveController extends \yii\rest\ActiveController
{
    /**
     * 行为验证
     *
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // 跨域支持
        $behaviors['class']         = Cors::className();
        $behaviors['authenticator'] = [
            'class'       => CompositeAuth::className(),
            'authMethods' => [
                /* 下面是三种验证access_token方式 */
                // 1.HTTP 基本认证: access token 当作用户名发送，应用在access token可安全存在API使用端的场景，例如，API使用端是运行在一台服务器上的程序。
                // HttpBasicAuth::className(),
                // 2.OAuth : 使用者从认证服务器上获取基于OAuth2协议的access token，然后通过 HTTP Bearer Tokens 发送到API 服务器。
                // HttpBearerAuth::className(),
                // 3.请求参数: access token 当作API URL请求参数发送，这种方式应主要用于JSONP请求，因为它不能使用HTTP头来发送access token
                // http://rageframe.com/user/index/index?accessToken=123
                [
                    'class'      => QueryParamAuth::className(),
                    'tokenParam' => 'accessToken',
                ],
            ],
            // 不进行认证登录
            'optional' => Yii::$app->params['user.optional'],
        ];

        /*
         * limit部分，速度的设置是在User::getRateLimit($request, $action)
         * 当速率限制被激活，默认情况下每个响应将包含以下HTTP头发送 目前的速率限制信息：
         * X-Rate-Limit-Limit: 同一个时间段所允许的请求的最大数目;
         * X-Rate-Limit-Remaining: 在当前时间段内剩余的请求的数量;
         * X-Rate-Limit-Reset: 为了得到最大请求数所等待的秒数。
         * 你可以禁用这些头信息通过配置 yii\filters\RateLimiter::enableRateLimitHeaders 为false, 就像在上面的代码示例所示。
         */
        $behaviors['rateLimiter']['enableRateLimitHeaders'] = false;
        // 定义返回格式是：JSON
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;

        return $behaviors;
    }

    /**
     * 前置操作验证token有效期和记录日志.
     *
     * @param $action
     *
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     *
     * @return bool
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);

        // 判断验证token有效性是否开启
        if (true == Yii::$app->params['user.accessTokenValidity']) {
            $token     = Yii::$app->request->get('accessToken');
            $timestamp = (int) substr($token, strrpos($token, '_') + 1);
            $expire    = Yii::$app->params['user.accessTokenExpire'];

            // 验证有效期
            if ($timestamp + $expire <= time() && !in_array($action->id, Yii::$app->params['user.optional'], true)) {
                throw new BadRequestHttpException('请重新登陆');
            }
        }

        // 记录日志
        if (true == Yii::$app->params['debug']) {
            $model            = new ApiLog();
            $model->url       = Yii::$app->request->getUrl();
            $model->get_data  = json_encode(Yii::$app->request->get());
            $model->post_data = json_encode(Yii::$app->request->post());
            $model->method    = Yii::$app->request->method;
            $model->ip        = Yii::$app->request->userIP;
            $model->append    = time();
            $model->save();
        }

        return true;
    }

    /**
     * 返回错误状态码
     *
     * 默认 数据验证失败
     *
     * @param string $message 消息内容
     * @param int    $code    状态码
     */
    public function setResponse($message, $code = 422)
    {
        $this->response = Yii::$app->getResponse();
        $this->response->setStatusCode($code, $message);
    }

    /**
     * 解析Yii2错误信息.
     *
     * @param $errors
     *
     * @return string
     */
    protected function analysisError($errors)
    {
        $errors = array_values($errors)[0];

        return $errors ?? '操作失败';
    }

    /**
     * 打印调试.
     *
     * @param $array
     */
    protected function p($array)
    {
        echo '<pre>';
        print_r($array);
    }
}
