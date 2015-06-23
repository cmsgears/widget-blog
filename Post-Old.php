<?php
namespace cmsgears\cms\widgets;

// Yii Imports
use \Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\LinkPager;

// CMG Imports
use cmsgears\cms\frontend\services\PostService;

use cmsgears\core\common\utilities\CodeGenUtil;

class Post extends Widget {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

    public $options = [];

    public $uploadUrl;

	// Constructor and Initialisation ------------------------------
	
	// yii\base\Object

    public function init() {

        parent::init();
    }

	// Instance Methods --------------------------------------------

	// yii\base\Widget

    public function run() {

        echo $this->renderPosts();
    }

	// Nav

    public function renderPosts() {
		
		$this->uploadUrl	= Yii::$app->fileManager->uploadUrl;

		// Check whether user is logged in
		$user				= Yii::$app->user->getIdentity();
		$userId				= 0;

		if( isset( $user ) ) {
			
			$userId	= $user->getId();
		}

		// Get Posts Pagination
        $postsPage	= PostService::getPagination();
        $page		= $postsPage['page'];
        $pages		= $postsPage['pages'];
        $total		= $postsPage['total'];
		$postsHtml	= [];

        foreach( $page as $post ) {

            $postsHtml[] = $this->renderPost( $post );
        }
		
		$pageInfo	= CodeGenUtil::getPaginationDetail( $pages, $page, $total );
		$pageLinks	= LinkPager::widget( [ 'pagination' => $pages ] );
		$pagination	= "<div class='wrap-pagination clearfix'>
							<div class='info'>$pageInfo</div>
							$pageLinks
					   </div>";

        return Html::tag( 'div', implode( "\n", $postsHtml ) . $pagination, $this->options );
    }

    public function renderPost( $post ) {
		
		// Post Author
		$author			= $post->author;
		$avatar			= $author->avatar;
		$defaultAvatar	= Yii::getAlias('@web') . "/images/avatar.png";
		$authorInfo		= "";

		if( isset( $avatar ) ) {
 			
 			$avatarThumb = $coreProperties->getUploadUrl() . $avatar->getThumb(); 			
			$authorInfo .= "<span class='avatar'><img class='avatar' src='$avatarThumb'></span>";
		} 
		else { 

			$authorInfo .= "<span class='avatar'><img class='avatar' src='$defaultAvatar'></span>";
		}

		$authorInfo	.= "<span class='info'>$author->name</span>";

		// Post Author
		$banner			= $post->banner;
		$title			= Html::a( $post->name, [ '/post/' . $post->slug ] );
		$summary		= $post->summary;
		$postTime		= $post->publishedAt;
		$postHtml		= "";

		if( isset( $banner ) ) {

			$bannerUrl	 = $banner->getThumbUrl();
			$bannerUrl	 = Html::a( "<img class='fluid' src='$bannerUrl' />", [ '/post/' . $post->slug ] );
			$postHtml	.= "<div class='banner'>$bannerUrl</div><div class='post-content'>";
		}
		else {
			$postHtml	.= "<div class='post-content full'>";
		}

		$postHtml	.= "	<h2 class='header'>$title</h2>
							<div class='summary'>$summary</div>
							<div class='info clearfix'>
								<span class='author'>$authorInfo</span>
								<span class='time'>$postTime</span>
							</div>
						</div>";

        return Html::tag( 'div', $postHtml, [ 'class' => 'post' ] );
    }
}

?>