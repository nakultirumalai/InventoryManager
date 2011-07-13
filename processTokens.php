<?php
  function getTextOfInterest($dataText, $beginDelim, $endDelim) {
    $beginDelimLength = strlen($beginDelim);
    $beginDelimPos = strpos($dataText, $beginDelim);
    if ($beginDelimPos === false || $beginDelimPos != 0) {
      $textOfInterest = 0;
      return ($textOfInterest);
    }      
    $endDelimPos = strpos($dataText, $endDelim);
    if ($endDelimPos === false) {
      $textOfInterest = 0;
      return ($textOfInterest);
    }      
    $textOfInterestLength = $endDelimPos - $beginDelimLength;
    $textOfInterest = strstr($dataText, $beginDelimLength, $textOfInterestLength);
    writeDebug("Text of Interest:", $textOfInterest);

    return $textOfInterest;
  }
  
  function getTokens($dataText) {
    global $dataDelimiter;
    global $allBeginDelimiters;

    $beginDelimiterCount = count($allBeginDelimiters);
 
    $dataTextLength = strlen($dataText);
    $noDelimiter = false;
    $prevStartPos = 0;
    $tokenCount = 0;

    for ($idx = 0; $idx < $dataTextLength; $idx++) {
      /* Obtain the index of the beginning of the first delimiter in $dataText */      
      if ((!IsSet($firstBeginDelimiterPos) || ($idx > $firstBeginDelimiterPos)) && ($noDelimiter == false)) {
        for ($curDelimiterIdx = 0; $curDelimiterIdx < $beginDelimiterCount; $curDelimiterIdx++) {
          $curDelimiterPos = strpos($dataText, $allBeginDelimiters[$curDelimiterIdx]);
	  if ($curDelimiterPos === false) {
	    continue;
          }
          $noDelimiter = false;
          if (IsSet($prevDelimiterPos)) {
            if ($prevDelimiterPos > $curDelimiterPos) {
              $prevDelimiterPos = $curDelimiterPos;
              $firstBeginDelimiter = $allBeginDelimiters[$curDelimiterIdx];
              $firstBeginDelimiterPos = $prevDelimiterPos;
              $firstBeginDelimiterIdx = $curDelimiterIdx;
            }
          } else {
            $prevDelimiterPos = $curDelimiterPos;
          }
        }
      }
      if ($idx == $firstBeginDelimiterPos) {
        $endDelimiter = $allEndDelimiters[$firstBeginDelimiterIdx];
        $endDelimiterPos = strpos($dataText, $endDelimiter, $idx);
        if ($endDelimiterPos === false) {
          die('Packed string is corrupt: No end delimiter found for a begin delimiter');
        }
	$tokenTextLength = $endDelimiterPos + strlen($endDelimiter) - $beginDelimiterPos;
        $tokenText = substr($dataText, $firstBeginDelimiterPos, $tokenTextLength);
	$tokens[$tokenCount] = $tokenText;
        $tokenCount++;
	$idx = $endDelimiterPos + strlen($endDelimiter);
        $prevStartPos = $idx;
      }
      if ($dataText[$idx] == $dataDelimiter) {
        $currentEndPos = $idx - 1;
        $prevStartPos = $idx + 1;
	$tokenTextLength = $prevStartPos - $currentEndPos;
        $tokenText = substr($dataText, $prevStartPos, $tokenTextLength);
        $tokens[$tokenCount] = $tokenText;
	$tokenCount++;
      }
    }
    if (IsSet($tokens)) {
      $tokenCount = count($tokens);
      for ($idx = 0; $idx < $tokenCount; $idx++) {
        writeDebug("Token $idx:", $tokens[$tokenCount]);   
      }
    }
  }

?>
