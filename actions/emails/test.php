<?php


try {

  $toField = 'adam.falchetta@camdendiocese.org';
  $subject = 'This is a test test test';
  $message = 'This is a test from email service';

  mail($toField, $subject, $message);

}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
