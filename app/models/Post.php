<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 02.09.14
 * Time: 16:46
 */

namespace Karma\Entities;


class Post extends \Eloquent
{
    use NotifyingTrait;

    protected $table = 'posts';

    public function scopeCommon($query)
    {
        return $query->whereNull('receiver_id');
    }

    public function playlists()
    {
        return $this->morphedByMany('Karma\Entities\Playlist', 'post_item', 'posts_postitems');
    }

    public function tracks()
    {
        return $this->morphedByMany('Karma\Entities\Track', 'post_item', 'posts_postitems');
    }

    public function author()
    {
        return $this->belongsTo('Karma\Entities\User', 'author_id');
    }

    public function getMessageParams($type)
    {
        switch($type)
        {
            case NotifType::FEED_POST:
                return ['author' => strval($this->author)];
            default:
                return [];
        }
    }

    public function getUrlParams($type)
    {
        switch($type)
        {
            case NotifType::FEED_POST:
                return ['feed' => $this->id];
            default:
                return [];
        }
    }
}