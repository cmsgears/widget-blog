<?php
namespace cmsgears\widgets\blog;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\cms\frontend\services\entities\PostService;

/**
 * It shows the most recent posts published on site.
 */
class BlogPost extends \cmsgears\core\common\base\PageWidget {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	// Path for all posts
	public $allPath			= 'posts';

	// Path for single post
	public $singlePath		= 'post';

	// Constructor and Initialisation ------------------------------

	public function initModels( $config = [] ) {

		if( $this->excludeMain ) {

			$this->dataProvider	= PostService::getPaginationForChildSites( [ 'limit' => $this->limit ] );
		}
		else if( $this->siteModels ) {

			$this->dataProvider	= PostService::getPaginationForSite( [ 'limit' => $this->limit ] );
		}
		else {

			$this->dataProvider	= PostService::getPagination( [ 'limit' => $this->limit ] );
		}

		$this->modelPage	= $this->dataProvider->getModels();
	}
}

?>