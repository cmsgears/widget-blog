<?php
namespace cmsgears\widgets\blog;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

/**
 * It shows the most recent posts published on site.
 */
class BlogPost extends \cmsgears\core\common\base\PageWidget {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	protected $postService;

	// Variables -----------------------------

	// Public -----------------

	// Path for all posts
	public $allPath			= 'posts';

	// Path for single post
	public $singlePath		= 'post';

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function initModels( $config = [] ) {

		$this->postService	= Yii::$app->factory->get( 'postService' );

		if( $this->excludeMain ) {

			$this->dataProvider	= $this->postService->getPublicPageForChildSites( [ 'limit' => $this->limit ] );
		}
		else if( $this->siteModels ) {

			$this->dataProvider	= $this->postService->getPage( [ 'limit' => $this->limit, 'multiSite' => true ] );
		}
		else {

			$this->dataProvider	= $this->postService->getPage( [ 'limit' => $this->limit, 'multiSite' => false ] );
		}

		$this->modelPage	= $this->dataProvider->getModels();
	}


	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Widget --------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// BlogPost ------------------------------
}
