<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\widgets\club\career;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\career\common\config\CareerGlobal;

/**
 * JobWidget shows the most recent jobs published on site.
 *
 * @since 1.0.0
 */
class JobWidget extends \cmsgears\widgets\club\base\PageWidget {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $route = 'job/search';

	public $allPath = 'job';

	public $singlePath = 'job';

	// Protected --------------

	protected $type = CareerGlobal::TYPE_JOB;

	protected $searchContent = true;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		$this->modelService = Yii::$app->factory->get( 'jobService' );

		parent::init();
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Widget --------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// JobWidget -----------------------------

}
