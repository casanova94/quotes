<?php

namespace app\controllers;

use Yii;
use app\models\QuotationTemplates;
use app\models\QuotationTemplatesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * QuotationTemplatesController implements the CRUD actions for QuotationTemplates model.
 */
class QuotationTemplatesController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all QuotationTemplates models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new QuotationTemplatesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single QuotationTemplates model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new QuotationTemplates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new QuotationTemplates();

        if ($model->load(Yii::$app->request->post())) {
            $model->logoFile = UploadedFile::getInstance($model, 'logoFile');
            if ($model->logoFile && $model->uploadLogo() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing QuotationTemplates model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->logoFile = UploadedFile::getInstance($model, 'logoFile');
            if ($model->logoFile && $model->uploadLogo() && $model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            if (!$model->logoFile && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing QuotationTemplates model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Deletes the logo of an existing QuotationTemplates model.
     * @param int $id ID
     * @return bool
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteLogo($id)
    {
        $model = $this->findModel($id);
        if ($model && $model->logo_url && file_exists($model->logo_url)) {
            unlink($model->logo_url); // Eliminar el archivo del servidor
            $model->logo_url = null;
            $model->save(false);
        }
        return true;
    }

    /**
     * Finds the QuotationTemplates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return QuotationTemplates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = QuotationTemplates::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
