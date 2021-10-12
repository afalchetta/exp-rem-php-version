<?php
include 'configEmails.php';

try {

  $toField = 'MAIN_EMAIL';
  $subjectField90Days = 'You have a contract Expiring in 90 Days';
  $subjectField60Days = 'You have a contract Expiring in 60 Days';
  $subjectField30Days = 'You have a contract Expiring in 30 Days';
  // Always set content-type when sending HTML email

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	$headers .= 'From: admin@expiration.camdendiocese.org' . "\r\n";

  $db_email = getDB_email();

  $sql = 'SELECT * FROM reminders';
  $stmt = $db_email->prepare($sql);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $ninety_daysFrom_now = date('Y-m-d', time() + 86400 * 90);
  $sixty_daysFrom_now = date('Y-m-d', time() + 86400 * 60);
  $thirty_daysFrom_now = date('Y-m-d', time() + 86400 * 30);

  foreach($results as $row){
    $info = '<h2><hr>Contract Name:<br>' . $row['name'] . '</h2>' . '<h3>' . '<br>Expiring On:<br>' . $row['exdate'] . '</h3><br><h4>Location:<br>' . $row['location'] . '</h4>';


    if($row['exdate'] === $ninety_daysFrom_now){
      echo $message90 = '
      <html>
      <head>
      <title>Expiration Reminder Contract Expiring Soon</title>
      </head>
      <body>
      <h3>***Message From Your Expiration Reminder***</h3><br><p>Ron Pilla:</p>
      <br>You have a contract expiring in 90 days.<br>
      <h2><hr>Contract Name:<br>' . $row['name'] . '
      </h2>' . '<h3>' . '<br>Expiring On:<br>' . $row['exdate'] . '
      </h3><br><h4>Location:<br>' . $row['location'] . '</h4>
      <a href="https://expiration.camdendiocese.org" target="_blank">
      <button>View Your Contracts</button></a>
      <hr>
      </body>
      </html>';
      mail($toField, $subjectField90Days, $message90, $headers);
    }
    else if($row['exdate'] === $sixty_daysFrom_now){
       $message60 = '<html>
      <head>
      <title>Expiration Reminder Contract Expiring Soon</title>
      </head>
      <body>
      <h3>***Message From Your Expiration Reminder***</h3><br><p>Ron Pilla:</p>
      <br>You have a contract expiring in 60 days.<br>
      <h2><hr>Contract Name:<br>' . $row['name'] . '
      </h2>' . '<h3>' . '<br>Expiring On:<br>' . $row['exdate'] . '
      </h3><br><h4>Location:<br>' . $row['location'] . '</h4>
      <a href="https://expiration.camdendiocese.org" target="_blank">
      <button>View Your Contracts</button></a>
      <hr>
      </body>
      </html>';
       mail($toField, $subjectField60Days, $message60, $headers);
    }
    else if($row['exdate'] === $thirty_daysFrom_now){
       $message30 = '
       <html>
      <head>
      <title>Expiration Reminder Contract Expiring Soon</title>
      </head>
      <body>
      <h3>***Message From Your Expiration Reminder***</h3><br><p>Ron Pilla:</p>
      <br>You have a contract expiring in 30 days.<br>
      <h2><hr>Contract Name:<br>' . $row['name'] . '
      </h2>' . '<h3>' . '<br>Expiring On:<br>' . $row['exdate'] . '
      </h3><br><h4>Location:<br>' . $row['location'] . '</h4>
      <a href="https://expiration.camdendiocese.org" target="_blank">
      <button>View Your Contracts</button></a>
      <hr>
      </body>
      </html>';
       mail($toField, $subjectField30Days, $message30, $headers);
    }


  }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
 ?>
