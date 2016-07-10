<?php
namespace cmsgears\widgets\blog;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

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
	public $type			= CmsGlobal::TYPE_POST;
	public $tag				= null;

	// Constructor and Initialisation ------------------------------

	public function initModels( $config = [] ) {

		$tagService		= Yii::$app->factory->get( 'tagService' );
		$postService	= Yii::$app->factory->get( 'postService' );

		if( isset( $this->slug ) ) {

			$this->tag	= $tagService->getBySlugType( $this->slug, CmsGlobal::TYPE_POST );
		}

		if( isset( $this->tag ) ) {

			$slug				= $this->tag->slug;

			$this->dataProvider	= $postService->getPageForSearch([
										'tag' => $this->tag,
										'limit' => $this->limit,
										'route' => "tag/$slug"
									]);

			$this->modelPage	= $this->dataProvider->getModels();
		}
	}
}

?>