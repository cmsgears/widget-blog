<?php

// Yii Imports
use \Yii;
use yii\helpers\Html;

// Post Author
$author			= $post->creator;
$avatar			= $author->avatar;
$defaultAvatar	= Yii::getAlias('@web') . '/images/avatar.png';
$authorInfo		= "<span class='info'>$author->name</span>";

if( isset( $avatar ) ) {

	$avatarThumb = $avatar->getThumbUrl(); 			
	$authorInfo .= "<span class='avatar'><img class='avatar' src='$avatarThumb'></span>";
}
else { 

	$authorInfo .= "<span class='avatar'><img class='avatar' src='$defaultAvatar'></span>";
}

$authorInfo	   .= "<span class='info'>$author->name</span>";

// Post Content
$content		= $post->content;
$banner			= $content->banner;
$title			= Html::a( $post->name, [ '/post/' . $post->slug ] );
$view			= Html::a( 'VIEW POST', [ '/post/' . $post->slug ], [ 'class' => 'btn' ] );
$summary		= $content->summary;
$postTime		= $content->publishedAt;
$postHtml		= "";

if( isset( $banner ) ) {

	$bannerUrl	 = $banner->getThumbUrl();
	$bannerUrl	 = Html::a( "<img class='fluid' src='$bannerUrl' />", [ '/post/' . $post->slug ] );
	$postHtml	.= "<div class='banner'>$bannerUrl</div><div class='post-content'>";
}
else {

	$postHtml	.= "<div class='post-content full'>";
}

$postHtml	.= "	<h2 class='post-header'>$title</h2>
					<div class='summary'>$summary</div>
					<div class='info clearfix'>
						<span class='author'>$authorInfo</span>
						<span class='time'>$postTime</span>
					</div>
				</div>";

echo Html::tag( 'div', $postHtml, [ 'class' => 'post' ] );
?>