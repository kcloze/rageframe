<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) kcloze <pei.greet@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace backend\modules\member\controllers;

use common\models\member\Member;
use yii;
use yii\data\Pagination;

/**
 * 用户控制器.
 *
 * Class MemberController
 */
class MemberController extends UController
{
    /**
     * 首页.
     */
    public function actionIndex()
    {
        $request  = Yii::$app->request;
        $type     = $request->get('type', 1);
        $keyword  = $request->get('keyword', '');

        switch ($type) {
            case '1':
                $where = ['like', 'username', $keyword];
                break;
            case '2':
                $where = ['like', 'realname', $keyword];
                break;
            case '3':
                $where = ['like', 'mobile_phone', $keyword];
                break;
            default:
                $where = [];
                break;
        }

        // 关联角色查询
        $data   = Member::find()->where($where);
        $pages  = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>$this->_pageSize]);
        $models = $data->offset($pages->offset)
           ->orderBy('type desc,created_at desc')
           ->limit($pages->limit)
           ->all();

        return $this->render('index', [
           'models'  => $models,
           'pages'   => $pages,
           'type'    => $type,
           'keyword' => $keyword,
       ]);
    }

    /**
     * 编辑/新增.
     *
     * @return string|\yii\web\Response
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $id       = $request->get('id');
        $model    = $this->findModel($id);

        $pass     = $model->password_hash; // 原密码
        if ($model->load(Yii::$app->request->post())) {
            // 验证密码是否修改
            if ($model->password_hash != $pass) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            }

            // 提交创建
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
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
        if ($this->findModel($id)->delete()) {
            return $this->message('删除成功', $this->redirect(['index']));
        }

        return $this->message('删除失败', $this->redirect(['index']), 'error');
    }

    /**
     * 修改个人资料.
     *
     * @return string|yii\web\Response
     */
    public function actionPersonal()
    {
        $request  = Yii::$app->request;
        $id       = $request->get('id');
        $model    = $this->findModel($id);

        // 提交表单
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('personal', [
            'model' => $model,
        ]);
    }

    /**
     * 返回模型.
     *
     * @param $id
     *
     * @return Member|static
     */
    protected function findModel($id)
    {
        if (empty($id)) {
            return new Member();
        }

        if (empty(($model = Member::findOne($id)))) {
            return new Member();
        }

        return $model;
    }
}
