<?php

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

require_once('RecordGenerator.class.php');
require_once('DetalheGenerator.class.php');
require_once('ListFormGenerator.class.php');
require_once('../util/Util.class.php');

include("../../content.php");

headerContent("../../");

class CodeGenerator
{

    private $tableName;

    private $recordName;

    private $type;

    private $listName;
    private $listTitle;

    private $formName;
    private $formTitle;

    private $detalheName;
    private $detalheTitle;
    private $detalheFather;
	
	private $defaultSearch;
	private $listReadOnly;

    function __construct()
    {
        //print inicial page
        echo '<div class="container">
                    <div class="row">
                        <div class="card hoverable">
                            <div class="card-content">
                                 <span class="card-title"><b>Finish</b>
                                    <i class="material-icons right">more_vert</i></span>
                                <!-- /.col-lg-12 -->';

        $itemsPost = Util::getItemsFromPOST($_POST);

		//$defaultSearch = $_POST['dflt_999'];
		
        $this->tableName = $_POST['tableName'];
        $this->type = !empty($_POST['type']) ? $_POST['type'] : '';

        if (!empty($_POST['tableName'])) {


            if (!is_dir('../files/' . $this->tableName)) {

                mkdir('../files/' . $this->tableName, 0777, true);
                Util::successMsg(' Folder ' . $this->tableName . ' created with success.');

            } else {
                Util::errorMsg('Error creating folder "' . $this->tableName . '", folder already Exists.');
            }

            if (isset($_POST['record'])) {

                $this->recordName = $_POST['recordName'];

                $recordGenerator = new RecordGenerator($this->tableName, $this->recordName);

                if ($recordGenerator->generate()) {

                    Util::successMsg($this->recordName . ' created with success.');

                } else {

                    Util::errorMsg('Error creating ' . $this->recordName . '.');

                }
            }

            if ($this->type == 'list_form') {

                $this->listName = $_POST['listName'];
                $this->listTitle = $_POST['listTitle'];

                $this->formName = $_POST['formName'];
                $this->formTitle = $_POST['formTitle'];

                $listFormGenerator = new ListFormGenerator($this->listName, $this->listTitle, $this->formName, $this->formTitle, $this->recordName, $this->tableName, $itemsPost);

                $listFormGenerator->generate();

            } else if ($this->type == 'detalhe') {

                $this->detalheName = $_POST['detalheName'];
                $this->detalheTitle = $_POST['detalheTitle'];
                $this->detalheFather = $_POST['detalheFather'];

                $detalheGenerator = new DetalheGenerator($this->detalheName, $this->detalheTitle, $this->recordName, $this->tableName, $this->detalheFather, $itemsPost);

                if ($detalheGenerator->generate()) {

                    Util::successMsg($this->detalheName . ' created with success.');

                } else {

                    Util::errorMsg('Error creating ' . $this->detalheName . '.');

                }

            }

        }
        //print final page
        echo '                <p>&nbsp;</p>
                            </div><!-- /.card-content -->
                            <div class="card-action">
                                    <form action="../../index.php">
                                        <button type="submit" class="btn #0091ea light-blue accent-4"><i class="material-icons right">arrow_back</i>Back to index</button>
                                    </form>
                             </div>
                        </div><!-- /.row -->
                    </div>
                </div>';

    }

}

new CodeGenerator();


footerContent("../../");
