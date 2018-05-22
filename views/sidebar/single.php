<?php
// Yii Imports
use yii\helpers\Url;

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

$modelUrl		= isset( $widget->singlePath ) ? "$widget->singlePath/$model->slug" : Url::toRoute( [ "/$model->slug" ], true );

$title			= !empty( $model->title ) ? $model->title : $model->name;
$publishedAt	= date( 'F d, Y', strtotime( $content->publishedAt ) );
?>
<div class="card-header row">
	<?php if( !empty( $bannerUrl ) ) { ?>
		<div class="card-header-icon col col4">
			<div class="bkg-element-small">
				<img src="<?= $bannerUrl ?>" />
			</div>
		</div>
		<div class="card-header-title col col4x3">
			<a href="<?= $modelUrl ?>"><?= $title ?></a>
		</div>
	<?php } else { ?>
		<div class="card-header-title">
			<a href="<?= $modelUrl ?>"><?= $title ?></a>
		</div>
	<?php } ?>
</div>
<hr/>
<div class="card-footer row">
	<div class="card-footer-icon inline-block">
		<div class="avatar-wrap circled circled1">
			<img class="fluid" src="<?= $userAvatarUrl ?>" />
		</div>
	</div>
	<div class="card-footer-info inline-block margin margin-small-h">
		<p><?= $authorName ?></p>
		<p>
			<i class="cmti cmti-calendar"></i>
			<span class="inline-block margin margin-h"><?= $publishedAt ?></span>
		</p>
	</div>
</div>
