<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace common\enums;

/**
 * 状态枚举.
 *
 * Class StatusEnum
 */
class StatusEnum
{
    const ENABLED  = 1;
    const DISABLED = 0;
    const DELETE   = -1;

    /**
     * @var array
     */
    public static $listExplain = [
        self::ENABLED  => '显示',
        self::DISABLED => '隐藏',
        self::DELETE   => '删除',
    ];

    /**
     * 根据状态返回按钮.
     *
     * @var array
     */
    public static $listBut = [
        self::DISABLED => '<span class="btn btn-primary btn-sm" onclick="rfStatus(this)">启用</span>',
        self::ENABLED  => '<span class="btn btn-default btn-sm" onclick="rfStatus(this)">禁用</span>',
    ];
}
