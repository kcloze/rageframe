<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use yii\db\Migration;

class m180209_052957_api_log extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');

        /* 创建表 */
        $this->createTable('{{%api_log}}', [
            'id'        => 'int(11) NOT NULL AUTO_INCREMENT',
            'method'    => 'varchar(20) NULL DEFAULT \'\' COMMENT \'提交类型\'',
            'url'       => 'varchar(100) NULL DEFAULT \'\' COMMENT \'提交url\'',
            'get_data'  => 'text NULL COMMENT \'get数据\'',
            'post_data' => 'longtext NULL COMMENT \'post数据\'',
            'ip'        => 'varchar(16) NULL DEFAULT \'\' COMMENT \'ip地址\'',
            'append'    => 'int(10) NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'PRIMARY KEY (`id`)',
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='api_接口日志'");

        /* 索引设置 */

        /* 表数据 */

        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%api_log}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
