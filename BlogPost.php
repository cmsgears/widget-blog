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

class BlogPost extends Widget {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	/**
	 * The html options for the parent container.
	 */
	public $options;

	/**
	 * The path at which view file is located. It can have alias. By default it's the views folder within widget directory.
	 */
	public $viewPath	= null;

	/**
	 * The view file used to render widget.
	 */
	public $view		= 'simple';

	/**
	 * Number of posts to be fetched at a time.
	 */
	public $limit		= Service::PAGE_LIMIT;

	/**
	 * Show pagination if required. If it's true, it will append pagination.
	 */
	public $pagination	= false;

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
	 * The method returns the view path for this widget if set while calling widget. 
	 */
	public function getViewPath() {

		if( isset( $this->viewPath ) ) {

			return $this->viewPath;
		}

		return parent::getViewPath();
	}

	/**
	 * @inheritdoc
	 */
    public function run() {

		// Get Posts Pagination
		$dataProvider	= PostService::getPagination( [ 'conditions' => [ 'limit' => $this->limit ] ] );
        $models			= $dataProvider->getModels();
		$postsHtml		= [];

		// Paths
		$wrapperPath	= $this->view . "/wrapper";
		$postPath		= $this->view . "/post";

        foreach( $models as $post ) {

            $postsHtml[] = $this->render( $postPath, [ 'post' => $post ] );
        }

		$postsHtml		= implode( "\n", $postsHtml );

		if( $this->pagination ) {

			return $this->render( $wrapperPath, [ 'postsHtml' => $postsHtml, 'dataProvider' => $dataProvider ] );
		}

		return $this->render( $wrapperPath, [ 'postsHtml' => $postsHtml ] );
    }
}

?>