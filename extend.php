<?php

/*
 * This file is part of Keven1024\ChineseSlug
 *
 * Copyright (c) Pipecraft && Keven1024.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Keven1024\ChineseSlug;

use Flarum\Discussion\Discussion;
use Flarum\Extend;

return [
    (new Extend\ModelUrl(Discussion::class))
        ->addSlugDriver('中文',SlugDriver::class)
];
