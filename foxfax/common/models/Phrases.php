<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%phrases}}".
 *
 * @property integer $id
 * @property string  $category
 * @property string  $alias
 * @property string  $title_ru
 * @property string  $title_en
 * @property string  $title_ro
 * @property string  $title_fr
 * @property string  $title_de
 */
class Phrases extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%phrases}}';
    }



    public static function find()
    {
        return new PhrasesQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'alias', 'title_ru', 'title_en', 'title_ro', 'title_fr'], 'required'],
            [['title_ru', 'title_en', 'title_ro'], 'string'],
            [['category', 'alias', 'title_fr', 'title_de'], 'string', 'max' => 255],
            [['category', 'alias'], 'unique', 'targetAttribute' => ['category', 'alias'], 'message' => 'The combination of Category and Alias has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     * @return PhrasesQuery the active query used by this AR class.
     */

    /*
    protected function afterSave(){
        
        parent::afterSave();
        $documentRoot=Yii::getPathOfAlias('webroot');
        
        $labels=Labels::model()->findAll();

        foreach (Yii::app()->params['languages1'] as $key2 => $value2) {

            foreach ($labels as $key => $value) {
                
                if (!empty($value->{"title_{$value2}"})) {
                    $arr[$value2][$value->category][] = ('"'.str_replace('"', '\"', $value->alias).'" => "'.str_replace('"', '\"', $value->{"title_{$value2}"}).'"'); 
                }else{
                    $arr[$value2][$value->category][] = ('"'.str_replace('"', '\"', $value->alias).'" => "'.str_replace('"', '\"', $value->alias).'"'); 
                }

                foreach ($arr[$value2] as $key3 => $value3) {

                        $value3 = implode(',', $value3);
                        $text = "<?php
                                return array(";
                        $text .= $value3;
                        $text .= ");
                                ?>";
                        
                        $file_path = $documentRoot."/protected/messages/{$value2}/{$key3}.php";
                        $dir_path = $documentRoot."/protected/messages/{$value2}/";

                        if (!is_dir($dir_path)) {
                            mkdir($dir_path);
                        }
                        file_put_contents($file_path, $text);

                }
            }
        }
    }
    */
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('form', 'ID'),
            'category' => Yii::t('form', 'Category'),
            'alias'    => Yii::t('form', 'Alias'),
            'title_ru' => Yii::t('form', 'Title Ru'),
            'title_en' => Yii::t('form', 'Title En'),
            'title_ro' => Yii::t('form', 'Title Ro'),
            'title_fr' => Yii::t('form', 'Title Fr'),
            'title_de' => Yii::t('form', 'Title De'),
        ];
    }
}
