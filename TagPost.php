<?php
namespace cmsgears\widgets\blog;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

/**
 * It shows the most recent posts published on site for a specific tag.
 */
class TagPost extends \cmsgears\core\common\base\PageWidget {

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
	public $tag				= null;

	public $modelService	= 'postService';
	public $route			= "tag";

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function initModels( $config = [] ) {

		// Get tag if not set
		if( isset( $this->slug ) && isset( $this->type ) ) {

			$tagService		= Yii::$app->factory->get( 'tagService' );
			$this->tag		= $tagService->getBySlugType( $this->slug, $this->type );
		}

		if( isset( $this->tag ) ) {

			$modelService		= Yii::$app->factory->get( $this->modelService );

			$slug				= $this->tag->slug;

			$this->dataProvider	= $modelService->getPageForSearch([
										'tag' => $this->tag,
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

	// TagPost -------------------------------

}
