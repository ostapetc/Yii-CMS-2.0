<?php
class YouTubeApiCriteria extends ApiCriteria
{
    const ORDER_VIEW_COUNT     = 'viewCount';
    const ORDER_LIKE_COUNT     = 'likeCount';
    const ORDER_DISLIKE_COUNT  = 'dislikeCount';
    const ORDER_FAVORITE_COUNT = 'favoriteCount';
    const ORDER_COMMENT_COUNT  = 'commentCount';


    public $category = '';
    public $author = '';
    public $offset = -1;
    public $order = '';
}
