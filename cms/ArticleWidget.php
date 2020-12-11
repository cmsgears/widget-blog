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
 * ArticleWidget shows the most recent articles published on site.
 *
 * @since 1.0.0
 */
class ArticleWidget extends \cmsgears\widgets\club\base\PageWidget {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $route = 'article/search';

	public $allPath = 'article';

	public $singlePath = 'article';

	public $type = CmsGlobal::TYPE_ARTICLE;

	// Protected --------------

	protected $searchContent = true;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		$this->modelService = Yii::$app->factory->get( 'articleService' );

		parent::init();
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Widget --------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ArticleWidget -------------------------

}
