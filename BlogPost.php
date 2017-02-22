<?php
namespace cmsgears\widgets\blog;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\cms\common\models\entities\Post;

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
	public $allPath			= 'blog';

	// Path for single post
	public $singlePath		= 'blog';

	// Widget - Required for widgets and works only if pagination is false. The possible values can be - popular, recent, similar, related
	public $widget			= 'recent';

	// Model in action required for widgets on single pages
	public $model;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function initModels( $config = [] ) {

		$this->postService	= Yii::$app->factory->get( 'postService' );

		// Find models for search, category and tag page
		if( $this->pagination ) {

			if( empty( $this->dataProvider ) ) {

				if( $this->excludeMain ) {

					$this->dataProvider	= $this->postService->getPageForSearch([
												'route' => 'blog/search', 'public' => true, 'excludeMainSite' => true,
												'searchContent' => true, 'searchCategory' => true, 'searchTag' => true
											]);
				}
				else if( $this->siteModels ) {

					$this->dataProvider	= $this->postService->getPageForSearch([
												'route' => 'blog/search', 'public' => true, 'siteOnly' => true,
												'searchContent' => true, 'searchCategory' => true, 'searchTag' => true
											]);
				}
				else {

					$this->dataProvider	= $this->postService->getPageForSearch([
												'route' => 'blog/search', 'public' => true,
												'searchContent' => true, 'searchCategory' => true, 'searchTag' => true
											]);
				}
			}

			$this->modelPage	= $this->dataProvider->getModels();
		}
		// Find models for popular, recent, similar, related widgets
		else {

			switch( $this->widget ) {

				// Recent posts
				case 'recent': {

					$this->modelPage	= $this->postService->getModels( [ 'advanced' => true, 'public' => true, 'limit' => $this->limit, 'sort' => [ 'id' => SORT_DESC ] ] );

					break;
				}
				// Similar posts
				case 'similar': {

					$categoryIds		= $this->model->getCategoryIdList( true );
					$tagIds				= $this->model->getTagIdList( true );

					$this->modelPage	= $this->postService->getSimilar( [ 'tags' => $tagIds, 'categories' => $categoryIds ] );

					break;
				}
			}
		}
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Widget --------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// BlogPost ------------------------------

}
