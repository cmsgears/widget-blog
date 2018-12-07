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
 * InternshipWidget shows the most recent internships published on site.
 *
 * @since 1.0.0
 */
class InternshipWidget extends \cmsgears\widgets\club\base\PageWidget {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $route = 'internship/search';

	public $allPath = 'internship';

	public $singlePath = 'internship';

	// Protected --------------

	protected $type = CareerGlobal::TYPE_INTERNSHIP;

	protected $searchContent = true;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		$this->modelService = Yii::$app->factory->get( 'internshipService' );

		parent::init();
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Widget --------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// InternshipWidget ----------------------

}
