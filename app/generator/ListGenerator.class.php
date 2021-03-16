<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
require_once('../util/Util.class.php');

class ListGenerator
{

    private $tableName;
    private $recordName;
    private $listName;
    private $listTitle;
    private $formName;
    private $dataGridItems;
    private $dataGridSrch; //Alair
    //private $defaultSearch; //Alair

    private $filePath;

    function __construct($listName, $listTitle, $formName, $recordName, $tableName, $dataGridItems, $dataGridSrch)
    {

        $this->listName = $listName;
        $this->listTitle = $listTitle;
        $this->formName = $formName;

        $this->recordName = $recordName;
        $this->tableName = $tableName;

        $this->dataGridItems = $dataGridItems;

        //$this->defaultSearch = $defaultSearch; //Alair

        //Alair
        //$this->dataGridSrch = '';
        //foreach ($dataGridSrch as &$a) {
        //    $this->dataGridSrch = $this->dataGridSrch .str_repeat(' ', 8) ."$" ."items['" .$a['column'] ."'] = '" .$a['label'] ."';\r\n";
        //}
        $this->dataGridSrch = $dataGridSrch;

        $this->filePath = '../files/' . $this->tableName . '/' . $this->listName . '.class.php';

    }

    public function generate()
    {

        $createdSuccess = false;

        if (Util::createFile(Util::LIST_TEMPLATE_PATH, $this->filePath)) {

            if ($this->writeList()) {

                $createdSuccess = true;

            }

        }

        return $createdSuccess;

    }

    private function writeList()
    {

        $codeWritten = false;

        $code = file_get_contents($this->filePath);

        //$code = str_replace("**SEARCH_ITEMS_VALUE**", $this->dataGridSrch, $code); //Alair
        $search_items = ListGenerator::createSearchItems($this->dataGridSrch);
        $code = str_replace("**SEARCH_ITEMS**", $search_items, $code);
        
        $search_fields = ListGenerator::createSearchFields($this->dataGridSrch);
        $code = str_replace("**SEARCH_FIELDS**", $search_fields, $code);  

        $code = str_replace("**LIST_CLASS_NAME**", $this->listName, $code);
        $code = str_replace("**LIST_LABEL**", $this->listTitle, $code); 

        //$code = str_replace("**SEARCH_ITEM_VALUE**", $this->dataGridItems[$this->defaultSearch]["column"], $code);
        //$code = str_replace("**SEARCH_ITEM_LABEL**", $this->dataGridItems[$this->defaultSearch]["label"], $code);

        $code = str_replace("**FORM_NAME**", $this->formName, $code);
        $code = str_replace("**TABLE_NAME**", $this->tableName, $code);
        $code = str_replace("**DB_CONFIG_FILE**", Util::getConfigFileDatabaseName(), $code);
        $code = str_replace("**RECORD_NAME**", $this->recordName, $code);

        $data_items = ListGenerator::createDatagridItems($this->dataGridItems);

        $code = str_replace("**DATA_GRID_ITEMS_LINE**", $data_items, $code);

        if (file_put_contents($this->filePath, $code))
            $codeWritten = true;

        return $codeWritten;

    }

    public static function createSearchItems($items)
    {

        $itemsCode = '';

        foreach ($items as $item) {

            $itemsCode .= str_repeat(' ', 8) . "parent::addFilterField('". $item["column"] ."', 'like', '". $item["column"] ."');\r\n";

        }

        return $itemsCode;

    }

    public static function createSearchFields($items)
    {

        $itemsCode = '';

        foreach ($items as $item) {

            $itemsCode .= str_repeat(' ', 8) . "\$". $item["column"] ." = new TEntry('". $item["column"] ."');\r\n";
        }

        $itemsCode .= "\r\n";

        foreach ($items as $item) {

            $itemsCode .= str_repeat(' ', 8) . "\$this->form->addFields( [new TLabel('". $item["label"] ."')], [\$". $item["column"] ."]);\r\n";

        }

        return $itemsCode;

    }

    public static function createDatagridItems($items)
    {

        $itemsCode = '';

        foreach ($items as $item) {

            $itemsCode .= str_repeat(' ', 8) . "\$column_" . $item["column"] . " = new TDataGridColumn('" . $item["column"] . "', '" . $item["label"] . "', 'left'";

            if (array_key_exists("length", $item))
                $itemsCode .= ", " . (int)$item["length"] * 11 . ");\r\n";

        }

        $itemsCode .= "\r\n";

        foreach ($items as $item) {

            $itemsCode .= str_repeat(' ', 8) . "\$this->datagrid->addColumn(\$column_" . $item["column"] . ");\r\n";

        }

        $itemsCode .= "\r\n";

        foreach ($items as $item) {

            $itemsCode .= str_repeat(' ', 8) . "\$order_" . $item["column"] . " = new TAction(array(\$this, 'onReload'));\r\n";
            $itemsCode .= str_repeat(' ', 8) . "\$order_" . $item["column"] . "->setParameter('order', '" . $item["column"] . "');\r\n";
            $itemsCode .= str_repeat(' ', 8) . "\$column_" . $item["column"] . "->setAction(\$order_" . $item["column"] . ");\r\n";

        }

        return $itemsCode;

    }
}

?>