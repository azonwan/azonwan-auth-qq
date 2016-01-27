<?php

/*
 * This file is part of Flarum.
 *
 * (c) Azon Wan <xudong8860@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Azonwan\Auth\QQ\Listener;
use Illuminate\Contracts\Events\Dispatcher;

return function (Dispatcher $events) {
    $events->subscribe(Listener\AddClientAssets::class);
    $events->subscribe(Listener\AddQQAuthRoute::class);
};