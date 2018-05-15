<?php 

namespace common\components\widgets\junction_loader;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\base\InvalidCallException;


/**
 * Show junction gridview and CRUD
 * @author Prabowo Murti <prabowo.murti@gmail.com>
 */
class JunctionLoader extends Widget
{
    /**
     * The base model
     * @var ActiveRecord
     */
    public $model;

    /**
     * Model options
     * @var array
     */
    public $modelOptions = [];

    /**
     * Name of the attribute, refers to the table linked
     * @var string
     */
    public $attribute;

    /**
     * Whether to show the link only, used in a _form of the model.
     * // TODO : fix 
     * This is a temporary solution because we can not put a modal within the form
     * @var boolean
     */
    public $showLinkOnly = false;

    /**
     * Columns shown in the gridview
     * @var array
     */
    public $columns;

    public function init()
    {
        parent::init();
        if ($this->model === null)
            throw new InvalidCallException('Unspecified model');

        if ($this->attribute === null)
            throw new InvalidCallException('Unspecified attribute name');

    }

    public function run()
    {
        // load the JS file
        if ( ! $this->showLinkOnly)
        {
            $view = $this->getView();
            JunctionViewAsset::register($view);
        }

        $model              = $this->model; // the 'item' object
        $attribute          = $this->attribute; // 'amenities'
        
        $model_tablename    = $model::tableName(); // 'item'
        $model_titleize     = Inflector::titleize($model_tablename, true);
        $attribute_titleize = Inflector::titleize($attribute, true);

        // show a hint for new record
        if ($this->model->isNewRecord)
            return Html::activeLabel($model, $attribute) . '<br />'. 'Please create ' . $model_titleize . ' before updating the ' . $attribute_titleize;

        $model_ID = Inflector::camel2id($model::tableName()); // 'item' with '-' separator

        // show link to the a separated page
        if ($this->showLinkOnly == true)
            return Html::activeLabel($model, $attribute)
                . '<br />'
                . Html::a('Update ' . $attribute_titleize, [$model_ID . '/' . 'update-' . $attribute . '?id=' . $model->id], ['class' => 'btn btn-default btn-xs'])
                . '<br /><br />';

        $attribute_class_name = Inflector::classify(Inflector::singularize($attribute)); // 'Amenity'
        $attribute_ID = Inflector::camel2id($attribute_class_name); // 'amenity' with '-' separator
        $junction_ID = $model_ID . '-' . $attribute_ID;
        $model_class_name = Inflector::classify($model_titleize); // 'Item'
        
        $junction = $model_class_name . $attribute_class_name; // 'ItemAmenity'
        $prefix_model_path = "\\common\\models\\";
        $junction_search_classname = $prefix_model_path . "search\\" . $junction . 'Search';
        $attribute_model_full_path = $prefix_model_path . $attribute_class_name;
        $attribute_model = new $attribute_model_full_path;

        // PREPARING DATA PROVIDER and COLUMNS
        $junction_search = new $junction_search_classname(); // ItemAmenitySearch() model
        $model_primary_key = $model_tablename . '_id'; // 'item_id'
        $junction_search->$model_primary_key = $model->id;
        $dataProvider = $junction_search->search('');
        $dataProvider->sort = false; // disable sorting

        $junction_path = $prefix_model_path . $junction;
        $junction_model = new $junction_path(); // ItemAmenity model

        // CUSTOMIZE THE COLUMNS
        if ( ! empty($this->columns))
            $columns = $this->columns;
        else 
        {
            // getting all fields of the junction model, except the foreign keys
            $columns = array_slice($junction_model->attributes(), 2);
        }

        $return = $this->render('gridview', [
            'dataProvider'         => $dataProvider,
            'columns'              => $columns,
            'attribute_class_name' => $attribute_class_name,
            'junction_ID'          => $junction_ID
        ]);

        // PREPARING MODAL
        // we do it here, not in the view, for more readibility
        foreach ($columns as $key => $column)
        {
            // ignore the column from the attribute table
            if ($junction_model->hasAttribute($column))
                $columns_meta[$column] = $junction_model->getTableSchema()->columns[$column];
        }

        $return .= $this->render('modal', [
            'model'                => $model,
            'model_primary_key'    => $model_primary_key,
            'attribute_model'      => $attribute_model, 
            'attribute_class_name' => $attribute_class_name,
            'attribute_ID'         => $attribute_ID,
            'junction_model'       => $junction_model,
            'junction_ID'          => $junction_ID,
            'junction'             => $junction,
            'columns'              => $columns,
            'columns_meta'         => $columns_meta
        ]);

        return $return;
    }
}