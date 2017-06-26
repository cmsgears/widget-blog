<?php
// Yii Imports
use yii\helpers\Html;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\frontend\config\SiteProperties;
use cmsgears\core\common\utilities\CodeGenUtil;

// Post Author
$author			= $model->creator;
$avatar			= SiteProperties::getInstance()->getUserAvatar();
$avatar			= CodeGenUtil::getImageThumbTag( $author->avatar, [ 'image' => $avatar ] );
$authorName		= $author->getName();

// Post Content
$content		= $model->modelContent;
$banner			= SiteProperties::getInstance()->getDefaultBanner();
$bannerUrl		= CodeGenUtil::getFileUrl( $content->banner, [ 'image' => $banner ] );

$modelUrl		= "$widget->singlePath/$model->slug";
?>

<div class="post-banner" style="<?php if( strlen( $bannerUrl) > 0 ) echo "background-image: url( $bannerUrl )"; ?>">
	<a href="<?= $modelUrl ?>">
		<div class="texture texture-default"></div>
		<div class="post-view">
			<div class="post-view-content valign-center">
				<i class="icon cmti cmti-2x cmti-eye"></i>
			</div>
		</div>
	</a>
</div>

<div class="wrap-post-content">
	<h2 class="post-title"><a href="<?= $modelUrl ?>"><?= $model->name ?></a></h2>
	<div class="post-content reader"><?= $content->getLimitedSummary( $widget->textLimit ) ?></div>
	<div class="post-info row max-cols-50">
		<div class="post-author col col3x2">
			<span class="post-author-avatar circled1"><a href="<?= $modelUrl?>"><?= $avatar ?></a></span>
			<span class="post-author-info"><?= $authorName ?></span>
		</div>
		<div class="publish-time col col3"><?= $content->publishedAt ?></div>
	</div>
</div>
