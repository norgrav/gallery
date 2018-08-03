<?php include("includes/header.php"); ?>
<?php if (!$session->is_signed_in()) { redirect("login.php"); } ?>

<?php

// If you can't find the ID, then redirect back
if(empty($_GET['id'])) {
    redirect("comment_photo.php?id={$comment->photo_id}");
}

// Finds the ID for that specific comment
$comment = Comment::find_by_id($_GET['id']);

// If the ID has been found, delete the comment or else redirect back
if($comment) {
    $comment->delete();
    $session->message("The comment with ID {$comment->id} has been deleted.");
    redirect("comment_photo.php?id={$comment->photo_id}");
} else {
    redirect("comment_photo.php?id={$comment->photo_id}");
}

?>