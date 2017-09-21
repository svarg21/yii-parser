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

class ParserController extends Controller
{
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
                        'actions' => ['url'],
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionUrl()
    {
        $site = Yii::$app->request->post('SiteForm');
        $input_lines = file_get_contents($site['url']);
        $input_lines = preg_replace('#<br.*?>#s',' ',$input_lines);
//        var_dump($input_lines);
        preg_match_all('/(.*)'.$site['text'].'/isU', $input_lines, $output_array);
//        var_dump($output_array);
        $input_lines = (string)$output_array[0][0];
        preg_match_all('/<.*>/isU', $input_lines, $output_array);
        $tag = array_pop($output_array[0]);
/*        $regex ='/'.$tag.'[^>]+?>/iU';*/
//        var_dump($regex);
//        preg_match_all($regex, $input_lines, $output_array);
//        var_dump($output_array);
            $url = new Site();
            $url->user_id = Yii::$app->user->getId();
            $url->url = $site['url'];
            $url->text = $site['text'];
            $url->tag = $tag;
            if ($url->save()) {
                $this->redirect('/site/admin');
            }
        $this->redirect('/site/admin');
//            return 0;

    }
}
