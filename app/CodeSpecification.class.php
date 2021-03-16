<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Util\Config;

require_once('database/TableReader.class.php');
require_once('adianti/Adianti.class.php');
require_once('generator/LabelGenerator.class.php');
require_once('generator/WidgetGenerator.class.php');
require_once('generator/IsNullableGenerator.class.php');
require_once("util/LoadConfig.class.php");
require_once('util/Util.class.php');
include("../content.php");

headerContent("../");

class CodeSpecification
{
    function __construct()
    {

        if (isset($_GET['tableName'])) {

            $data = TableReader::getInfo($_GET['tableName']);

            if ($data) {
                $className = LabelGenerator::className($_GET['tableName']);
                ?>
                <div class="container">
                    <div class="row">
                        <!-- start content -->
                        <form action="generator/CodeGenerator.class.php" method="POST">
                            <input type="hidden" name="tableName" value="<?php echo $_GET['tableName']; ?>">
                            <div class="card hoverable">
                                <div class="card-content">
                                        <span class="card-title"><b>FORM INFO</b> <i
                                                    class="material-icons right">more_vert</i></span>
                                    <div class="col s12">
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <!-- <i class="material-icons prefix">account_circle</i> -->
                                                <input id="recordName" type="text" name="recordName"
                                                       value="<?php echo $className; ?>Record"
                                                       placeholder="tb_usuario"/>
                                                <label for="recordName">Record:</label>
                                            </div>
                                            <div class="col s3">
                                                <div class="row">
                                                    <!-- <i class="material-icons prefix">phone</i> -->
                                                    <input type="checkbox" class="filled-in" id="record" name="record" checked/>
                                                    <label for="record">Record</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s6">
                                                <input name="type" type="radio" id="list_form" value="list_form" checked
                                                       required/>
                                                <label for="list_form">List/Form:</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <label for="listName">Class</label>
                                                <input type="text" name="listName" id="listName"
                                                       value="<?php echo $className ?>List"/>
                                            </div>
                                            <div class="input-field col s6">
                                                <label for="listTitle">Title</label>
                                                <input type="text" name="listTitle" id="listTitle"
													   value=<?php echo $className ?>>
                                                       <!-- value="Listagem de " -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <label for="type">Class</label>
                                                <input type="text" name="formName" id="formName"
                                                       value="<?php echo $className ?>Form"/>
                                            </div>
                                            <div class="input-field col s6">
                                                <label for="type">Title</label>
                                                <input type="text" name="formTitle" id="formTitle"
                                                       value="Cadastro de <?php echo $className ?>">
                                                       <!-- value="Formulário de " -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <input class="#0091ea light-blue accent-4" name="type" type="radio" id="detalhe" value="detalhe"/>
                                            <label for="detalhe">Detalhe</label>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <label for="detalheName">Class</label>
                                                <input type="text" name="detalheName" id="detalheName"
                                                       value="<?php echo $className ?>Detalhe"/>
                                            </div>
                                            <div class="input-field col s3">
                                                <label for="detalheTitle">Title</label>
                                                <input type="text" name="detalheTitle" id="detalheTitle"
                                                       value="Detalhe de "/>
                                            </div>
                                            <div class="input-field col s3">
                                                <label for="detalheFather">Father</label>
                                                <input type="text" name="detalheFather" id="detalheFather"
                                                       value="List"/>
                                            </div>
                                        </div>
                                    </div>
                                    <p>&nbsp;</p><!-- expanding div content -->
                                </div>
                                <div class="card-action">
                                    <a class="waves-effect waves-light btn #0091ea light-blue accent-4" href="../index.php"><i class="material-icons right">arrow_back</i>Back</a>
                                    <button type="submit" class="btn #4caf50 green">Create<i class="material-icons right">arrow_forward</i></button>
                                </div>
                            </div><!-- /.card-content -->
                    </div><!-- row -->
                </div>
                <div class="container">
                    <div class="row">
                        <div class="card hoverable">
                            <div class="card-content">
                        <span class="card-title"><b>TABLE INFO</b>
                                    <i class="material-icons right">more_vert</i></span>
                                <div class="col s12">
                                    <?php echo $this->createList($data); ?>
                                </div><!-- /.col-lg-6 -->
                                <p>&nbsp;</p>
                            </div><!-- /.card-content -->
                        </div><!-- /.row -->
                    </div>
                </div>
                </form>
                <?php
            } else {
                ?>
                <div class="container">
                    <div class="row">
                        <div class="card hoverable">
                            <div class="card-content">
                        <span class="card-title"><b>FORM INFO</b>
                                    <i class="material-icons right">more_vert</i></span>
                                <div class="col s12">
                                    <?php
                                    $config = Config\LoadConfig::get();
                                    Util::errorMsg('Error this table does not exist in the database: ' . $config->getName() . '.');
                                    ?>
                                    <form action="../index.php">
                                        <button type="submit" class="btn #0091ea light-blue accent-4"><i class="material-icons right">arrow_back</i>Back to index</button>
                                    </form>
                                </div><!-- /.col-lg-12 -->
                                <p>&nbsp;</p>
                            </div><!-- /.card-content -->
                        </div><!-- /.row -->
                    </div>
                </div>
                <?php
            }
        }
    }

    private function createList($data)
    {
        $table = '<div class="col s12">
                    <div class="row">
                        <div class=" col s7">
                        <p>
                            <input type="checkbox" id="checkAllGrid" class="filled-in" name="checkAllGrid" checked="checked"/> 
                            <label for="checkAllGrid">Select all Grid</label>
                        </p>
                        <p>
                            <input type="checkbox" id="checkAllSrch" class="filled-in" name="checkAllSrch" checked="checked"/> 
                            <label for="checkAllSrch">Select all Grid Search</label>
                        </p>
                        <p>
                            <input type="checkbox" id="checkAllForm" class="filled-in" name="checkAllForm" checked="checked"/> 
                            <label for="checkAllForm">Select all Form</label>
                        </p>
                        </div>
                    </div>
                    <table id="example" class="responsive-table highlight" cellspacing="0" width="100%">';
        $table .= '<thead>
                        <tr align="left">
                            <th>Show Grid</th>
                            <th>Grid Search</th>
                            <th>Show Form</th>
                            <th>Read Only</th>
                            <th>Column</th>
                            <th>Label</th>
                            <th>Adianti Widget</th>
                            <th>Is Nullable?</th>
                            <th>Database Info</th>
                        </tr>
                    </thead>';
        $i = 0;
        foreach ($data as $item) {

            $table .= $this->listItem($item, $i);

            $i++;

        }

        $table .= '</table>
                </div>';

        return $table;

    }

    private function listItem($item, $i)
    {
        $databaseInfo = '<span style="color:blue;">' . $item['column_name'] . '</span>';
        $databaseInfo .= '<span style="color:green;"> ' . $item['data_type'];
        $databaseInfo .= $item['length'] > 0 ? '(' . $item['length'] . ')' : '';
        $databaseInfo .= '</span>';
        $databaseInfo .= $item['is_nullable'] == 'NO' ? ' <b>not null</b>' : '';

        //Alair
		if($item['column_name'] == 'dataalteracao' || $item['column_name'] == 'usuarioalteracao')
			$DataCheced = 'unchecked';
		else
			$DataCheced = 'checked';

        return '<tbody>
                <tr>
                    <td><input type="checkbox" class="checkGrid filled-in" id="item_grid_' . $i . '" name="item_grid_' . $i . '" ' .$DataCheced .'/><label for="item_grid_' . $i . '"></label></td>
                    <td>
                        <input type="checkbox" class="checkSrch filled-in" id="item_srch_' . $i . '" name="item_srch_' . $i . '" ' .$DataCheced .'/><label for="item_srch_' . $i . '"></label>
                        <!-- input class="#0091ea light-blue accent-4" name="dflt_999" type="radio" id="dflt_'.$i.'" value="'.$i.'" '.($i==0?'Checked':'UnChecked').'/>
                        <label for="dflt_'.$i.'"></label -->
                    </td>
                    <td><input type="checkbox" class="checkForm filled-in" id="item_form_' . $i . '" name="item_form_' . $i . '" ' .$DataCheced .'/><label for="item_form_' . $i . '"></label></td>
                    <td><input type="checkbox" class="checkRO filled-in" id="item_ro_' . $i . '" name="item_ro_' . $i . '" unchecked/><label for="item_ro_' . $i . '"></label></td>
                    <td><input type="text" style="border: 0px;" name="item_column_' . $i . '" value="' . $item['column_name'] . '" readonly /></td>
                    <td>' . LabelGenerator::label($item['column_name'], $i) . '</td>
                    <td>' . WidgetGenerator::fieldWidget($item['column_name'], $item['data_type'], $item['length'], $i) . '</td>
                    <td>' . IsNullableGenerator::getInfo($item['is_nullable'], $i) . '</td>
                    <td>' . $databaseInfo . '</td>
                    <td><input type="hidden" name="item_length_' . $i . '" value="' . $item['length'] . '" /></td>
                </tr>
                </tbody>';
    }
}

new CodeSpecification();

footerContent("../");
################# Check All itens form table #################
echo '<script>
    $("#checkAllForm").click(function () {
         $(".checkForm").prop("checked", $(this).prop("checked"));
     }); 
    $("#checkAllGrid").click(function () {
         $(".checkGrid").prop("checked", $(this).prop("checked"));
     });
	//Alair
    $("#checkAllSrch").click(function () {
         $(".checkSrch").prop("checked", $(this).prop("checked"));
     });
    </script>';
################# Check All itens form table #################
