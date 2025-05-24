<?php

namespace app\controllers;

use app\models\SiteInspectionReports;
use app\models\SiteInspectionReportsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\SiteInspectionObservations;
use Yii;
use yii\filters\AccessControl;

/**
 * SiteInspectionReportsController implements the CRUD actions for SiteInspectionReports model.
 */
class SiteInspectionReportsController extends Controller
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
                        [
                            'allow' => true,
                            'actions' => ['delete'],
                            'roles' => ['admin'],
                        ],
                    ],
                ],
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
     * Lists all SiteInspectionReports models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SiteInspectionReportsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SiteInspectionReports model.
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
     * Creates a new SiteInspectionReports model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SiteInspectionReports();
        $observations = [new SiteInspectionObservations()];

        // Si se proporciona un service_order_id, establecerlo en el modelo
        if ($service_order_id = Yii::$app->request->get('service_order_id')) {
            $model->service_order_id = $service_order_id;
        }

        // Filtrar técnicos si el usuario es técnico
        $technicianQuery = \app\models\Technicians::find();
        if (Yii::$app->user->identity->isTechnician()) {
            $technicianQuery->where(['id' => Yii::$app->user->identity->technician->id]);
        }

        if ($model->load(Yii::$app->request->post())) {
            $observations = SiteInspectionObservations::createMultiple(Yii::$app->request->post('SiteInspectionObservations'));

            if ($model->save()) {
                foreach ($observations as $observation) {
                    $observation->inspection_report_id = $model->id;
                    $observation->save();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'observations' => $observations,
            'technicians' => $technicianQuery->all(),
        ]);
    }

    /**
     * Updates an existing SiteInspectionReports model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $existingObservations = $model->observations; // Obtener observaciones existentes

        // Filtrar técnicos si el usuario es técnico
        $technicianQuery = \app\models\Technicians::find();
        if (Yii::$app->user->identity->isTechnician()) {
            $technicianQuery->where(['id' => Yii::$app->user->identity->technician->id]);
        }

        if ($model->load(Yii::$app->request->post())) {
            // Cargar las observaciones enviadas desde el formulario
            $postedObservations = Yii::$app->request->post('SiteInspectionObservations', []);
            $observations = [];

            foreach ($postedObservations as $index => $postedObservation) {
                if (!empty($postedObservation['id'])) {
                    // Si la observación tiene un ID, es una observación existente
                    $observation = SiteInspectionObservations::findOne($postedObservation['id']);
                    if ($observation) {
                        $observation->load(['SiteInspectionObservations' => $postedObservation]);
                    }
                } else {
                    // Si no tiene ID, es una nueva observación
                    $observation = new SiteInspectionObservations();
                    $observation->load(['SiteInspectionObservations' => $postedObservation]);
                }
                $observations[] = $observation;
            }

            if ($model->save()) {
                // Guardar las observaciones
                foreach ($observations as $observation) {
                    $observation->inspection_report_id = $model->id;
                    $observation->save();
                }

                // Eliminar observaciones que no están en el formulario
                $existingIds = array_column($existingObservations, 'id');
                $postedIds = array_column($postedObservations, 'id');
                $toDelete = array_diff($existingIds, $postedIds);

                if (!empty($toDelete)) {
                    SiteInspectionObservations::deleteAll(['id' => $toDelete]);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'observations' => $existingObservations,
            'technicians' => $technicianQuery->all(),
        ]);
    }

    /**
     * Deletes an existing SiteInspectionReports model.
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
     * Finds the SiteInspectionReports model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SiteInspectionReports the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SiteInspectionReports::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
