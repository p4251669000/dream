<?php

namespace app\models\system;

use Yii;

/**
 * This is the model class for table "drmenu".
 *
 * @property string $id
 * @property string $name
 * @property string $ico
 * @property string $parentid
 * @property string $url
 * @property string $createtime
 * @property integer $sort
 */
class Drmenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'drmenu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name'], 'required'],
            [['createtime'], 'safe'],
            [['sort'], 'integer'],
            [['id', 'name', 'parentid'], 'string', 'max' => 100],
            [['ico', 'url'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'ico' => 'Ico',
            'parentid' => 'Parentid',
            'url' => 'Url',
            'createtime' => 'Createtime',
            'sort' => 'Sort',
        ];
    }
}
