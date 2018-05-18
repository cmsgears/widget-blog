<?php
namespace cmsgears\widgets\blog;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

/**
 * It shows the related posts.
 */
class RelatedPostWidget extends \cmsgears\core\common\base\PageWidget {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Path for all posts
	public $allPath			= 'blog';

	// Path for single post
	public $singlePath		= 'blog';

	public $type			= CmsGlobal::TYPE_POST;

	public $modelService	= 'postService';

	public $model			= null;

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function initModels( $config = [] ) {

		$categoryIds		= $this->model->getCategoryIdList( true );
		$tagIds				= $this->model->getTagIdList( true );

		$this->dataProvider	= Yii::$app->factory->get( 'postService' )->getPageForSimilar( [ 'categories' => $categoryIds, 'tags' => $tagIds, 'modelId' => $this->model->id ] );

		$this->modelPage	= $this->dataProvider->getModels();
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Widget --------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// cmsgears\core\common\base\Widget

	// RelatedPost ---------------------------

}
