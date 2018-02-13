<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace backend\widgets\webuploader;

use backend\widgets\webuploader\assets\ImageAsset;
use backend\widgets\webuploader\assets\WebuploaderAsset;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;

/**
 * 图片上传.
 *
 * Class Image
 */
class Image extends InputWidget
{
    /**
     * 基础属性.
     *
     * @var array
     */
    public $options = [];

    /**
     * 更多属性.
     *
     * @var array
     */
    public $pluginOptions = [];

    /**
     * 盒子ID.
     *
     * @var
     */
    public $boxId;

    /**
     * 默认名称.
     *
     * @var string
     */
    public $name = 'fileinput';

    /**
     * @var string
     */
    public $value = '';

    /**
     * 隐藏按钮.
     */
    protected $hiddenInput;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $_options = [
            'multiple'      => true,
            'mimeTypes'     => 'image/*',
            'extensions'    => 'gif,jpg,jpeg,bmp,png',
            'vueMaterial'   => false, // 无需理会，仅供素材使用
        ];

        $_pluginOptions = [
            'uploadUrl'        => !empty(Yii::$app->params['uploadDefaultImageUrl']) ? Yii::$app->params['uploadDefaultImageUrl'] : Url::to(['/file/upload-images']),
            'uploadMaxSize'    => Yii::$app->params['imagesUpload']['maxSize'],
            'previewWidth'     => '112',
            'previewHeight'    => '112',
        ];

        $this->options               = ArrayHelper::merge($_options, $this->options);
        $this->pluginOptions         = ArrayHelper::merge($_pluginOptions, $this->pluginOptions);
        $this->options['uploadType'] = 'imagesUpload';

        if ($this->hasModel()) {
            $this->hiddenInput = Html::activeHiddenInput($this->model, $this->attribute);
        } else {
            $this->hiddenInput = Html::hiddenInput($this->name, $this->value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->registerClientScript();
        $attribute = str_replace('[]', '', $this->attribute);
        $value     = trim($this->hasModel() ? Html::getAttributeValue($this->model, $attribute) : $this->value);

        $name   = $this->hasModel() ? Html::getInputName($this->model, $this->attribute) : $this->name;
        $config = [
            'boxId'       => $this->boxId,
            'name'        => $name,
            'filesize'    => $this->pluginOptions['uploadMaxSize'],
            'server'      => $this->pluginOptions['uploadUrl'],
            'mimeTypes'   => $this->options['mimeTypes'],
            'multiple'    => $this->options['multiple'],
            'extensions'  => $this->options['extensions'],
            'uploadType'  => $this->options['uploadType'],
            'vueMaterial' => $this->options['vueMaterial'],
        ];

        return $this->render('image', [
            'name'          => $this->hasModel() ? Html::getInputName($this->model, $this->attribute) : $this->name,
            'value'         => true == $this->options['multiple'] ? unserialize($value) : $value,
            'options'       => $this->options,
            'boxId'         => $this->boxId,
            'pluginOptions' => $this->pluginOptions,
            'hiddenInput'   => $this->hiddenInput,
            'config'        => json_encode($config),
        ]);
    }

    /**
     * 注册资源.
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        WebuploaderAsset::register($view);
        ImageAsset::register($view);
    }
}
