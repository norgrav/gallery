<?php include("includes/header.php"); ?>
<?php if (!$session->is_signed_in()) { redirect("login.php"); } ?>

<?php

// If you can't find the ID, then redirect back
if(empty($_GET['id'])) {
    redirect("photos.php");
}

// Finds the ID for that specific photo
$photo = Photo::find_by_id($_GET['id']);

// If the ID has been found, delete the photo or else redirect back
if($photo) {
    $photo->delete_photo();
    $session->message("The {$photo->filename} has been deleted.");
    redirect("photos.php");
} else {
    redirect("photos.php");
}

?>