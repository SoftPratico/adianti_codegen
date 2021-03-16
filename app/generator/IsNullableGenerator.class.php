<?php

class IsNullableGenerator
{

    public static function getInfo( $isnullable, $i )
    {

        $combo = '<select class="browser-default" name="item_is_nullable_' . $i . '">';

        if( $isnullable == 'NO' ) {

            $combo .= "<option selected=\"selected\" value=\"" . $isnullable . "\">" . $isnullable ."</option>";
            $combo .= "<option value=\"YES\">YES</option>";

        }else if( $isnullable == 'YES' ) {

            $combo .= "<option selected=\"selected\" value=\"" . $isnullable . "\">" . $isnullable ."</option>";
            $combo .= "<option value=\"NO\">NO</option>";

        }

        $combo .= '</select>';

        return $combo;

    }

}