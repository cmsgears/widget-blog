<?php
// Yii Imports
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\frontend\config\SiteProperties;
use cmsgears\core\common\utilities\CodeGenUtil;

// Post Content
$content	= $model->modelContent;
$banner		= $widget->defaultBanner ? SiteProperties::getInstance()->getDefaultBanner() : null;
$bannerUrl	= CodeGenUtil::getMediumUrl( $content->banner, [ 'image' => $banner ] );

$modelUrl	= isset( $widget->singlePath ) ? "$widget->singlePath/$model->slug" : Url::toRoute( [ "/$model->slug" ], true );
?>

<div class="bkg-element-small" title="<?= $model->displayName ?>">
	<a href="<?= $modelUrl ?>" class="blog-post">
		<img src="<?= $bannerUrl ?>" />
	</a>
</div>
