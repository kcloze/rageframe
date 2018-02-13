<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace common\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * ajax数据格式返回.
 *
 * Class ResultDataHelper
 */
class ResultDataHelper
{
    /**
     * 状态码
     *
     * @var
     */
    public $code = 404;

    /**
     * 返回的报错信息.
     *
     * @var string
     */
    public $message = '未知错误';

    /**
     * 返回的数据结构.
     *
     * @var array|object|string
     */
    public $data = [];

    /**
     * 直接返回数据格式.
     *
     * @param int          $code    状态码
     * @param string       $message 返回的报错信息
     * @param array|object $data    返回的数据结构
     */
    public static function result($code = 404, $message = '未知错误', $data = [])
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = [
            'code'    => (string) $code,
            'message' => trim($message),
            'data'    => $data ? ArrayHelper::toArray($data) : [],
        ];

        return $result;
    }
}
