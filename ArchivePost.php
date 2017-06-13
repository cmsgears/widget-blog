<?php
namespace cmsgears\widgets\blog;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\cms\frontend\services\entities\PostService;

/**
 * It shows the posts arranged in year and month.
 */
class ArchivePost extends \cmsgears\core\common\base\PageWidget {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	// Path for all posts
	public $allPath			= 'posts';

	// Path for single post
	public $singlePath		= 'post';

	// Private Variables -------------------

	// Constructor and Initialisation ------------------------------

	public function initModels( $config = [] ) {

	}
}
