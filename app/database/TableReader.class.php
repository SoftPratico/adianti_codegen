<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Util\Config;
use Util\Config\Conn;

require_once "util/LoadConfig.class.php";
require_once "Connection.class.php";

class TableReader
{

    public static function getInfo($tableName )
    {
        $config = Config\LoadConfig::get();
        $type = $config->getType();
		$name = $config->getName();

        $schema      = "information_schema.columns";
        $table       = "table_name";
        $tableschema = "table_schema";
        $column      = "column_name";
        $datatype    = "data_type";
        $nullable    = "is_nullable";
        $length      = "character_maximum_length";

        if ( $type == "mysql" ) {

            $schema      = strtoupper( $schema );
            $table       = strtoupper( $table );
            $tableschema = strtoupper( $tableschema );
            $column      = strtoupper( $column );
            $datatype    = strtoupper( $datatype );
            $nullable    = strtoupper( $nullable );
            $length      = strtoupper( $length );

        }

        try {
            $data = [];
            $pdo = Conn\Connection::get()->connect();

		    $stmt = $pdo->query( "SELECT * FROM {$schema} WHERE {$table} = '{$tableName}' AND {$tableschema} = '{$name}';" );

            while ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ) {

                $data[] = [
                    "column_name" => $row[ $column ],
                    "data_type"   => $row[ $datatype ],
                    "is_nullable" => $row[ $nullable ],
                    "length"      => $row[ $length ]
                ];

            }

            return $data;

        } catch ( PDOException $e ) {

            Util::errorMsg( $e->getMessage() );

        }

    }

}