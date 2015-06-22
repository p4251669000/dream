<?php

namespace app\models\system;

use Yii;

/**
 * This is the model class for table "drauthrolemenu".
 *
 * @property string $id
 * @property string $rolename
 * @property string $menuid

 */
class Drauthrolemenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'drauthrolemenu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'id','rolename','menuid'], 'required'],
            [['id', 'rolename', 'menuid'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rolename' => 'rolename',
            'menuid' => 'menuid',
        ];
    }
}
