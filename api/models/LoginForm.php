<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace api\models;

use common\models\member\Member;

/**
 * Login form.
 */
class LoginForm extends \common\models\base\LoginForm
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'   => '登录帐号',
            'password'   => '登录密码',
        ];
    }

    /**
     * 用户登陆.
     *
     * @return mixed|null|static
     */
    public function getUser()
    {
        if (false == $this->_user) {
            // email 登录
            if (strpos($this->username, '@')) {
                $this->_user = Member::findOne(['email' => $this->username]);
            } else {
                $this->_user = Member::findByUsername($this->username);
            }
        }

        return $this->_user;
    }
}
