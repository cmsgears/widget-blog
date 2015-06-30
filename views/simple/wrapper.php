			$pagination		= $dataProvider->getPagination();
			$pageInfo	= CodeGenUtil::getPaginationDetail( $dataProvider );
			$pageLinks	= LinkPager::widget( [ 'pagination' => $pagination ] );
			$pagination	= "<div class='wrap-pagination clearfix'>
								<div class='info'>$pageInfo</div>
								$pageLinks
						   </div>";