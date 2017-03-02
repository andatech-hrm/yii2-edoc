<?php

namespace andahrm\edoc\controllers;

use Yii;
use andahrm\edoc\models\Edoc;
use andahrm\edoc\models\EdocSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * DefaultController implements the CRUD actions for Edoc model.
 */
class DefaultController extends Controller
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
     * Lists all Edoc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EdocSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Edoc model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Edoc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Edoc();
        $model->scenario = 'insert';
        if ($model->load(Yii::$app->request->post())){
            if($file = UploadedFile::getInstanceByName('Edoc[file]')){
              $model->file_name = $file->name;
            }
            if($model->save()) {
              return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Edoc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateAjax($formAction = null)
    {
        $model = new Edoc();
        $model->scenario = 'insert';
        
        if(Yii::$app->request->isPost){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            $success = false;
            $result=null;
            if ($model->load(Yii::$app->request->post())){
                if($file = UploadedFile::getInstanceByName('Edoc[file]')){
                    $model->file_name = $file->name;
                }
                $success = false;
                $result = [];
                if($model->save()) {
                    $success = true;
                    $result = $model->attributes;
                }
                
            }
            return ['success' => $success, 'result' => $result];
        }
        
        return $this->renderPartial('_form', [
            'model' => $model,
            'formAction' => $formAction
        ]);
        
    }

    /**
     * Updates an existing Edoc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        if ($model->load(Yii::$app->request->post())){
            if($file = UploadedFile::getInstanceByName('Edoc[file]')){
              $model->file_name = $file->name;
//               print_r($file);
//               exit();
            }
            if($model->save()) {
              return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Edoc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Edoc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Edoc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Edoc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
  
  
     public function actionEdocList($q = null) {
        $data = Edoc::find()->where(['LIKE','code',$q])->all();
        //print_r($data);
        $out = [];
        foreach ($data as $d) {
            $out[] = [
              'id' => $d->id,
              'title' => $d->title,
              'code' => $d->code,
              'updated_at' => $d->updated_at?Yii::$app->formatter->asDate($d->updated_at):'',
              'value' => $d->code,
            ];
        }
        echo Json::encode($out);
    }
}
