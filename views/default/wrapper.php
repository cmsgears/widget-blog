<?php
// Yii Imports
use yii\helpers\Html;
?>

<?php if( strlen( $modelsHtml ) > 0 ) { ?>

	<div <?= Html::renderTagAttributes( $widget->wrapperOptions ) ?>>
		<?= $modelsHtml ?>
	</div>

	<?php if( $widget->pagination && $widget->paging ) { ?>
		<div class="filler-height filler-height-medium"></div>
		<div class="pagination-full clearfix">
			<div class="info">
				<?= $widget->pageInfo ?>
			</div>
			<div class="page-links">
				<?= $widget->pageLinks ?>
			</div>
		</div>
	<?php } ?>

	<?php if( $widget->showAllPath ) { ?>
		<div class="filler-height filler-height-medium"></div>
		<div class="wrap-all">
			<a href="<?= $widget-allPath ?>" class="btn btn-medium">VIEW ALL</a>
		</div>
	<?php } ?>

<?php } else { ?>
	<p>No posts found.</p>
<?php } ?>