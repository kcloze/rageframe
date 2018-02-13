<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace api\controllers;

use common\controllers\ActiveController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * 基类控制器.
 *
 * Class AController
 */
class AController extends ActiveController
{
    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        // 自定义数据indexDataProvider覆盖IndexAction中的prepareDataProvider()方法
        // $actions['index']['prepareDataProvider'] = [$this, 'indexDataProvider'];
        return $actions;
    }

    /**
     * 首页.
     *
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
        $modelClass = $this->modelClass;
        $query      = $modelClass::find();

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    /**
     * 创建.
     *
     * @return bool
     */
    public function actionCreate()
    {
        $model             = new $this->modelClass();
        $model->attributes = Yii::$app->request->post();
        if (!$model->save()) {
            // 返回数据验证失败
            return $this->setResponse($this->analysisError($model->getFirstErrors()));
        }

        return $model;
    }

    /**
     * 更新.
     *
     * @param $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model             = $this->findModel($id);
        $model->attributes = Yii::$app->request->post();
        if (!$model->save()) {
            // 返回数据验证失败
            return $this->setResponse($this->analysisError($model->getFirstErrors()));
        }

        return $model;
    }

    /**
     * 删除.
     *
     * @param $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        return $this->findModel($id)->delete();
    }

    /**
     * 显示单个.
     *
     * @param $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    /**
     * 返回模型.
     *
     * @param $id
     *
     * @throws NotFoundHttpException
     *
     * @return mixed
     */
    protected function findModel($id)
    {
        if (empty($id)) {
            throw new NotFoundHttpException('请求的数据失败.');
        }

        $modelClass = $this->modelClass;
        if ($model = $modelClass::findOne($id)) {
            return $model->loadDefaultValues();
        }

        throw new NotFoundHttpException('请求的数据失败.');
    }
}
