<?php

// Yii Imports
use \Yii;
use yii\helpers\Html;

// Post Author
$author			= $post->author;
$avatar			= $author->avatar;
$defaultAvatar	= Yii::getAlias('@web') . "/images/avatar.png";
$authorInfo		= "";
 
$authorInfo	.= "<span class='info'>$author->name</span>";

// Post Author
$banner			= $post->banner;
$title			= Html::a( $post->name, [ '/post/' . $post->slug ] );
$view			= Html::a( 'VIEW POST', [ '/post/' . $post->slug ], [ 'class' => 'btn' ] );
$summary		= $post->summary;
$postTime		= $post->publishedAt;
$postHtml		= ""; 

if( isset( $banner ) ) {

	$bannerUrl	 = $banner->getFileUrl();			
	
	switch( $pageType ) {
		
		case 'home': {
			
			$bannerUrl	 = Html::a( "<img class='fluid home' src='$bannerUrl' />", [ '/post/' . $post->slug ] );
				
			$postHtml	.= "<div class='col12x3 sidebar'>
						<div class='date'>
							<p class='day'>25</p>
							<p class='month'>JUNE-15</p>
						</div>
						<div class='comment align-middle'>
							<p>235</p>
							<p class='fa fa-comments'></p>
						</div>
					</div>
					<div class='col12x9 media align-middle'> 
						$bannerUrl
						<div class='hover-content frm-rounded-all'>
							<div class='icon fa fa-pencil'></div>
							<p>$summary</p>
							$view
						</div>	
					</div>
					<div class='col12x3'></div>
					<div class='col12x9'><h2 class='title-medium'> $title </h2></div>";	
			
			break;
		}	
			
		case 'blog': {
			
			$bannerUrl	 = Html::a( "<img class='fluid' src='$bannerUrl' />", [ '/post/' . $post->slug ] );
				
			$postHtml	.= "<div class='colf12x3 sidebar'>
						<div class='date'>
							<p class='day'>25</p>
							<p class='month'>JUNE-15</p>
						</div>
						<div class='comment align-middle'>
							<p>235</p>
							<p class='fa fa-comments'></p>
						</div>
					</div>
					<div class='col1 media align-middle'> 
						$bannerUrl
						<div class='hover-content frm-rounded-all'>
							<div class='icon fa fa-pencil'></div>
							<p>$summary</p>
							$view
						</div>	
					</div>
					<div class='colf12x3'></div>
					<div class='colf12x9'><h2 class='title-medium'> $title </h2></div>";	
			
			break;
		}	
	}	 
}
else {
	$postHtml	.= "<div class='post-content full'>";
}

echo Html::tag( 'div', $postHtml, [ 'class' => 'post row clearfix' ] );
?>