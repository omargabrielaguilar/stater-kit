<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/feed', function () {

    $feedItems = [
        [
            'profile' => [
                'display_name' => 'Amanda',
                'handle' => '@mmich_jj',
                'avatar' => '/images/amanda.png',
            ],
            'posted_ago' => '3 hours ago',
            'content' => <<<HTML
                <p>
                I made this! <a href="#">#myartwork</a> <a href="#">#eyes-care</a>
                </p>
                <img src="/images/simon-chilling.png" alt="" />
                HTML,
            'like_count' => 23,
            'reply_count' => 45,
            'repost_count' => 151,
        ],
        // add more items...
    ];

    $feedItems = json_decode(json_encode($feedItems));

    return view('feed', compact('feedItems'));
});

Route::get('/profile', function () {

    $feedItems = [
        [
            'profile' => [
                'display_name' => 'Adrian',
                'handle' => '@tudssss',
                'avatar' => '/images/adrian.png',
            ],
            'posted_ago' => '3 hours ago',
            'content' => <<<HTML
                <p>
                I made this! <a href="#">#myartwork</a> <a href="#">#eyes-care</a>
                </p>
                <img src="/images/simon-chilling.png" alt="" />
                HTML,
            'like_count' => 11,
            'reply_count' => 12,
            'repost_count' => 2,
        ],
        // add more items...
    ];

    $feedItems = json_decode(json_encode($feedItems));
    return view('profile', compact('feedItems'));
});
