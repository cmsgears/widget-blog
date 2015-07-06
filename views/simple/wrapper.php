<?php
// Yii Imports
use yii\widgets\LinkPager;

// CMG Imports
use cmsgears\core\common\utilities\CodeGenUtil;

echo $postsHtml;

if( isset( $dataProvider ) ) {

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