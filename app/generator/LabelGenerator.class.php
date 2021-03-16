<?php

class LabelGenerator
{

    private static $i;

    public static function label( $columnName, $i ) {

        LabelGenerator::$i = $i;

        //Alair
        //if($columnName == 'id' || $columnName == 'dataalteracao' || $columnName == 'usuarioalteracao')
        //    return '';

        $columnLabel = str_replace( "_", " ", $columnName );
        $columnLabel = str_replace( " id", "", $columnLabel );
        $columnLabel = ucwords( $columnLabel, " " );

        //Alair
        $array = array(
            'Id'  => 'ID',
            'Cpf' => 'CPF',
            'Cnpj' => 'CNPJ',
            'Cpf Cnpj' => 'CPF/CNPJ',
            'Rg' => 'RG',
            'Ie' => 'IE',
            'Rg Ie' => 'RG/IE',
            'Cep' => 'CEP',
            'Idcep' => 'CEP',
            'Endereco' => 'Endereço',
            'Numero' => 'Número',
            'Uf' => 'UF',
            'Observacao' => 'Observação',
            'Usuarioalteracao' => 'Usuario Alteração',
            'Dataalteracao' => 'Data Alteração'
        );
        if (array_key_exists($columnLabel, $array))
            $columnLabel = $array[$columnLabel];
        
        return LabelGenerator::createInput( $columnLabel );

    }

    private static function createInput( $columnLabel ) {

        return '<input type="text" name="item_label_' . LabelGenerator::$i .'" value="' . $columnLabel . '" />';

    }

    public static function className( $table ) {

        $className = ucwords( $table, "_" );
        $className = str_replace( "_", "", $className );

        return $className;

    }

}