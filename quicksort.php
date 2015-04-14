<?php

function quicksort($seq, $property) {
  if(!count($seq)) return $seq;

  $k = $seq[0];
  $x = $y = array();

  $length = count($seq);

  for($i=1; $i < $length; $i++) {
    if($seq[$i][$property] <= $k[$property]) {
      $x[] = $seq[$i];
    } else {
      $y[] = $seq[$i];
    }
  }

  return array_merge(quicksort($x, $property), array($k), quicksort($y, $property));
}

?>