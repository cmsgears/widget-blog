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

class BlogPost extends \cmsgears\core\common\widgets\BaseWidget {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	/**
	 * Number of posts to be fetched at a time.
	 */
	public $limit		= Service::PAGE_LIMIT;

	/**
	 * Show pagination if required. If it's true, it will append pagination.
	 */
	public $pagination	= true;

	// Private Variables --------------------

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

		// Get Posts Pagination
		$dataProvider	= PostService::getPagination( [ 'limit' => $this->limit ] );
        $models			= $dataProvider->getModels();
		$postsHtml		= [];

		// Paths
		$wrapperPath	= $this->viewFile . "/wrapper";
		$postPath		= $this->viewFile . "/post";

        foreach( $models as $post ) {

            $postsHtml[] = $this->render( $postPath, [ 'post' => $post ] );
        }

		$postsHtml		= implode( "\n", $postsHtml );

		$content 		= '';

		if( $this->pagination ) {

			$content 	= $this->render( $wrapperPath, [ 'postsHtml' => $postsHtml, 'dataProvider' => $dataProvider ] );
		}

		$content 		= $this->render( $wrapperPath, [ 'postsHtml' => $postsHtml ] );

		return Html::tag( 'div', $content, $this->options );
    }
}

?>