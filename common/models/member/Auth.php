<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace common\models\member;

/**
 * This is the model class for table "{{%member_user_auth}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $source
 * @property string $source_id
 */
class Auth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%member_auth}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['member_id'], 'integer'],
            [['source', 'source_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'member_id' => '用户id',
            'source'    => '来源',
            'source_id' => '来源id',
        ];
    }

    /**
     * 关联用户.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(Member::className(), ['id'=>'member_id']);
    }
}
