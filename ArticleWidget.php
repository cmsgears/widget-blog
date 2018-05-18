<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\widgets\blog;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\base\PageWidget;

/**
 * ArticleWidget shows the most recent articles published on site.
 *
 * @since 1.0.0
 */
class ArticleWidget extends PageWidget {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $options = [ 'class' => 'blog blog-banner' ];

	public $wrapperOptions = [ 'class' => 'blog-posts row max-cols-50' ];

	public $singleOptions = [ 'class' => 'blog-post col col12x6 row' ];

	public $template = 'banner';

	public $texture;

	// Path for all articles
	public $allPath = 'article';

	// Single Path
	public $singlePath = 'article';

	/**
	 * Active selection of model and works only if pagination is false. The possible values
	 * can be:
	 *
	 * popular - Ordered based on popularity index
	 * recent - Order based on publish date
	 * related - Articles written by the same author
	 *
	 * @var string
	 */
	public $widget = 'recent';

	public $excludeParams = [ 'slug' ];

	/**
	 * Required on single pages with [[$pagination]] set to false and [[$widget]] set to popular, recent or related.
	 *
	 * @var string
	 */
	public $model;

	/**
	 * Flag to enable default site banner in case banner is not available for article.
	 *
	 * @var boolean
	 */
	public $defaultBanner = false;

	// Protected --------------

	protected $modelService;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function initModels( $config = [] ) {

		$this->modelService = Yii::$app->factory->get( 'articleService' );

		$modelTable = $this->modelService->getModelTable();

		// Find models for search page
		if( $this->pagination ) {

			if( empty( $this->dataProvider ) ) {

				// Child Sites Only
				if( $this->excludeMain ) {

					$this->dataProvider	= $this->modelService->getPageForSearch([
						'route' => 'article/search', 'public' => true, 'excludeMainSite' => true,
						'searchContent' => true, 'limit' => $this->limit,
						'conditions' => [ "$modelTable.type" => CmsGlobal::TYPE_ARTICLE ]
					]);
				}
				// Active Site Only
				else if( $this->siteModels ) {

					$this->dataProvider	= $this->modelService->getPageForSearch([
						'route' => 'article/search', 'public' => true, 'siteOnly' => true,
						'searchContent' => true, 'limit' => $this->limit,
						'conditions' => [ "$modelTable.type" => CmsGlobal::TYPE_ARTICLE ]
					]);
				}
				// All Sites
				else {

					$this->dataProvider	= $this->modelService->getPageForSearch([
						'route' => 'article/search', 'public' => true, 'ignoreSite' => true,
						'searchContent' => true, 'limit' => $this->limit,
						'conditions' => [ "$modelTable.type" => CmsGlobal::TYPE_ARTICLE ]
					]);
				}
			}

			$this->modelPage = $this->dataProvider->getModels();
		}
		// Find models for popular, recent, similar, related widgets
		else {

			switch( $this->widget ) {

				// Popular articles
				case 'popular':
				// Recent articles
				case 'recent': {

					// Child Sites Only
					if( $this->excludeMain ) {

						$this->modelPage = $this->modelService->getModels([
							'advanced' => true, 'public' => true, 'limit' => $this->limit,
							'sort' => [ 'id' => SORT_DESC ], 'excludeMainSite' => true,
							'conditions' => [ "$modelTable.type" => CmsGlobal::TYPE_ARTICLE ]
						]);
					}
					// Active Site Only
					else if( $this->siteModels ) {

						$this->modelPage = $this->modelService->getModels([
							'advanced' => true, 'public' => true, 'limit' => $this->limit,
							'sort' => [ 'id' => SORT_DESC ], 'siteOnly' => true,
							'conditions' => [ "$modelTable.type" => CmsGlobal::TYPE_ARTICLE ]
						]);
					}
					// All Sites
					else {

						$this->modelPage = $this->modelService->getModels([
							'advanced' => true, 'public' => true, 'limit' => $this->limit,
							'sort' => [ 'id' => SORT_DESC ], 'ignoreSite' => true,
							'conditions' => [ "$modelTable.type" => CmsGlobal::TYPE_ARTICLE ]
						]);
					}

					break;
				}
				// Related articles
				case 'related': {

					$author = $this->model->creator;

					// Child Sites Only
					if( $this->excludeMain ) {

						$this->modelPage = $this->modelService->getModels([
							'advanced' => true, 'public' => true, 'limit' => $this->limit,
							'sort' => [ 'id' => SORT_DESC ], 'excludeMainSite' => true,
							'conditions' => [ "$modelTable.type" => CmsGlobal::TYPE_ARTICLE, "$modelTable.createdBy" => $author->id ]
						]);
					}
					// Active Site Only
					else if( $this->siteModels ) {

						$this->modelPage = $this->modelService->getModels([
							'advanced' => true, 'public' => true, 'limit' => $this->limit,
							'sort' => [ 'id' => SORT_DESC ], 'siteOnly' => true,
							'conditions' => [ "$modelTable.type" => CmsGlobal::TYPE_ARTICLE, "$modelTable.createdBy" => $author->id ]
						]);
					}
					// All Sites
					else {

						$this->modelPage = $this->modelService->getModels([
							'advanced' => true, 'public' => true, 'limit' => $this->limit,
							'sort' => [ 'id' => SORT_DESC ], 'ignoreSite' => true,
							'conditions' => [ "$modelTable.type" => CmsGlobal::TYPE_ARTICLE, "$modelTable.createdBy" => $author->id ]
						]);
					}

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

	// ArticleWidget -------------------------

}
