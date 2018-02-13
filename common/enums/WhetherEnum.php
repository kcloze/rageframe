<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace common\enums;

/**
 * Class WhetherEnum.
 */
class WhetherEnum
{
    const ENABLED  = 1;
    const DISABLED = 0;

    /**
     * @var array
     */
    public static $list = [
        self::ENABLED  => '是',
        self::DISABLED => '否',
    ];
}
