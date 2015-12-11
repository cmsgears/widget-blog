<?php
namespace cmsgears\widgets\blog;

use \Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\LinkPager;

// CMG Imports
use cmsgears\core\common\services\Service;
use cmsgears\cms\frontend\services\PostService;

use cmsgears\core\common\utilities\CodeGenUtil;

/**
 * It shows the most recent posts published on site.
 */
class BlogPost extends \cmsgears\core\common\base\Widget {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	/**
	 * Number of posts to be fetched at a time.
	 */
	public $limit			= Service::PAGE_LIMIT;

	public $summaryLimit	= 200; // Limits summary to 200 chars
	
	/**
	 * Show pagination if required. If it's true, it will append pagination.
	 */
	public $basePath	= 'posts';

	/**
	 * Show pagination if required. If it's true, it will append pagination.
	 */
	public $pagination	= true;

	public $excludeMain	= false; // multisite environment - exclude main site posts

	public $sitePosts	= false; // multisite environment - show only current site posts

	// Private Variables --------------------

	protected $dataProvider	= null;

	// Constructor and Initialisation ------------------------------

	// yii\base\Object

    public function init() {

        parent::init();

		// Do init tasks
    }

	// Instance Methods --------------------------------------------

	// yii\base\Widget

	/**
	 * @inheritdoc
	 */
    public function run() {

		$this->initDataProvider();
		
		return $this->renderPosts();
    }
	
	// BlogPost

	public function initDataProvider() {

		if( $this->excludeMain ) {

			$this->dataProvider	= PostService::getPaginationForChildSites( [ 'limit' => $this->limit ] );
		}
		else if( $this->sitePosts ) {

			$this->dataProvider	= PostService::getPaginationForSite( [ 'limit' => $this->limit ] );
		}
		else {

			$this->dataProvider	= PostService::getPagination( [ 'limit' => $this->limit ] );
		}
	}

	public function renderPosts() {

		// Get Posts Pagination
        $models			= $this->dataProvider->getModels();
		$postsHtml		= [];

		// Paths
		$wrapperPath	= $this->template . '/wrapper';
		$postPath		= $this->template . '/post';

        foreach( $models as $post ) {

            $postsHtml[] = $this->render( $postPath, [ 'basePath' => $this->basePath, 'summaryLimit' => $this->summaryLimit, 'post' => $post ] );
        }

		$postsHtml		= implode( '', $postsHtml );

		$content 		= '';

		if( $this->pagination ) {

			$content 	= $this->render( $wrapperPath, [ 
								'basePath' => $this->basePath, 'postsHtml' => $postsHtml, 
								'pagination' =>  $this->pagination, 'dataProvider' => $this->dataProvider 
							]);
		}
		else {

			$content	= $this->render( $wrapperPath, [ 
								'basePath' => $this->basePath, 'postsHtml' => $postsHtml, 
								'pagination' =>  $this->pagination 
							]);
		}

		return Html::tag( 'div', $content, $this->options );
	}
}

?>