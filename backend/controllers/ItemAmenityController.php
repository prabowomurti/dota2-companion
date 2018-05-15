<?php

namespace backend\controllers;

use Yii;
use common\models\ItemAmenity;
use common\models\search\ItemAmenitySearch;
use common\components\corecontrollers\ZeedController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemAmenityController implements the CRUD actions for ItemAmenity model.
 */
class ItemAmenityController extends ZeedController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ItemAmenity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemAmenitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ItemAmenity model.
     * @param integer $item_id
     * @param integer $amenity_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($item_id, $amenity_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($item_id, $amenity_id),
        ]);
    }

    /**
     * Creates a new ItemAmenity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ItemAmenity();

        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                if ( ! Yii::$app->request->isAjax)
                    return $this->redirect(['view', 'item_id' => $model->item_id, 'amenity_id' => $model->amenity_id]);
                else 
                    return 'Added';
            }
            else 
                throw new NotFoundHttpException($model->getErrorSummary(false)[0]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ItemAmenity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $item_id
     * @param integer $amenity_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($item_id, $amenity_id)
    {
        $model = $this->findModel($item_id, $amenity_id);

        if (Yii::$app->request->isAjax)
        {
            if ($model->load(Yii::$app->request->post()) && $model->save())
                return 'Updated';
            else 
                throw new NotFoundHttpException($model->getErrorSummary(false)[0]);
        }
        else 
        {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'item_id' => $model->item_id, 'amenity_id' => $model->amenity_id]);
            }
            
            return $this->render('update', [
                'model' => $model,
            ]);
        }


    }

    /**
     * Deletes an existing ItemAmenity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $item_id
     * @param integer $amenity_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($item_id, $amenity_id)
    {
        $this->findModel($item_id, $amenity_id)->delete();

        if (Yii::$app->request->isAjax)
            return 'Deleted';
        else 
            return $this->redirect(['index']);
    }

    /**
     * Finds the ItemAmenity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $item_id
     * @param integer $amenity_id
     * @return ItemAmenity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($item_id, $amenity_id)
    {
        if (($model = ItemAmenity::findOne(['item_id' => $item_id, 'amenity_id' => $amenity_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
