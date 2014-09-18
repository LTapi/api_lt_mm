<?php

if(!function_exists('select_define_builder')){

  function select_define_builder($valueCurrentArr, $valueAllDataArr, $includeKeyThisValBoolean = false){
    $selectStr = "";

    if(is_array($valueAllDataArr)){

      foreach ($valueAllDataArr as $keyCommon => $valueCommon) {
        $selected = "";

        $selected = setUpSelected($valueCurrentArr, $valueCommon, $keyCommon, $includeKeyThisValBoolean);

        $value = $includeKeyThisValBoolean ? $keyCommon : $valueCommon;

        $selectStr .= '<option value="'.trim($value).'"'.$selected.'>'.trim($valueCommon).'</option>';
      }
    }

    return $selectStr;
  }

  function setUpSelected($valueCurrentArr, $valueCommon, $keyCommon, $includeKeyThisValBoolean){
    if( $includeKeyThisValBoolean && in_array( $keyCommon, $valueCurrentArr )){ return ' selected'; }
    
    if(in_array( $valueCommon, $valueCurrentArr )){ return ' selected'; }

    return "";
  }
}