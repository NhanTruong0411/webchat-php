<?php


// File upload path
// Allow certain file formats
$allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
if (in_array($file_type, $allowTypes)) {
   // Upload file to server
   if (move_uploaded_file($_FILES["avatar_name"]["tmp_name"], $target_file)) {
      // Insert image file name into database
      $user_password_change = array('avatar' => $target_file);
      $insert = $user->update($_SESSION['user']['user_id'], $user_password_change);
      if ($insert) {
         $statusMsg = "The file " . $fileName . " has been uploaded successfully.";
      } else {
         $statusMsg = "File upload failed, please try again.";
      }
   } else {
      $statusMsg = "Sorry, there was an error uploading your file.";
   }
} else {
   $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
}

?>
