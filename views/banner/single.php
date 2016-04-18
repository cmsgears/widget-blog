<?php
// Yii Imports
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\utilities\CodeGenUtil;

// Post Author
$author			= $model->creator;
$avatar			= CodeGenUtil::getImageThumbTag( $author->avatar, [ 'image' => 'avatar.png' ] );

// Post Content
$content		= $model->content;
$banner			= CodeGenUtil::getFileUrl( $content->banner, [ 'image' => 'banner.jpg' ] );

$url			= "$widget->singlePath/$model->slug";
?>

<div class="post">
	<div class="post-banner" style="<?php if( strlen( $banner ) > 0 ) echo "background-image: url( $banner )"; ?>">
		<a href="<?= $url ?>">
			<div class="texture texture-default"></div>
			<div class="post-view">
				<div class="post-view-content valign-center">
					<i class="icon cmti cmti-5x cmti-eye"></i>
				</div>
			</div>
		</a>
	</div>

	<div class="wrap-post-content">
		<h2 class="post-title"><a href="<?= $url ?>"><?= $model->name ?></a></h2>
		<div class="post-content"><?= $content->getLimitedSummary( $widget->textLimit ) ?></div>
		<div class="post-info max-cols clearfix">
			<div class="post-author col3x2">
				<span class="post-author-avatar circled1"><a href="<?= $url ?>"><?= $avatar ?></a></span>
				<span class="post-author-info"><?= $author->getName() ?></span>
			</div>
			<div class="publish-time col3"><?= $content->publishedAt ?></div>
		</div>
	</div>
</div>