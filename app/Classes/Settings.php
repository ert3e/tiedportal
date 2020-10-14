<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 25/01/2016
 * Time: 07:54
 */

namespace App\Classes;

class Settings
{
    public function selectValues($options, $id_field = 'value', $recursive = false) {

        $values = [];

        foreach( $options as $index => $option ) {

            $children = [];
            if ($recursive) {
                $children = $this->_getChildren($option, $id_field);
            }

            if( is_string($option) ) {
                $text = $option;
                $id = $index;
            } else if( method_exists($option, 'displayName') ) {
                $text = $option->displayName();
                $id = $option->id;
            } else {
                $text = $option->name;
                $id = $option->id;
            }

            $value = [
                $id_field => $id,
                'text' => $text
            ];

            if( !empty($children) ) {
                //$values += $children;
                $value['children'] = $children;
            }

            $values[] = $value;
        }

        return htmlentities(json_encode($values));
    }

    private function _getChildren($option, $id_field) {

        $values = [];

        foreach( $option->children as $option ) {

            $children = $this->_getChildren($option, $id_field);

            if( method_exists($option, 'displayName') ) {
                $text = $option->displayName();
            } else {
                $text = $option->name;
            }

            $value = [
                $id_field => $option->id,
                'text' => $text
            ];

            if( !empty($children) ) {
                unset($value[$id_field]);
                $value['children'] = $children;
            }

            $values[] = $value;
        }

        return $values;
    }

    public function multiSelectValues($values) {

        $value_ids = $values->lists('id')->toArray();

        return sprintf('[%s]', implode(',', $value_ids));
    }

    public function displaySelectValues($values) {

        $display_values = [];

        foreach( $values->lists('name') as $value ) {
            $display_values[] = sprintf('<span class="select-value">%s</span>', $value);
        }

        if( empty($display_values) )
            return 'None';

        return sprintf('%s', implode(' - ', $display_values));
    }
}