<?php
namespace cmsgears\widgets\blog;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

/**
 * It shows the most recent posts published on site for a specific category.
 */
class CategoryPostWidget extends \cmsgears\core\common\base\PageWidget {

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

	public $slug			= null;
	public $type			= CmsGlobal::TYPE_POST;
	public $category		= null;

	public $modelService	= 'postService';
	public $route			= 'category';

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function initModels( $config = [] ) {

		// Get category if not set
		if( isset( $this->slug ) && isset( $this->type ) ) {

			$categoryService	= Yii::$app->factory->get( 'categoryService' );
			$this->category		= $categoryService->getBySlugType( $this->slug, $this->type );
		}

		if( isset( $this->category ) ) {

			$modelService		= Yii::$app->factory->get( $this->modelService );

			$slug				= $this->category->slug;

			$this->dataProvider	= $modelService->getPageForSearch([
										'public' => true,
										'category' => $this->category,
										'limit' => $this->limit,
										'route' => "$this->route/$slug",
										'parentType' => $this->type
									]);

			$this->modelPage	= $this->dataProvider->getModels();
		}
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Widget --------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// cmsgears\core\common\base\Widget

	// CategoryPost --------------------------

}
