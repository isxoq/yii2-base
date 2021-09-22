<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

$isCrudController = ($generator->baseControllerClass == 'soft\web\AjaxCrudController' || $generator->baseControllerClass == 'soft\web\CrudController');

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{

    /**
    * {@inheritdoc}
    */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'bulk-delete' => ['POST'],
                ],
            ],
            /*'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ]*/
        ];
    }

    /**
    * Lists all <?= $modelClass ?> models.
    * @return mixed
    */
    public function actionIndex()
    {
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }

    /**
    * Displays a single <?= $modelClass ?> model.
    * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
    * @return string
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionView(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);
        return $this->ajaxCrud->viewAction($model);
    }

    /**
    * Creates a new <?= $modelClass ?> model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return string
    */
    public function actionCreate()
    {
        $model = new <?= $modelClass ?>();
        return $this->ajaxCrud->createAction($model);
    }

    /**
    * Updates an existing <?= $modelClass ?> model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
    * @return string
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionUpdate(<?= $actionParams ?>)
    {
        $model = $this->findModel($id);
        return $this->ajaxCrud->updateAction($model);
    }

    /**
    * Deletes an existing <?= $modelClass ?> model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->ajaxCrud->closeModalResponse();
    }

    /**
    * Delete multiple existing <?= $modelClass ?> model.
    * For ajax request will return json object
    * and for non-ajax request if deletion is successful,
    * the browser will be redirected to the 'index' page.
    * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
    * @return mixed
    */
    public function actionBulkdelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }
        return $this->ajaxCrud->closeModalResponse();
    }

    /**
    * Finds a single model for crud actions
    * @param $id
    * @return <?= $modelClass ."\n"?>
    * @throws yii\web\NotFoundHttpException
    */
    public function findModel($id)
    {
        $model = <?= $modelClass ?>::find()->andWhere(['id' => $id])->one();
        if ($model == null){
            not_found();
        }
        return $model;
    }
}
