<?= $postsHtml ?>

<?php if( !$paging && strlen( $postsHtml ) > 0 ) { ?>
	<div class="filler-height filler-height-medium"></div>
	<div class="row align align-right right">
		<a href="<?= $allPath ?>" class="btn btn-medium">VIEW ALL</a>
	</div>
<?php } else if( strlen( $postsHtml ) <= 0 ) { ?>
	<p>No posts found.</p>
<?php } ?>

<?php if( $paging && strlen( $postsHtml ) > 0 ) { ?>
	<div class='wrap-pagination clearfix'>
		<div class='info'><?= $pageInfo ?></div> <?= $pageLinks ?>
	</div>
<?php } ?>