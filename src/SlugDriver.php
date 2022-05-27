<?php

/*
 * This file is part of Keven1024\ChineseSlug.
 *
 * Copyright (c) Pipecraft && Keven1024.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Keven1024\ChineseSlug;

use Flarum\Database\AbstractModel;
use Flarum\Discussion\DiscussionRepository;
use Flarum\Http\SlugDriverInterface;
use Flarum\User\User;

class SlugDriver implements SlugDriverInterface
{
    /**
     * @var DiscussionRepository
     */
    protected $discussions;

    public function __construct(DiscussionRepository $discussions)
    {
        $this->discussions = $discussions;
    }

    public function toSlug(AbstractModel $instance): string
    {
        $title = $instance->title;
        if($title){
            // 过滤
            $title = preg_replace("/[\.!@#\$%\\\^&\*\)\(\+=\{\}\[\]\,'<>~\..`\?:;|\/]+/u", '-', $title);
            $title = preg_replace('/[\"\_]+/u', '-', $title);
            $title = preg_replace("/[\s]+/u", '-', $title);
            // 清除大于2的 -
            $title = preg_replace("/[-]+/u", '-', $title);
            // 清除头尾的 -
            if (substr($title, 0, 1) == "-") {
                $title = substr($title, 1);
            }
            if (substr($title, -1, 1) == "-") {
                $title = substr($title, 0, (strlen($title) - 1));
            }
        }
        return $instance->id . "-" . $title;
    }

    public function fromSlug(string $slug, User $actor): AbstractModel
    {
        if (strpos($slug, '-')) {
            $slug_array = explode('-', $slug);
            $slug = $slug_array[0];
        }

        return $this->discussions->findOrFail($slug, $actor);
    }
}
