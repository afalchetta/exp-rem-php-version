<?php
error_reporting(0);
include('actions/auth/config.php');
include('actions/auth/session.php');
$userDetails=$userClass->userDetails($session_uid);


include_once 'actions/getReminders.php';
include_once 'actions/getInactiveReminders.php';
include_once 'actions/delete.php';
include_once 'actions/isCurrent.php';
include_once 'actions/markAsActive.php';
include_once 'actions/getfile.php';
include_once 'actions/getNotes.php';
include_once 'actions/update.php';
include_once 'actions/deleteFile.php';


if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['deleteForm'])){
      $deleteReminder = new delete();
      $deleteReminder->deleteReminder();
      if($deleteReminder) {
        echo '<div class="alert alert-danger text-center" role="alert">Reminder and the attched files have been permanently deleted.</div>';
      }
  }else if(isset($_POST['updateId'])){
    $updateReminder = new Update();
    $updateReminder->updateReminder();
    if($updateReminder) {
      echo '<div class="alert alert-danger text-center" role="alert">Your Reminder has been updated.</div>';
    }
  }
  else if(isset($_POST['markAs'])){
    $changeReminder = new change();
    $changeReminder->changeReminder();
  }
  else if(isset($_POST['markAsActive'])){
    $markReminder = new markas();
    $markReminder->markAsReminder();
  }else if(isset($_POST['fileIdAdd'])){
    $addFiles = new AddFiles();
    $addFiles->addMoreFiles();
  }
  else if(isset($_POST['getFile'])){
    $a = new GetFile();
    $a->getTheFile();
    if($a) {
      echo '<div class="alert alert-danger text-center" role="alert">Files Here...</div>';
    }else{
      echo '<div class="alert alert-danger text-center" role="alert">No files for this reminder.</div>';
    }
  }else if(isset($_POST['getNote'])){
    $r = new GetNotes();
    $r->getNotes();
  }else if(isset($_POST['deleteFileFormID'])){
    $d = new DeleteSingleFile();
    $d->deleteFile();
    if($d) {
      echo '<div class="alert alert-danger text-center" role="alert">File Has Been Deleted</div>';
    }
  }

}

// SHOW ALL REMINDERS UPON LOGIN
$reminder = new Reminders;
$reminders = $reminder->getAllReminders();

// RESET TASKS DIV TO SHOW ALL REMINDERS
if(isset($_POST['showAll'])){
  $reminder = new Reminders;
  $reminders = $reminder->getAllReminders();
}
  //get all inactive reminders
  $inactivereminder = new inactiveReminders();
  $inactivereminders = $inactivereminder->getAllInactiveReminders();
//Display File names as Links
  $f = new GetFile();
  $fileNames = $f->getTheFile();
  //display Full Notes
  $r = new GetNotes();
  $fullNote = $r->getNotes();
  ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

     <title>Expiration Reminder</title>
      <link rel="icon" href="favicon.png" type="image/png" sizes="16x16">
     <link rel="stylesheet" href="css/master.css">
     <script src="https://kit.fontawesome.com/7163735c82.js" crossorigin="anonymous"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <script>
      $(document).ready(function(){
        $(".updateBtn").on('click',function(){
          $(this).next(".updateForm").slideToggle("slow");
        });
      });
      </script>
   </head>
   <body>
     <nav class="nav bg-light mb-4 justify-content-between">
       <div class="navbar-brand text-danger ml-4"><h4><i class="fas fa-asterisk"></i>  Expiration Reminder</h4></div>
         <h4 class="navbar-brand text-muted">Welcome <?php echo $userDetails->name; ?></h4>
         <a href="<?php echo BASE_URL; ?>actions/auth/logout.php"><button class="btn btn-danger btn-sm mt-2 mr-2"><i class="fas fa-sign-out-alt"></i> Logout</button></a>
       </nav>
         <main>
           <div class="container-fluid">
             <div class="mb-1"><p> Today: <?php date_default_timezone_set("America/New_York"); echo date('M d, Y'); ?></p></div>
               <div class="expirations">
                   <div class="container mb-2" id="tasks">
                     <div class="container task">
                       <a href="actions/insert.php"><button class="btn btn-danger btn-md mt-3 mr-4 mb-4" ><i class="fas fa-plus"></i>  Add Reminder</button></a>
                     </div>
                     <div class="container task">
                       <?php
                       if(isset($_POST['categorySelected'])){
                         $reminder = new Reminders();
                         $reminders = $reminder->getRemindersByCategory();
                         if(!$reminders){
                             echo '<p class="text-danger">No Contracts in that Category.</p>';
                         }
                       }
                        ?>
        <!--/////////////// FILTER FORM FOR REMINDERS BY CATEGORY \\\\\\\\\\\\\\\\\\\\-->
                       <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                         <div class="form-group">
                              <label for="categorySelected">Select A Category</label>
                              <select class="form-control" name="categorySelected" id="categorySelected">
                                <option>Pick A Category</option>
                                <option>Hardware</option>
                                <option>Software</option>
                                <option>Telco</option>
                                <option>Generic</option>
                                <option>Service Contract</option>
                                <option>Misc</option>
                              </select>
                            </div>
                            <button type="submit" class="btn btn-sm btn-success" name="submit">Filter</button>
                       </form>
                     </div>
                     <div class="container task">
                       <?php
                       if(isset($_POST['locationSelected'])){
                         $reminder = new Reminders();
                         $reminders = $reminder->getRemindersByLocation();
                         if(!$reminders){
                             echo '<p class="text-danger">No Contracts for that Location.</p>';
                         }
                       }
                        ?>
          <!-- ////////////////////FILTER FORM FOR REMINDERS BY LOCATION \\\\\\\\\\\\\\\\\\\\\\\\\-->
                       <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                         <label for="location">Location</label>
                         <div class="form-check pl-2 pt-1">
                           <input type="radio" name="location" id="location" value="DOC">
                           <label for="location">
                             DOC
                           </label><br>
                           <input  type="radio" name="location" id="location" value="CCHS">
                           <label  for="location">
                             CCHS
                           </label>
                           <input type="hidden" name="locationSelected"><br>
                           <button type="submit" class="btn btn-sm btn-success" name="submit">Filter</button>
                       </form>
                     </div>
                   </div>
                     <div class="container task">
                       <?php
                       if(isset($_POST['nameSearch'])){
                         $reminder = new Reminders();
                         $reminders = $reminder->getRemindersByName();
                         if(!$reminders){
                             echo '<p class="text-danger">No Contracts by that Name.</p>';
                         }
                       }
                        ?>
              <!--////////////////////// SEARCH CONTRACTS BY NAME \\\\\\\\\\\\\\\\\\\\\\\\\\-->
                       <form  action="" method="post">
                         <label for="nameSearch">Search By Names</label>
                         <input type="text" class="form-control" name="nameSearch" placeholder="Type A Name">
                         <button type="submit" class="btn btn-sm btn-success mt-2" name="submit"><i class="fas fa-search"></i></button>
                       </form>
                     </div>
                     <div class="container task">
        <!--////////////// SHOW ALL REMINDERS fORM AKA RESET BUTTON \\\\\\\\\\\\\\\\\\\\\\\-->
                       <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                         <input type="hidden" name="showAll">
                         <button type="submit" class="btn btn-sm btn-warning" name="submit">Reset</button>
                       </form>
                     </div>
                   </div>

                   <div class="container">
                       <!--////////////// SHOW FULL NOTES \\\\\\\\\\\\\\\\\\\\\\\-->
                     <?php
                       if($fullNote){
                         $p = new GetNotes();
                         $nameForNotes = $p->nameForNotes();
                         echo '<hr>';
                         echo '<div class="container">';
                         echo '<p class="text-danger">Your Full Note For Contract: </p>';
                         echo '<strong>' . $nameForNotes['name'] . '</strong>' . ' Location: ' . '<strong>' . $nameForNotes['location'] . '</strong><br>';
                         foreach($fullNote as $rowNote){
                           echo '<p>'.$rowNote['notes'].'</p>';
                         }
                         echo '</div>';
                       }
                       ?>
                  <!--////////////// GET ALL PDF FILES/DELETE SINGLE PDF FILE \\\\\\\\\\\\\\\\\\\\\\\-->
                     <?php

                          if($fileNames){
                          $deleteFileFormID = 'deleteFileFormID';
                          $deleteFileFormName = 'deleteFileFormName';
                          $g = new GetFile();
                          $nameForFile = $g->nameForFiles();
                            echo '<hr>';
                            echo '<div class="container">';
                            echo '<p class="text-danger">Your Files For Contract: </p>' . '<strong>' . $nameForFile['name'] . '</strong> Location: ' . '<strong>' . $nameForFile['location'] . '</strong><br>';
                            foreach($fileNames as $rowFiles){
                              echo '<div class="row"><a href="'. BASE_URL .'actions/filesUploaded/'.$rowFiles['fileName1']. '" target="_blank" class="m-2">' . $rowFiles['fileName1'] . '</a>
                              <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) .'" method="post">
                              <input type="hidden" name="' . $deleteFileFormID .'" value="' . $rowFiles['id'] . '">
                              <input type="hidden" name="' . $deleteFileFormName .'" value="' . $rowFiles['fileName1'] . '">
                              <button type="submit" class="btn btn-danger" onClick="return confirm(\'Warning: This will delete file permanently. Do you wish to proceed?\')"><i class="fas fa-times"></i></button>
                              </form><br></div>';
                             }
                            echo '</div>';
                          }
                       ?>
                   </div>

<!--////////////////////////// MAIN TABLE FOR ACTIVE REMINDERS \\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->
                   <table class="table table-hover">
                     <thead class="thead-dark">
                       <tr>
                         <th>Expiration Date</th>
                         <th>Category</th>
                         <th>Name</th>
                         <th>Location</th>
                         <th>File</th>
                         <th>Notes(if any)</th>
                         <th>Update</th>
                         <th>Mark Inactive</th>
                         <th>Action</th>
                       </tr>
                     </thead>
                     <?php if($reminders){ ?>
                       <?php foreach ($reminders as $row){ ?>
                     <tbody>

                               <tr>
                                 <td> <strong><?php echo date("M d, Y", strtotime($row['exdate'])); ?></strong> </td>
                                 <td><?php echo $row['category']; ?></td>
                                 <td><?php echo $row['name']; ?> <?php
                                 $ninety_daysFrom_now = date('Y-m-d', time() + 86400 * 90);
                                 $sixty_daysFrom_now = date('Y-m-d', time() + 86400 * 60);
                                 $thirty_daysFrom_now = date('Y-m-d', time() + 86400 * 30);
                                 $rawDate = $row['exdate'];
                                   $currentExDate = new DateTime($row['exdate']);
                                   $today = new DateTime();
                                   if($currentExDate < $today){
                                     echo '<p class="text-danger">Contract Has Expired</p>';
                                   }
                                   else if($rawDate < $thirty_daysFrom_now){
                                     echo '<p class="text-danger">Contract Expires Less Then 30 Days</p>';
                                   }
                                   else if($rawDate < $sixty_daysFrom_now){
                                     echo '<p class="text-info">Contract Expires Less Then 60 Days</p>';
                                   }
                                   else if($rawDate < $ninety_daysFrom_now){
                                     echo '<p class="text-muted">Contract Expires Less Then 90 Days</p>';
                                   };
                                  ?></td>
                                 <td>
                                   <?php echo $row['location']; ?>
                                 </td>
                                 <td>
                                   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                   <input type="hidden" name="fileId" value="<?php echo $row['id']; ?>">
                                   <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-file-download"></i></button>
                                   </form>
                                 </td>
                                 <td class="notesData">
                                   <?php echo $row['notes']; ?>
                                  <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                     <input type="hidden" name="getNotes" value="<?php echo $row['id']; ?>">
                                     <button type="submit" class="btn btn-danger btn-xs">Full Note</button>
                                   </form>
                                 </td>
                                 <td>
  <!-- ////////////////////////////// SHOW UPDATE FORM \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->

                                    <button class="btn btn-info updateBtn">
                                      <i class="fas fa-edit"></i>
                                    </button>
                                    <div class="updateForm" >
                                      <form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">

                                              <div class="form-group">
                                                <label for="addFiles">Add More Files</label>
                                                <input type="file" class="form-control-file" name="addFile[]" multiple>
                                              </div>
                                              <div class="form-group">
                                                <label for="newDate">Change Expiration Date</label>
                                                <input type="date" class="form-control" name="newDate" value="<?php echo $row['exdate'];?>">
                                              </div>
                                        <div class="form-group">
                                          <label for="addNotes">Add More Notes</label>
                                          <textarea class="form-control" name="addNotes" rows="3"></textarea>
                                        </div>
                                        <input type="hidden" name="updateId" value="<?php echo $row['id'];?>">
                                        <input type="hidden" name="fileNameId" value="<?php echo $row['fileNameID'];?>">
                                        <input type="hidden" name="currNotes" value="<?php echo $row['notes'];?>">
                                          <button class="btn btn-info btn-md mt-3 mr-4 mb-4" type="submit" name="submit"><i class="fas fa-edit"></i>  Update Reminder</button>
                                      </form>
                                    </div>
                                 </td>
                                 <td>
                                   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                   <input type="hidden" name="markAs" value="<?php echo $row['id']; ?>">
                                   <button type="submit" class="btn btn-success"><i class="fas fa-minus"></i></button>
                                 </form>
                               </td>
                                 <td>
                                   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                     <input type="hidden" name="deleteForm" value="<?php echo $row['id']; ?>">
                                     <input type="hidden" name="fileNameToDelete" value="<?php echo $row['fileNameID']; ?>">
                                     <button type="submit" class="btn btn-danger" onClick="return confirm('Warning: Deletes everything, including all files. Do you wish to proceed?')"><i class="fas fa-trash-alt"></i></button>
                                   </form>
                                 </td>
                                 </tr>
                     </tbody>
                        <?php } ?>
                       <?php } else{ echo '<h3 class="mt-4" >No Active Contracts.</h3>';};?>
                   </table>
               </div>
<!-- ||||||||||||||||||||||||| END OF ACTIVE Reminders||||||||||||||||||| -->


<!-- ||||||||||||||||||||||||| Inactive Reminders||||||||||||||||||| -->
               <div class="expirations mt-4">
                 <h3 class="text-muted">Inactive Contracts</h3>
                 <?php if($inactivereminders){ ?>
                 <table class="table table-hover table-sm text-muted">
                   <thead>
                     <tr>
                       <th>Expiration Date</th>
                       <th>Category</th>
                       <th>Name</th>
                       <th>Location</th>
                       <th>Mark Active</th>
                     </tr>
                   </thead>
                   <tbody>

                           <?php foreach ($inactivereminders as $row2){ ?>
                             <tr>
                               <td> <strong><?php echo date("M d, Y", strtotime($row2['exdate'])); ?></strong> </td>
                               <td><?php echo $row2['category']; ?></td>
                               <td><?php echo $row2['name']; ?><?php
                                 $currentExDateInactive = new DateTime($row2['exdate']);
                                 $today = new DateTime();
                                 if($currentExDateInactive < $today){
                                   echo '<p class="text-danger">Contract Has Expired</p>';
                                 };
                                ?></td>
                               <td><?php echo $row2['location']; ?></td>
                               <td>
                                 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                 <input type="hidden" name="markAsActive" value="<?php echo $row2['id']; ?>">
                                 <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i></button>
                               </form>
                             </td>
                               </tr>
                           <?php } ?>
                   </tbody>
                 </table>
               <?php }else{ echo '<h3 class="mt-4" >All contracts are currently active.</h3>';};?>
               </div>
             </div>
         </main>
           <?php require 'footer.php'; ?>
   </body>

   </html>
