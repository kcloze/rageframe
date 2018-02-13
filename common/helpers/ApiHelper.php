<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace common\helpers;

use linslin\yii2\curl\Curl;

/**
 * api接口帮助类
 * Class ApiHelper.
 */
class ApiHelper
{
    /**
     * 新浪IP转地址接口.
     */
    const IP_SINA = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=';

    /**
     * 解析ip地址
     *
     * @param $ip
     *
     * @return bool|mixed
     */
    public static function ipInfoSina($ip)
    {
        $curl     = new Curl();
        $response = $curl->get(self::IP_SINA . $ip);

        // 判断是否查询的到ip信息
        if (empty($response)) {
            return false;
        }

        $jsonMatches = [];
        preg_match('#\{.+?\}#', $response, $jsonMatches);
        if (!isset($jsonMatches[0])) {
            return false;
        }

        $json = json_decode($jsonMatches[0], true);
        if (isset($json['ret']) && 1 == $json['ret']) {
            $json['ip'] = $ip;
            unset($json['ret']);
        } else {
            return false;
        }

        return $json;
    }
}
