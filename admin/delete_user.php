<?php include("includes/header.php"); ?>
<?php if (!$session->is_signed_in()) { redirect("login.php"); } ?>

<?php

// If you can't find the ID, then redirect back
if(empty($_GET['id'])) {
    redirect("users.php");
}

// Finds the ID for that specific user
$user = User::find_by_id($_GET['id']);

// If the ID has been found, delete the user or else redirect back
if($user) {
    $session->message("The user {$user->username} has been deleted.");
    $user->delete_photo();
    redirect("users.php");
} else {
    redirect("users.php");
}

?>