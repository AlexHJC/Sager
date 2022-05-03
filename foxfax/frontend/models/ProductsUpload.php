<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ProductsUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $csvFile;
    public $csvPath;

    public function rules()
    {
        return [
            [['csvFile'], 'required'],
            [
                ['csvFile'],
                'file',
                'extensions'               => 'csv, xla, xlsx, xlam, xlc, xlm, xls, xlt, xltm, xlw',
                'skipOnEmpty'              => false,
                'checkExtensionByMimeType' => false,
                'maxSize'                  => 1024 * 1024 * 5
            ]
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $rename = date('Ymd_Hi') . '_' . Yii::$app->user->identity->id . '_' . $this->csvFile->baseName . '.' . $this->csvFile->extension;
            $sPath = Yii::$app->basePath . '/uploads/products/' . $rename;
            $this->csvFile->saveAs($sPath);
            $this->csvPath = $sPath;
            return true;
        } else {
            return false;
        }
    }

    public function getUploadedFilePath()
    {
        return $this->csvPath;
    }
}
