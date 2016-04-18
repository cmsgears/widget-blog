<?php
namespace cmsgears\widgets\blog;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\services\resources\CategoryService;
use cmsgears\cms\frontend\services\entities\PostService;

/**
 * It shows the most recent posts published on site for a specific category.
 */
class CategoryPost extends \cmsgears\core\common\base\PageWidget {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	// Path for all posts
	public $allPath			= 'posts';

	// Path for single post
	public $singlePath		= 'post';

	public $slug			= null;
	public $type			= null;
	public $category		= null;

	// Constructor and Initialisation ------------------------------

	public function initModels( $config = [] ) {

		if( isset( $this->slug ) && isset( $this->type ) ) {

			$this->category	= CategoryService::findBySlugType( $this->slug, $this->type );
		}

		if( isset( $this->category ) ) {

			$slug				= $this->category->slug;

			$this->dataProvider	= PostService::getPaginationForSearch([
										'category' => $this->category,
										'limit' => $this->limit,
										'route' => "category/$slug"
									]);
			$this->modelPage	= $this->dataProvider->getModels();
		}
	}
}

?>