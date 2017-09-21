<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Site;
use app\models\SiteForm;

class ParserController extends Controller
{
    private function Create($url, $result, $text, $tag)
    {
        $site = new Site();
        $site->user_id = Yii::$app->user->getId();
        $site->url = $url;
        $site->result = $result;
        $site->text = $text;
        $site->tag = $tag;
        if ($site->save()) {
            $this->redirect('/site/admin');
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),

                'rules' => [
                    [
                        'actions' => ['url', 'delete','update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        $site =Site::find()->where(['id'=>$id])->one();
        $site->delete();
        $this->redirect('/site/admin');

    }
    public function actionUpdate()
    {
        $model = new SiteForm();
        $id = Yii::$app->request->get('id');
        $site =Site::find()->where(['id'=>$id])->one();
        return $this->render('edit',['site'=>$site,'model'=>$model]);

    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionUrl()
    {
        $site = Yii::$app->request->post('SiteForm');
        if (@fopen($site['url'], 'r')) {
            $text = str_replace('/', '\/', $site['text']);
            addslashes($text);
            $input_lines = file_get_contents($site['url']);
            $input_lines = preg_replace('#<br.*?>#s', ' ', $input_lines);
            preg_match_all('/(.*)' . $text . '/isU', $input_lines, $output_array);
            if (!empty($output_array[0][0])) {
                $lines = (string)$output_array[0][0];
                preg_match_all('/<.*>/isU', $lines, $output_array);
                $tag = array_pop($output_array[0]);
                $regex = '/' . $tag . '[^>]+?>/iU';
                preg_match_all($regex, $input_lines, $output_array);
                foreach ($output_array[0] as $arr) {
                    preg_match_all('/' . $text . '/', $arr, $output);
                    if (!empty($output[0][0])) {
                        $result = $arr;
                    }
                }
                $this->Create($site['url'],$result, $site['text'],$tag);

            } else {
                $this->Create($site['url'],'Текст не найден', $site['text'],'');
            }


        } else {
            $this->Create($site['url'],'Страница не найдена', $site['text'],'');
        }

    }
}
