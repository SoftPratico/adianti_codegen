<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../util/Util.class.php');
require_once('../adianti/Adianti.class.php');

class FormGenerator
{

    private $listName;
    private $formName;
    private $formTitle;

    private $tableName;
    private $recordName;

    private $formItems;

    private $filePath;

    function __construct($listName, $formName, $formTitle, $recordName, $tableName, $formItems)
    {

        $this->listName = $listName;
        $this->formName = $formName;
        $this->formTitle = $formTitle;

        $this->recordName = $recordName;
        $this->tableName = $tableName;

        $this->formItems = $formItems;

        $this->filePath = '../files/' . $this->tableName . '/' . $this->formName . '.class.php';

    }

    public function generate()
    {

        $createdSuccess = false;

        if (Util::createFile(Util::FORM_TEMPLATE_PATH, $this->filePath)) {

            if ($this->writeForm()) {

                $createdSuccess = true;

            }

        }

        return $createdSuccess;

    }

    public function writeForm()
    {

        $codeWritten = false;

        $code = file_get_contents($this->filePath);

        $code = str_replace("**FORM_CLASS_NAME**", $this->formName, $code);
        $code = str_replace("**LIST_NAME**", $this->listName, $code);
        $code = str_replace("**FORM_LABEL**", $this->formTitle, $code);

        $code = str_replace("**TABLE_NAME**", $this->tableName, $code);
        $code = str_replace("**DB_CONFIG_FILE**", Util::getConfigFileDatabaseName(), $code);

        $code = str_replace("**RECORD_NAME**", $this->recordName, $code);

        $code = str_replace("**FORM_FIELD_CREATION_LINE**", FormGenerator::createFormFields($this->formItems), $code);
		
        $code = str_replace("**FIELD_SIZE_BOX**", FormGenerator::createFieldsSizesBox($this->formItems), $code);
        $code = str_replace("**FIELD_SIZE_LINE**", FormGenerator::createFieldsSizes($this->formItems), $code);
        $code = str_replace("**FIELD_VALIDATION_LINE**", FormGenerator::createFieldsValidations($this->formItems), $code);
        $code = str_replace("**FIELD_DESABLE_LINE**", FormGenerator::createFieldsDesable($this->formItems, 'form_'.$this->tableName), $code);
        $code = str_replace("**FORM_FIELD_ADD_LINE**", FormGenerator::createAddFormFields($this->formItems), $code);

        if (file_put_contents($this->filePath, $code))
            $codeWritten = true;

        return $codeWritten;

    }

    public static function createFormFields($items)
    {
        $code = '';
        foreach ($items as $item) 
		{
            $code .= str_repeat(' ', 8) . "\$" . $item["column"] . " = new " . $item["widget"] . "('" . $item["column"] . "');" . "\r\n";
        }
        return $code;
    }

    public static function createFieldsSizesBox($items)
    {
        $code = '';
        foreach ($items as $item) {
            if ($item['widget'] == Adianti::ENTRY_ADIANTI && $item["length"] > 0)
                $code .= str_repeat(' ', 8) . "\$" . $item["column"] . "->setSize(" . intval($item["length"]*11.275 ). ");" . "\r\n";
			}
        return $code;
    }


    public static function createFieldsSizes($items)
    {
        $code = '';
        foreach ($items as $item) {
            if ($item['widget'] == Adianti::ENTRY_ADIANTI && $item["length"] > 0)
                $code .= str_repeat(' ', 8) . "\$" . $item["column"] . "->setMaxLength(" . $item["length"] . ");" . "\r\n";
        }
        return $code;
    }


    public static function createFieldsDesable($items, $formName)
    {
        $code = '';
        foreach ($items as $item) {
            if (array_key_exists("readonly", $item)) 
			    $code .= str_repeat(' ', 8) ."TEntry::disableField('" .$formName ."', '" .$item["column"] ."');\r\n"; //Alair - Usar esse por causa da cor e do ícone (/)
		}
        return $code;
    }


    public static function createAddFormFields($items)
    {
        $code = '';
        foreach ($items as $item) {
            if ($item['widget'] == 'THidden')
                $code .= str_repeat(' ', 8) . "\$this->form->addFields([\$" . $item["column"] . "]);" . "\r\n";
			else
                if ($item['is_nullable'] == 'NO')
                    $code .= str_repeat(' ', 8) . "\$this->form->addFields([new TLabel('" .$item["label"] . "','red')], [\$" .$item["column"] . "]);" ."\r\n";
                else
                    $code .= str_repeat(' ', 8) . "\$this->form->addFields([new TLabel('" . $item["label"] . "')], [\$" . $item["column"] . "]);" . "\r\n";
        }
        return $code;
    }


    public static function createFieldsValidations($items)
    {
        $code = '';
        foreach ($items as $item) {
            if ($item['is_nullable'] == 'NO' && $item['column'] != 'id')
                $code .= str_repeat(' ', 8) ."\$" . $item["column"] ."->addValidation('" . $item["label"] . "' , new TRequiredValidator);" . "\r\n";
        }
        return $code;
    }
}

?>