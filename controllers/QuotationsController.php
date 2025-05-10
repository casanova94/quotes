<?php

namespace app\controllers;

use Yii;
use app\models\Quotations;
use app\models\QuotationsSearch;
use app\models\QuotationDetails;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * QuotationsController implements the CRUD actions for Quotations model.
 */
class QuotationsController extends Controller
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
                        'get-services' => ['GET'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Quotations models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new QuotationsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Quotations model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'details' => $this->findModel($id)->quotationDetails,
        ]);
    }

    /**
     * Creates a new Quotations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Quotations();
        $details = [];

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($model->save()) {
                        $details = Yii::$app->request->post('QuotationDetails', []);
                        foreach ($details as $detail) {
                            $quotationDetail = new QuotationDetails();
                            $quotationDetail->quotation_id = $model->id;
                            $quotationDetail->service_id = $detail['service_id'];
                            $quotationDetail->quantity = $detail['quantity'];
                            $quotationDetail->unit_price = $detail['unit_price'];
                            $quotationDetail->subtotal = $detail['quantity'] * $detail['unit_price'];
                            if (!$quotationDetail->save()) {
                                throw new \Exception('Error al guardar el detalle');
                            }
                        }
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'details' => $details,
        ]);
    }

    /**
     * Updates an existing Quotations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $details = $model->quotationDetails;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($model->save()) {
                        // Eliminar detalles existentes
                        QuotationDetails::deleteAll(['quotation_id' => $model->id]);
                        
                        // Guardar nuevos detalles
                        $details = Yii::$app->request->post('QuotationDetails', []);
                        foreach ($details as $detail) {
                            $quotationDetail = new QuotationDetails();
                            $quotationDetail->quotation_id = $model->id;
                            $quotationDetail->service_id = $detail['service_id'];
                            $quotationDetail->quantity = $detail['quantity'];
                            $quotationDetail->unit_price = $detail['unit_price'];
                            $quotationDetail->subtotal = $detail['quantity'] * $detail['unit_price'];
                            if (!$quotationDetail->save()) {
                                throw new \Exception('Error al guardar el detalle');
                            }
                        }
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'details' => $details,
        ]);
    }

    /**
     * Deletes an existing Quotations model.
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
     * Finds the Quotations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Quotations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quotations::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La cotización solicitada no existe.');
    }

    /**
     * Obtiene los servicios disponibles para un tipo de cotización específico.
     * @return array
     */
    public function actionGetServices()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $quotationTypeId = Yii::$app->request->get('quotation_type_id');
        
        $services = \app\models\Services::find()
            ->where(['quotation_type_id' => $quotationTypeId])
            ->asArray()
            ->all();
            
        $result = [];
        foreach ($services as $service) {
            $result[$service['id']] = $service['name'];
        }
        
        return $result;
    }

    /**
     * Obtiene el precio de un servicio específico.
     * @return array
     */
    public function actionGetServicePrice()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $serviceId = Yii::$app->request->get('service_id');
        $service = \app\models\Services::findOne($serviceId);

        if ($service) {
            return [
                'success' => true,
                'price' => $service->price,
            ];
        }

        return [
            'success' => false,
            'message' => 'Servicio no encontrado.',
        ];
    }
}
