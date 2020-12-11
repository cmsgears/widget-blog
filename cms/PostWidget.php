<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\widgets\club\cms;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

/**
 * PostWidget shows the most recent posts published on site.
 *
 * @since 1.0.0
 */
class PostWidget extends \cmsgears\widgets\club\base\PageWidget {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $route		= 'blog/search';
	public $allPath		= 'blog';
	public $singlePath	= 'blog';

	public $type = CmsGlobal::TYPE_POST;

	// Protected --------------

	protected $searchContent	= true;
	protected $searchCategory	= true;
	protected $searchtag		= true;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		$this->modelService = Yii::$app->factory->get( 'postService' );

		parent::init();
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Widget --------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostWidget ----------------------------

}
