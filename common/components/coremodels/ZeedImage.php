<?php

namespace common\components\coremodels;

use Yii;
use yii\base\NotSupportedException;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

use common\models\Item;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property string $filename
 * @property string $type
 * @property integer $status
 * @property integer $position
 */
class ZeedImage extends GilkorActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $imageFiles;

    /**
     * Valid table name files
     * @var array
     */
    protected $validTypes = ['items', 'heroes'];

    const UPLOAD_FOLDER = 'uploads';
    const DEFAULT_IMAGE_FILENAME = 'default.png';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filename'], 'required'],
            [['status', 'position'], 'integer'],
            [['filename', 'type'], 'string', 'max' => 255],
            [['imageFile'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 2 * 1024000],
            [['imageFiles'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('app', 'ID'),
            'filename' => Yii::t('app', 'Filename'),
            'type'     => Yii::t('app', 'Type'),
            'status'   => Yii::t('app', 'Status'),
            'position' => Yii::t('app', 'Position'),
        ];
    }

    /**
     * Upload new image 
     * @param  object $model related model
     * @param  string $attribute model's field name
     * @param  boolean $replace if true, will override existing image
     * @return boolean whether the process is success
     */
    public static function upload(&$model = null, $attribute = 'imageFile', $replace = false)
    {
        if (empty($model))
            return false;

        $uploaded_file = UploadedFile::getInstance($model, $attribute);

        if (empty($uploaded_file))
            return true; // do nothing

        // do the validation for model's image here
        $model->$attribute = $uploaded_file;
        if ( ! $model->validate([$attribute]))
            return false;

        // new image
        if ( ! $replace)
        {
            $image = new static();
            $image->type = $model::tableName();
            $image->imageFile = $uploaded_file;
            $image->filename = self::generateFilename($image->imageFile->extension);

            if ( ! $image->save())
            {
                $model->addError($attribute, Yii::t('app', 'Can not save the image model'));
                return false;
            }

            $model->link('image', $image);
        }
        else // replace existing image
        {
            // TODO : if the previous image is not found, save the image as a new one
            $image = $model->image;

            if (empty($image))
                $image = new static();
            else 
            {
                if ( ! $image->delete())
                {
                    $model->addError($attribute, Yii::t('app', 'Can not delete previous image'));
                    return false;
                }
            }

            $image->type      = $model::tableName();
            $image->imageFile = $uploaded_file;
            $image->filename  = self::generateFilename($image->imageFile->extension);

            if ( ! $image->save())
            {
                $model->addError($attribute, Yii::t('app', 'Previous image is already deleted, but failed to save the image model'));
                return false;
            }

            $model->link('image', $image);
        }
        
        if ( ! $image->saveFile())
        {
            $image->delete();
            $model->addError($attribute, Yii::t('app', 'Failed to save the new image file'));
            return false;
        }

        return true;
    }

    /**
     * Upload multiple files
     * @param  object  &$model    
     * @param  string $attribute model's field name
     * @param  boolean $replace if true, will override existing image
     * @return boolean success or not
     */
    public static function uploadMultipleFiles(&$model = null, $attribute = 'imageFiles', $replace = false)
    {
        if (empty($model))
            return false;

        $uploaded_files = UploadedFile::getInstances($model, $attribute);

        if (empty($uploaded_files))
            return true; // do nothing

        // do the validation for model's image here
        $model->$attribute = $uploaded_files;
        if ( ! $model->validate([$attribute]))
            return false;

        if ($replace)
        {
            // first, delete all existing images
            foreach ($model->images as $image)
            {
                $image->delete();// the file is also deleted
            }

        }

        $image_type = $model::tableName();
        foreach ($uploaded_files as $key => $uploaded_file)
        {
            $image = new static;
            $image->type = $image_type;
            $image->imageFile = $uploaded_file;
            $image->filename = self::generateFilename($image->imageFile->extension);

            if ( ! $image->save())
            {
                $model->addError($attribute, Yii::t('app', 'Can not save the image model, index : ' . $key));
                return false;
            }

            if ( ! $image->saveFile())
            {
                $image->delete();
                $model->addError($attribute, Yii::t('app', 'Failed to save the new image file, index : ' . $key));
                return false;
            }

            $model->link('image', $image);
        }
        
        return true;
    }

    /**
     * Save file to the path
     * @return boolean 
     */
    protected function saveFile()
    {
        //validating type
        if ( ! in_array($this->type, $this->validTypes))
            return false;

        // check if directory already exists and writeable
        if ( ! is_dir(self::getSavePath($this->type)))
            return false;

        if ( ! is_writable(self::getSavePath($this->type)))
            return false;

        return $this->imageFile->saveAs($this->imagePath());

    }

    /**
     * Default image URL for the related model
     * @return string
     */
    public static function defaultImageUrl()
    {
        return implode(DIRECTORY_SEPARATOR, [Yii::$app->urlManagerFrontend->baseUrl, self::UPLOAD_FOLDER, self::DEFAULT_IMAGE_FILENAME]);
    }

    /**
     * Link to the image URL
     * @return string 
     */
    public function imageUrl()
    {
        return implode(DIRECTORY_SEPARATOR, [Yii::$app->urlManagerFrontend->baseUrl, self::UPLOAD_FOLDER, $this->type, $this->filename]);
    }

    /**
     * Image's file path
     * @return string 
     */
    protected function imagePath()
    {
        return self::getSavePath($this->type) . DIRECTORY_SEPARATOR . $this->filename;
    }

    /**
     * Delete current image's file
     * @return boolean
     */
    protected function deleteFile()
    {
        if (file_exists($this->imagePath()))
            return unlink($this->imagePath());

        return false;
    }

    /**
     * Get saving path for the model's image
     * @param  string $type type of model (fetched from the table's name)
     * @return string saving path for the image file
     */
    protected static function getSavePath($type = '')
    {
        return implode(DIRECTORY_SEPARATOR, [Yii::getAlias('@frontend'), 'web', self::UPLOAD_FOLDER, $type]);
    }

    /**
     * Generate filename field, and put the original extension at the end of filename
     * @param  string $extension extension of the image
     * @return string generated filename
     */
    protected static function generateFilename($extension = '.png')
    {
        $filename = Yii::$app->security->generateRandomString() . '.' . $extension;

        while (self::findOne(['filename' => $filename]))
            $filename = Yii::$app->security->generateRandomString() . '.' . $extension;

        return $filename;
    }

    /**
     * Delete file when deleting the image on DB
     * @return boolean 
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete())
            return $this->deleteFile();
        else 
            return false;
    }
    
}