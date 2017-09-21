<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "site".
 *
 * @property string $url
 * @property string $text
 *
 */
class SiteForm extends Model
{
    public $url;
    public $text;

    public function rules()
    {
        return [
            [['url','text'],'required'],
            [['url'],'match','pattern' => '/[http|https]:\/\/.+/i'],
            [[ 'text'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'url' => 'Url',
            'text' => 'Text',
        ];
    }

}
