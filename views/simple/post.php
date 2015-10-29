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

	$avatarThumb  = $avatar->getThumbUrl(); 			
	$avatarThumb = "<span class='left'><img class='avatar fluid' src='$avatarThumb'></span>";
}
else { 

	$avatarThumb = "<span class='left'><img class='avatar fluid' src='$defaultAvatar'></span>";
} 

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

	$postHtml	.= "<div class='post-content full row clearfix max-cols-100'>";
}

$postHtml	.= "		<div class='col1'>
							<h6 class='post-header'>$title</h6>
						</div>	
						<div class='col1 row clearfix'>
							<div class='col12x2'>
								<span class='author'$avatarThumb</span>
							</div>
							<div class='col12x10 row clearfix'>
								<div class='col12x6'>
									<span class='time'>$authorInfo</span>
								</div>
								<div class='col12x6 align align-right'>
									<span class='time'>$postTime</span>
								</div>	
								<div class='col1'>
									<div class='summary'>$summary</div>
								</div>			
							</div>	
						</div>	
					</div>
				</div>";

echo Html::tag( 'div', $postHtml, [ 'class' => 'post' ] );
?>