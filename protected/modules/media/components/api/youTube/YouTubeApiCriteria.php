<?php
class YouTubeApiCriteria extends ApiCriteria
{
    const ORDER_VIEW_COUNT     = 'viewCount';
    const ORDER_LIKE_COUNT     = 'likeCount';
    const ORDER_DISLIKE_COUNT  = 'dislikeCount';
    const ORDER_FAVORITE_COUNT = 'favoriteCount';
    const ORDER_COMMENT_COUNT  = 'commentCount';

    public static $order_list = [
        self::ORDER_VIEW_COUNT     => 'Количеству просмотров',
        self::ORDER_COMMENT_COUNT  => 'Количеству комментариев',
        self::ORDER_DISLIKE_COUNT  => 'Количеству дизлайков',
        self::ORDER_LIKE_COUNT     => 'Количеству лайков',
        self::ORDER_FAVORITE_COUNT => 'Количеству фаворитов??',
    ];

    public $category = null;
    public $author = null;

}
