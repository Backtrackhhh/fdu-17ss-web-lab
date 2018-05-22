<?php

function generateLink($url, $label, $class) {
   $link = '<a href="' . $url . '" class="' . $class . '">';
   $link .= $label;
   $link .= '</a>';
   return $link;
}


function outputPostRow($number)  {
    include("travel-data.inc.php"); $postId = ${"postId".$number};$thumb = ${"thumb".$number}; $userId = ${"userId".$number};$title = ${"title".$number};
   $userName = ${"userName".$number};$date = ${"date".$number}; $excerpt = ${"excerpt".$number};
    $reviewsNum = ${"reviewsNum".$number};$reviewsRating = ${"reviewsRating".$number};
    $item = '<div class="row"><div class="col-md-4"><a href="post.php?id=' . $postId . '">'
    . '<img src="images/' . $thumb . '" alt="' . $title . '" class="img-responsive"/></a></div>';
    $item .= '<div class="col-md-8"><h2>' . $title . '</h2>';
    $item .= '<div class="details">Posted by' . generateLink("user.php?id=" . $userId, $userName, "")
    . '<span class="pull-right">' . $date . '</span><p class="ratings">'
    . constructRating($reviewsRating) .$reviewsNum ." Reviews" . "</p></div>";
    $item .= '<p class="excerpt">' . $excerpt . "</p><p>" . generateLink("post.php?id=" . $postId,
    "Read more", "btn btn-primary btn-sm") . "</p></div></div><hr/>";
    print $item;
}

/*
  Function constructs a string containing the <img> tags necessary to display
  star images that reflect a rating out of 5
*/
function constructRating($rating) {
    $imgTags = "";
    
    // first output the gold stars
    for ($i=0; $i < $rating; $i++) {
        $imgTags .= '<img src="images/star-gold.svg" width="16" />';
    }
    
    // then fill remainder with white stars
    for ($i=$rating; $i < 5; $i++) {
        $imgTags .= '<img src="images/star-white.svg" width="16" />';
    }    
    
    return $imgTags;    
}

?>
