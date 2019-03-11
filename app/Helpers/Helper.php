<?php

if ( !function_exists('array_search_unique') ){
    /**
     * search unique data by assign field name($compare) and return its keys via array format.
     *
     * @param [array] $array
     * @param [string] $compare
     * @return array
     */
    function array_search_unique($array, $compare)
    {
        $reserved = [];
        $peddingRemove = [];
        foreach( $array as $key=>$value ){
            if( in_array($value[$compare], $reserved) ){
                // If duplicate, push it to array $peddingRemove
                $peddingRemove[] = $key;
            } else {
                $reserved[] = $value[$compare];
            }
        }

        return $peddingRemove;
    }
}