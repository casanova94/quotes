<?php

namespace app\controllers;

use Yii;
use app\models\Technicians;
use app\models\TechniciansSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\helpers\UserHelper;

/**
 * TechniciansController implements the CRUD actions for Technicians model.
 */
class TechniciansController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                        'reset-password' => ['GET', 'POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Technicians models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TechniciansSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Technicians model.
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
     * Creates a new Technicians model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Technicians();
        $model->scenario = Technicians::SCENARIO_CREATE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Técnico creado exitosamente.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Technicians model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Technicians::SCENARIO_UPDATE;
        
        // Cargar el nombre de usuario del técnico
        if ($model->user) {
            $model->username = $model->user->username;
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Técnico actualizado exitosamente.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Updates the password of a Technicians model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdatePassword($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Technicians::SCENARIO_UPDATE_PASSWORD;

        if ($model->load(Yii::$app->request->post()) && $model->updatePassword()) {
            Yii::$app->session->setFlash('success', 'Contraseña actualizada exitosamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update-password', [
            'model' => $model,
        ]);
    }

    /**
     * Resets the password of a Technicians model.
     * If reset is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionResetPassword($id)
    {
        if (!UserHelper::isAdmin()) {
            throw new \yii\web\ForbiddenHttpException('No tiene permiso para realizar esta acción.');
        }

        $model = $this->findModel($id);
        $model->scenario = Technicians::SCENARIO_RESET_PASSWORD;

        if ($model->load(Yii::$app->request->post()) && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Contraseña reseteada exitosamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('reset-password', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Technicians model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!UserHelper::isAdmin()) {
            throw new \yii\web\ForbiddenHttpException('No tiene permiso para realizar esta acción.');
        }

        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Técnico eliminado exitosamente.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Technicians model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Technicians the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Technicians::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('El técnico solicitado no existe.');
    }
}
