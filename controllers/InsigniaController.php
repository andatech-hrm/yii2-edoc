<?php

namespace andahrm\edoc\controllers;

use Yii;
use andahrm\edoc\models\Edoc;
use andahrm\edoc\models\EdocInsignia;
use andahrm\edoc\models\EdocInsigniaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * InsigniaController implements the CRUD actions for EdocInsignia model.
 */
class InsigniaController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all EdocInsignia models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new EdocInsigniaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EdocInsignia model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EdocInsignia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new EdocInsignia();
        $model->scenario = 'insert';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionCreateAjax($formAction = null) {
        //$model = new Edoc();
        $model = new EdocInsignia();
        $model->scenario = 'insert';
        //$model->scenario = 'insert-insignia';

        if (Yii::$app->request->isPost) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $success = false;
            $result = null;
            $err = [];

            $request = Yii::$app->request;
            $post = Yii::$app->request->post();

            if (Yii::$app->request->isAjax && $request->post('ajax')) {
                return ActiveForm::validate($model);
            } elseif ($request->post('save') && $model->load($post)) {
                if ($file = UploadedFile::getInstanceByName('Edoc[file]')) {
                    $model->file_name = $file->name;
                }
                $success = false;
                $result = [];

                if ($model->save()) {
                    //$result = $model->attributes;

                    $success = true;
                    $result = $model->attributes;
                } else {
                    $err[] = $model->getErrors();
                }

                return ['success' => $success, 'result' => $result];
            }
        }

        return $this->renderPartial('_form-ajax', [
                    //'model' => $model,
                    'formAction' => $formAction,
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing EdocInsignia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->edoc_id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EdocInsignia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EdocInsignia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EdocInsignia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = EdocInsignia::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('andahrm/edoc', 'The requested page does not exist.'));
    }

    public $code;

    public function actionGetList($q = null, $id = null) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; //กำหนดการแสดงผลข้อมูลแบบ json
        $out = ['results' => ['id' => '', 'text' => '']];
        $model = EdocInsignia::find();
        if (!is_null($q)) {
            $datas = explode(" ", $q);
            foreach ($datas as $data) {
                $model->orFilterWhere(['like', 'book_number', $data]);
                $model->orFilterWhere(['like', 'part_number', $data]);
                $model->orFilterWhere(['like', 'book_at', $data]);
                $model->orFilterWhere(['like', 'book_date', $data]);
                $model->orFilterWhere(['like', 'public_date', $data]);
            }
            $out['results'] = ArrayHelper::getColumn($model->all(), function($model) {
                        return ['id' => $model->id, 'text' => $model->title];
                    });
        }
        return $out;
    }

}
