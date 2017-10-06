<?php
namespace cmsgears\widgets\blog;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\services\entities\UserService;
use cmsgears\cms\frontend\services\entities\PostService;

/**
 * It shows the most recent posts published on site for a specific author. Author must provide a valid username while doing registration or update it later.
 */
class AuthorPost extends \cmsgears\core\common\base\PageWidget {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	// Path for all posts
	public $allPath			= 'posts';

	// Path for single post
	public $singlePath		= 'post';

	public $slug			= null;
	public $username		= null;

	// Private Variables -------------------

	private $user			= null;

	// Constructor and Initialisation ------------------------------

	public function initModels( $config = [] ) {

		if( isset( $this->username ) ) {

			$this->user	= UserService::findByUsername( $this->username );
		}

		if( isset( $this->user ) ) {

			$slug				= $this->user->username;

			$this->dataProvider	= PostService::getPaginationForSearch([
										'tag' => $this->tag,
										'limit' => $this->limit,
										'route' => "author/$slug"
									]);
			$this->modelPage	= $this->dataProvider->getModels();
		}
	}
}

?>