<?php
namespace cmsgears\widgets\blog;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\services\resources\TagService;
use cmsgears\cms\frontend\services\entities\PostService;

/**
 * It shows the most recent posts published on site for a specific tag.
 */
class TagPost extends \cmsgears\core\common\base\PageWidget {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	// Path for all posts
	public $allPath			= 'posts';

	// Path for single post
	public $singlePath		= 'post';

	public $slug			= null;
	public $tag				= null;

	// Constructor and Initialisation ------------------------------

	public function initModels( $config = [] ) {

		if( isset( $this->slug ) ) {

			$this->tag	= TagService::findBySlug( $this->slug );
		}

		if( isset( $this->tag ) ) {

			$slug				= $this->tag->slug;

			$this->dataProvider	= PostService::getPaginationForSearch([
										'tag' => $this->tag,
										'limit' => $this->limit,
										'route' => "tag/$slug"
									]);
			$this->modelPage	= $this->dataProvider->getModels();
		}
	}
}

?>