<?php
  function truncateText($text, $limit){ // It removes the characters that exceed the limit(45) and adds an ellipsis.
    if (strlen($text) > $limit) {
        $text = substr($text, 0, $limit) . '...'; 
    }
    return $text;
  }
?>