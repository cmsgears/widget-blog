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
 * PageWidget shows the most recent pages published on site.
 *
 * @since 1.0.0
 */
class PageWidget extends \cmsgears\widgets\club\base\PageWidget {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $route = 'page/search';

	public $allPath = 'page';

	public $singlePath = null;

	public $type = CmsGlobal::TYPE_PAGE;

	public $parentType = CmsGlobal::TYPE_PAGE;

	// Protected --------------

	protected $searchContent = true;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		$this->modelService = Yii::$app->factory->get( 'pageService' );

		parent::init();
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Widget --------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PageWidget ----------------------------

}
