<?php
// Yii Imports
use \Yii;
use yii\widgets\LinkPager;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\utilities\CodeGenUtil;
?>

<?=$postsHtml?>

<?php 
	if( !$pagination && strlen( $postsHtml ) > 0 ) {

		$postsUrl	= Url::toRoute( [ '/$basePath' ] );

		if( Yii::$app->cmgCore->multiSite && Yii::$app->cmgCore->subDirectory ) {

			$siteName	= Yii::$app->cmgCore->getSiteName();
			$postsUrl	= Url::toRoute( [ "/$siteName/$basePath" ] );
		}
?>
	<div class="post-all">
		<a href="<?=$postsUrl?>">View All</a>
	</div>
<?php } else if( strlen( $postsHtml ) <= 0 ) { ?>
	<p>No posts found.</p>
<?php } ?>

<?php

if( $pagination && strlen( $postsHtml ) > 0 && isset( $dataProvider ) ) {

	$pagination	= $dataProvider->getPagination();
	$pageInfo	= CodeGenUtil::getPaginationDetail( $dataProvider );
	$pageLinks	= LinkPager::widget( [ 'pagination' => $pagination ] );
	$pagination	= "<div class='wrap-pagination clearfix'>
						<div class='info'>$pageInfo</div>
						$pageLinks
				   </div>";

	echo $pagination; 
}
?>