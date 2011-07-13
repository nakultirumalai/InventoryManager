<?php

  function valueExistsInArray($value, $array) {
    $arrayCount = count($array);
    $result = false;

    for ($idx = 0; $idx < $arrayCount; $idx++) {
      if ($value  == $array[$idx]) {
        $result = true;
        break;
      }
    }
    
    return $result;
  }

?>