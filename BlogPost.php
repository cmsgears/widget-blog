<?php
namespace cmsgears\widgets\blog;

use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;
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

	// Path for all posts
	public $allPath		= 'posts';

	// Path for single post
	public $singlePath	= 'post';

	// Pagination
	public $paging			= true;
	public $limit			= Service::PAGE_LIMIT; 
	public $pageInfo		= null;
	public $pageLinks		= null;

	// Limit text displayed
	public $summaryLimit	= 200; // Limits summary to 200 chars

	// Filter Posts	- multisite environment
	public $excludeMain	= false; // exclude main site posts
	public $sitePosts	= false; // show only current site posts

	// Private Variables --------------------

	protected $dataProvider	= null;
	protected $models		= [];

	// Constructor and Initialisation ------------------------------

	// yii\base\Object

    public function init() {

        parent::init();

		$this->initDataProvider();

		// Initialise models
		$dataProvider	= $this->dataProvider;
		$this->models	= $dataProvider->getModels();

		if( $this->paging ) {

			$pagination			= $dataProvider->getPagination();
			$this->pageInfo		= CodeGenUtil::getPaginationDetail( $dataProvider );
			$this->pageLinks	= LinkPager::widget( [ 'pagination' => $pagination ] );
		}
    }

	// Instance Methods --------------------------------------------

	// yii\base\Widget

	/**
	 * @inheritdoc
	 */
    public function run() {

		return $this->renderWidget();
    }

	// cmsgears\core\common\base\Widget

	public function renderWidget( $config = [] ) {

		// Get Posts Pagination
		$postsHtml		= [];

		// Paths
		$wrapperPath	= $this->template . '/wrapper';
		$postPath		= $this->template . '/post';

		$models			= $this->models;

		if( Yii::$app->cmgCore->multiSite && Yii::$app->cmgCore->subDirectory ) {

			$siteName			= Yii::$app->cmgCore->getSiteName();
			$this->allPath		= Url::toRoute( [ "/$siteName/$this->allPath" ], true );
			$this->singlePath	= Url::toRoute( [ "/$siteName/$this->singlePath" ], true );
		}
		else {

			$this->allPath		= Url::toRoute( [ "/$this->allPath" ], true );
			$this->singlePath	= Url::toRoute( [ "/$this->singlePath" ], true );
		}

        foreach( $models as $post ) {

			$url			= "$this->singlePath/$post->slug";
            $postsHtml[] 	= $this->render( $postPath, [ 'post' => $post, 'url' => $url, 'summaryLimit' => $this->summaryLimit ] );
        }

		$postsHtml		= implode( '', $postsHtml );

		$content		= $this->render( $wrapperPath, [
								'allPath' => $this->allPath, 'postsHtml' => $postsHtml, 
								'paging' =>  $this->paging, 'pageInfo' =>  $this->pageInfo, 'pageLinks' =>  $this->pageLinks 
							]);

		return Html::tag( 'div', $content, $this->options );
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
}

?>