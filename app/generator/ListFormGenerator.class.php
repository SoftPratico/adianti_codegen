<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('ListGenerator.class.php');
require_once('FormGenerator.class.php');
require_once('../database/Connection.class.php');
require_once('../util/Util.class.php');

class ListFormGenerator
{

    private $listName;
    private $listTitle;

    private $formName;
    private $formTitle;

    private $recordName;
    private $tableName;

    private $itemsPost;
    //private $defaultSearch;

    function __construct($listName, $listTitle, $formName, $formTitle, $recordName, $tableName, $itemsPost)
    {

        $this->listName = $listName;
        $this->listTitle = $listTitle;

        $this->formName = $formName;
        $this->formTitle = $formTitle;

        $this->recordName = $recordName;
        $this->tableName = $tableName;

        $this->itemsPost = $itemsPost;

        //$this->defaultSearch = $defaultSearch;

    }

    public function generate()
    {

        $gridItems = ListFormGenerator::getAllDatagridItems($this->itemsPost);

        $gridSrch = ListFormGenerator::getAllDatagridSrch($this->itemsPost);

        $dflt_srch = ListFormGenerator::getItemDefault($this->itemsPost);

        $listGenerator = new ListGenerator($this->listName, $this->listTitle, $this->formName, $this->recordName, $this->tableName, $gridItems, $gridSrch);

        if ($listGenerator->generate()) {

            Util::successMsg('> ' . $this->listName . ' created with success.');

            $formItems = ListFormGenerator::getAllFormItems($this->itemsPost);

            $formGenerator = new FormGenerator($this->listName, $this->formName, $this->formTitle, $this->recordName, $this->tableName, $formItems);

            if ($formGenerator->generate()) {

                Util::successMsg('> ' . $this->formName . ' created with success.');

            } else {

                Util::errorMsg('> Error creating ' . $this->formName . '.');

            }

        } else {

            Util::errorMsg('> Error creating ' . $this->listName . '.');

        }
    }

    public static function getItemDefault($items)
    {

        $data = "";

        foreach ($items as $key => $value) {

            if (array_key_exists("dflt_srch", $value)) {

                $data = $value["item_column_" . $key];

                break;

            }

        }

        return $data;

    }

    public static function getAllDatagridItems($items)
    {

        $data = array();

        foreach ($items as $key => $value) {

            if (array_key_exists("item_grid_" . $key, $value)) {

                $temp = array();

                $temp["column"] = $value["item_column_" . $key];
                $temp["label"] = $value["item_label_" . $key];
                if (array_key_exists("item_length_" . $key, $value))
                    $temp["length"] = $value["item_length_" . $key];

                array_push($data, $temp);

            }

        }

        return $data;

    }

    public static function getAllDatagridSrch($items)
    {

        $data = array();

        foreach ($items as $key => $value) {

            if (array_key_exists("item_srch_" . $key, $value)) {

                $temp = array();

                $temp["column"] = $value["item_column_" . $key];
                $temp["label"] = $value["item_label_" . $key];

                array_push($data, $temp);

            }

        }

        return $data;

    }

    public static function getAllFormItems($items)
    {

        $data = array();

        foreach ($items as $key => $value) {

            if (array_key_exists("item_form_" . $key, $value)) {

                $temp = array();

                $temp["column"] = $value["item_column_" . $key];

                if (array_key_exists("item_label_" . $key, $value))
                    $temp["label"] = $value["item_label_" . $key];

                $temp["widget"] = $value["item_widget_" . $key];

                if (array_key_exists("item_length_" . $key, $value))
                    $temp["length"] = $value["item_length_" . $key];

                $temp["is_nullable"] = $value["item_is_nullable_" . $key];

                if (array_key_exists("item_ro_" . $key, $value))
                    $temp["readonly"] = True; //$value["item_ro_" . $key];

                array_push($data, $temp);

            }

        }

        return $data;

    }

}

?>