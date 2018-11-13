<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\widgets\blog\base;

// Yii Imports
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\base\PageWidget as BasePageWidget;

/**
 * PageWidget is the base widget of page models.
 *
 * @since 1.0.0
 */
abstract class PageWidget extends BasePageWidget {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $options			= [ 'class' => 'widget widget-page' ];
	public $wrapperOptions	= [ 'class' => 'box-page-wrap row max-cols-50' ];
	public $singleOptions	= [ 'class' => 'box box-page box-info col col12x6 row' ];

	public $template = 'banner';

	public $texture;

	/**
	 * Active selection of model and works only if pagination is false. The possible values
	 * can be:
	 *
	 * featured - Filtered based on featured value
	 * popular - Ordered based on popularity index
	 * recent - Order based on publish date
	 * related - Written by the same author
	 * similar - Same Category or Tag
	 * category - Given Category
	 * tag - Give Tag
	 *
	 * @var string
	 */
	public $widget = 'recent';

	public $excludeParams = [ 'slug' ];

	/**
	 * Required on single pages with [[$pagination]] set to false and [[$widget]] set to popular, recent, related or similar.
	 *
	 * Optional - popular, recent to exclude from end results
	 * Required - related or similar
	 *
	 * @var string
	 */
	public $model;

	/**
	 * Flag to enable default site banner.
	 *
	 * @var boolean
	 */
	public $defaultBanner = false;

	// Author
	public $author;
	public $authorParam = false;

	// Category
	public $category;
	public $categoryParam = false;
	public $categorySlug;
	public $categoryType;

	// Tag
	public $tag;
	public $tagParam = false;
	public $tagSlug;
	public $tagType;

	// Protected --------------

	protected $modelService;

	protected $type;

	protected $searchContent	= true;
	protected $searchCategory	= false;
	protected $searchtag		= false;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function initModels( $config = [] ) {

		// Detect Category - Used only by dynamic calls
		if( $this->categoryParam ) {

			$this->category = $this->model;
			$this->model	= null;
		}

		// Detect Tag - Used only by dynamic calls
		if( $this->tagParam ) {

			$this->tag		= $this->model;
			$this->model	= null;
		}

		// Detect Author - Used only by dynamic calls
		if( $this->authorParam ) {

			$this->author	= $this->model;
			$this->model	= null;
		}

		// Find models for search page
		if( $this->pagination ) {

			if( empty( $this->dataProvider ) ) {

				// Check Category
				if( empty( $this->category ) && isset( $this->categorySlug ) && isset( $this->categoryType ) ) {

					$categoryService	= Yii::$app->factory->get( 'categoryService' );
					$this->category		= $categoryService->getBySlugType( $this->categorySlug, $this->categoryType );
				}

				// Check Tag
				if( empty( $this->tag ) && isset( $this->tagSlug ) && isset( $this->tagType ) ) {

					$tagService		= Yii::$app->factory->get( 'tagService' );
					$this->tag		= $tagService->getBySlugType( $this->tagSlug, $this->tagType );
				}

				// Category
				if( isset( $this->category ) ) {

					$this->initCategoryModels();
				}
				// Tag
				else if( isset( $this->tag ) ) {

					$this->initTagModels();
				}
				// Author
				else if( isset( $this->author ) ) {

					$this->initAuthorModels();
				}
				// Page
				else {

					$this->initPageModels();
				}
			}

			$this->modelPage = $this->dataProvider->getModels();
		}
		// Find models for popular, recent and related widgets
		else {

			switch( $this->widget ) {

				// Featured
				case 'featured': {

					$this->initFeatured();

					break;
				}
				// Recent
				case 'recent': {

					$this->initRecent();

					break;
				}
				// Popular
				case 'popular': {

					$this->initPopular();

					break;
				}
				// Author
				case 'author': {

					$this->initAuthor( $this->author );

					break;
				}
				// Related
				case 'related': {

					$this->initAuthor( $this->model->creator );

					break;
				}
				// Similar
				case 'similar': {

					$this->initSimilar();

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

	// PageWidget ----------------------------

	protected function initCategoryModels() {

		$modelTable		= $this->modelService->getModelTable();
		$this->route	= empty( $this->route ) ? 'category' : $this->route;

		// Child Sites Only
		if( $this->excludeMain ) {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'limit' => $this->limit, 'public' => true, 'excludeMainSite' => true,
				'searchContent' => $this->searchContent, 'category' => $this->category,
				'route' => "$this->route/{$this->category->slug}",
				'parentType' => $this->type, 'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// Active Site Only
		else if( $this->siteModels ) {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'limit' => $this->limit, 'public' => true, 'siteOnly' => true,
				'searchContent' => $this->searchContent, 'category' => $this->category,
				'route' => "$this->route/{$this->category->slug}",
				'parentType' => $this->type, 'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// Specific Site Only
		else if( isset( $this->siteId ) ) {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'limit' => $this->limit, 'public' => true, 'siteOnly' => true, 'siteId' => $this->siteId,
				'searchContent' => $this->searchContent, 'category' => $this->category,
				'route' => "$this->route/{$this->category->slug}",
				'parentType' => $this->type, 'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// All Sites
		else {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'limit' => $this->limit, 'public' => true, 'ignoreSite' => true,
				'searchContent' => $this->searchContent, 'category' => $this->category,
				'route' => "$this->route/{$this->category->slug}",
				'parentType' => $this->type, 'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
	}

	protected function initTagModels() {

		$modelTable		= $this->modelService->getModelTable();
		$this->route	= empty( $this->route ) ? 'tag' : $this->route;

		// Child Sites Only
		if( $this->excludeMain ) {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'limit' => $this->limit, 'public' => true, 'excludeMainSite' => true,
				'searchContent' => $this->searchContent, 'tag' => $this->tag,
				'route' => "$this->route/{$this->tag->slug}",
				'parentType' => $this->type, 'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// Active Site Only
		else if( $this->siteModels ) {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'limit' => $this->limit, 'public' => true, 'siteOnly' => true,
				'searchContent' => $this->searchContent, 'tag' => $this->tag,
				'route' => "$this->route/{$this->tag->slug}",
				'parentType' => $this->type, 'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// Specific Site Only
		else if( isset( $this->siteId ) ) {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'limit' => $this->limit, 'public' => true, 'siteOnly' => true, 'siteId' => $this->siteId,
				'searchContent' => $this->searchContent, 'tag' => $this->tag,
				'route' => "$this->route/{$this->tag->slug}",
				'parentType' => $this->type, 'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// All Sites
		else {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'limit' => $this->limit, 'public' => true, 'ignoreSite' => true,
				'searchContent' => $this->searchContent, 'tag' => $this->tag,
				'route' => "$this->route/{$this->tag->slug}",
				'parentType' => $this->type, 'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
	}

	protected function initAuthorModels() {

		$modelTable		= $this->modelService->getModelTable();
		$this->route	= empty( $this->route ) ? 'tag' : $this->route;

		$author = $this->author;

		// Child Sites Only
		if( $this->excludeMain ) {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'limit' => $this->limit, 'public' => true, 'excludeMainSite' => true,
				'searchContent' => $this->searchContent,
				'route' => "$this->route/{$author->username}",
				'parentType' => $this->type, 'conditions' => [ "$modelTable.type" => $this->type, "$modelTable.createdBy" => $author->id ]
			]);
		}
		// Active Site Only
		else if( $this->siteModels ) {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'limit' => $this->limit, 'public' => true, 'siteOnly' => true,
				'searchContent' => $this->searchContent,
				'route' => "$this->route/{$author->username}",
				'parentType' => $this->type, 'conditions' => [ "$modelTable.type" => $this->type, "$modelTable.createdBy" => $author->id ]
			]);
		}
		// Specific Site Only
		else if( isset( $this->siteId ) ) {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'limit' => $this->limit, 'public' => true, 'siteOnly' => true, 'siteId' => $this->siteId,
				'searchContent' => $this->searchContent,
				'route' => "$this->route/{$author->username}",
				'parentType' => $this->type, 'conditions' => [ "$modelTable.type" => $this->type, "$modelTable.createdBy" => $author->id ]
			]);
		}
		// All Sites
		else {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'limit' => $this->limit, 'public' => true, 'ignoreSite' => true,
				'searchContent' => $this->searchContent,
				'route' => "$this->route/{$author->username}",
				'parentType' => $this->type, 'conditions' => [ "$modelTable.type" => $this->type, "$modelTable.createdBy" => $author->id ]
			]);
		}
	}

	public function initPageModels() {

		$modelTable = $this->modelService->getModelTable();

		$sort = new Sort([
			'attributes' => [
				'id' => [
					'asc' => [ "$modelTable.id" => SORT_ASC ],
					'desc' => [ "$modelTable.id" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Id'
				]
			],
			'defaultOrder' => [
				'id' => SORT_DESC
			]
		]);

		// Child Sites Only
		if( $this->excludeMain ) {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'route' => $this->route, 'public' => true, 'excludeMainSite' => true,
				'searchContent' => $this->searchContent, 'searchCategory' => $this->searchCategory, 'searchTag' => $this->searchtag,
				'limit' => $this->limit, 'sort' => $sort, 'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// Active Site Only
		else if( $this->siteModels ) {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'route' => $this->route, 'public' => true, 'siteOnly' => true,
				'searchContent' => $this->searchContent, 'searchCategory' => $this->searchCategory, 'searchTag' => $this->searchtag,
				'limit' => $this->limit, 'sort' => $sort, 'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// Specific Site Only
		else if( isset( $this->siteId ) ) {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'route' => $this->route, 'public' => true, 'siteOnly' => true, 'siteId' => $this->siteId,
				'searchContent' => $this->searchContent, 'searchCategory' => $this->searchCategory, 'searchTag' => $this->searchtag,
				'limit' => $this->limit, 'sort' => $sort, 'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// All Sites
		else {

			$this->dataProvider	= $this->modelService->getPageForSearch([
				'route' => $this->route, 'public' => true, 'ignoreSite' => true,
				'searchContent' => $this->searchContent, 'searchCategory' => $this->searchCategory, 'searchTag' => $this->searchtag,
				'limit' => $this->limit, 'sort' => $sort, 'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
	}

	public function initFeatured() {

		$modelTable = $this->modelService->getModelTable();

		// Child Sites Only
		if( $this->excludeMain ) {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'excludeMainSite' => true,
				'conditions' => [ "$modelTable.type" => $this->type, "$modelTable.featured" => true ]
			]);
		}
		// Active Site Only
		else if( $this->siteModels ) {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'siteOnly' => true,
				'conditions' => [ "$modelTable.type" => $this->type, "$modelTable.featured" => true ]
			]);
		}
		// Specific Site Only
		else if( isset( $this->siteId ) ) {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'siteOnly' => true, 'siteId' => $this->siteId,
				'conditions' => [ "$modelTable.type" => $this->type, "$modelTable.featured" => true ]
			]);
		}
		// All Sites
		else {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'ignoreSite' => true,
				'conditions' => [ "$modelTable.type" => $this->type, "$modelTable.featured" => true ]
			]);
		}
	}

	public function initRecent() {

		$modelTable = $this->modelService->getModelTable();

		// Child Sites Only
		if( $this->excludeMain ) {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'excludeMainSite' => true,
				'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// Active Site Only
		else if( $this->siteModels ) {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'siteOnly' => true,
				'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// Specific Site Only
		else if( isset( $this->siteId ) ) {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'siteOnly' => true, 'siteId' => $this->siteId,
				'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// All Sites
		else {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'ignoreSite' => true,
				'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
	}

	public function initPopular() {

		$modelTable = $this->modelService->getModelTable();

		// Child Sites Only
		if( $this->excludeMain ) {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'excludeMainSite' => true,
				'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// Active Site Only
		else if( $this->siteModels ) {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'siteOnly' => true,
				'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// Specific Site Only
		else if( isset( $this->siteId ) ) {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'siteOnly' => true, 'siteId' => $this->siteId,
				'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// All Sites
		else {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'ignoreSite' => true,
				'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
	}

	public function initAuthor( $author ) {

		$modelTable = $this->modelService->getModelTable();

		// Child Sites Only
		if( $this->excludeMain ) {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'excludeMainSite' => true,
				'conditions' => [ "$modelTable.type" => $this->type, "$modelTable.createdBy" => $author->id ]
			]);
		}
		// Active Site Only
		else if( $this->siteModels ) {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'siteOnly' => true,
				'conditions' => [ "$modelTable.type" => $this->type, "$modelTable.createdBy" => $author->id ]
			]);
		}
		// Specific Site Only
		else if( isset( $this->siteId ) ) {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'siteOnly' => true, 'siteId' => $this->siteId,
				'conditions' => [ "$modelTable.type" => $this->type, "$modelTable.createdBy" => $author->id ]
			]);
		}
		// All Sites
		else {

			$this->modelPage = $this->modelService->getModels([
				'advanced' => true, 'public' => true, 'limit' => $this->limit,
				'sort' => [ 'id' => SORT_DESC ], 'ignoreSite' => true,
				'conditions' => [ "$modelTable.type" => $this->type, "$modelTable.createdBy" => $author->id ]
			]);
		}
	}

	public function initSimilar() {

		$modelTable		= $this->modelService->getModelTable();
		$categoryIds	= $this->model->getCategoryIdList( true );
		$tagIds			= $this->model->getTagIdList( true );

		// Child Sites Only
		if( $this->excludeMain ) {

			$this->modelPage = $this->modelService->getSimilar([
				'modelId' => $this->model->id, 'tags' => $tagIds, 'categories' => $categoryIds,
				'limit' => $this->limit, 'excludeMainSite' => true,
				'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// Active Site Only
		else if( $this->siteModels ) {

			$this->modelPage = $this->modelService->getSimilar([
				'modelId' => $this->model->id, 'tags' => $tagIds, 'categories' => $categoryIds,
				'limit' => $this->limit, 'siteOnly' => true,
				'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// Specific Site Only
		else if( isset( $this->siteId ) ) {

			$this->modelPage = $this->modelService->getSimilar([
				'modelId' => $this->model->id, 'tags' => $tagIds, 'categories' => $categoryIds,
				'limit' => $this->limit, 'siteOnly' => true, 'siteId' => $this->siteId,
				'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
		// All Sites
		else {

			$this->modelPage = $this->modelService->getSimilar([
				'modelId' => $this->model->id, 'tags' => $tagIds, 'categories' => $categoryIds,
				'limit' => $this->limit, 'ignoreSite' => true,
				'conditions' => [ "$modelTable.type" => $this->type ]
			]);
		}
	}

}
