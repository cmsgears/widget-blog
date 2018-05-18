<?php
// CMG Imports
use cmsgears\core\frontend\config\SiteProperties;

use cmsgears\core\common\utilities\CodeGenUtil;

// Post Author
$author			= $model->creator;
$avatar			= SiteProperties::getInstance()->getDefaultAvatar();
$userAvatarUrl	= CodeGenUtil::getFileUrl( $author->avatar, [ 'image' => $avatar ] );
$authorName		= $author->getName();

// Post Content
$content		= $model->modelContent;
$banner			= $widget->defaultBanner ? SiteProperties::getInstance()->getDefaultBanner() : null;
$bannerUrl		= CodeGenUtil::getMediumUrl( $content->banner, [ 'image' => $banner ] );

$modelUrl		= "$widget->singlePath/$model->slug";

$title			= !empty( $model->title ) ? $model->title : $model->name;
$publishedAt	= date( 'F d, Y', strtotime( $content->publishedAt ) );
?>
<div class="row">
	<?php if( !empty( $bannerUrl ) ) { ?>
		<div class="col col4 banner-wrap">
			<img class="fluid" src="<?= $bannerUrl ?>" />
		</div>
		<div class="col col4x3">
			<span class="title"><a href="<?= $modelUrl ?>"><?= $title ?></a></span>
		</div>
	<?php } else { ?>
		<span class="title"><a href="<?= $modelUrl ?>"><?= $title ?></a></span>
	<?php } ?>
</div>
<hr/>
<div class="row">
	<div class="col col4 avatar-wrap circled circled1">
		<img src="<?= $userAvatarUrl ?>" />
	</div>
	<div class="col col4x3">
		<p class="author"><?= $authorName ?></p>
		<p class="publish"><?= $publishedAt ?></p>
	</div>
</div>
