<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace backend\widgets\provinces;

use yii\base\Widget;

/**
 * Class Provinces.
 */
class Provinces extends Widget
{
    /**
     * 省
     *
     * @var
     */
    public $provincesName;

    /**
     * 市
     *
     * @var
     */
    public $cityName;

    /**
     * 区.
     *
     * @var
     */
    public $areaName;

    /**
     * 模型.
     *
     * @var array
     */
    public $model;

    /**
     * 表单.
     *
     * @var
     */
    public $form;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        !$this->provincesName && $this->provincesName = 'provinces';
        !$this->cityName && $this->cityName           = 'city';
        !$this->areaName && $this->areaName           = 'area';
    }

    public function run()
    {
        return $this->render('index', [
            'form'          => $this->form,
            'model'         => $this->model,
            'provincesName' => $this->provincesName,
            'cityName'      => $this->cityName,
            'areaName'      => $this->areaName,
        ]);
    }
}
