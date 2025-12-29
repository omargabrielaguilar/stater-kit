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
            'content' => <<<'HTML'
                <p>
                I made this! <a href="#">#myartwork</a> <a href="#">#eyes-care</a>
                </p>
                <img src="/images/simon-chilling.png" alt="" />
                HTML,
            'like_count' => 23,
            'reply_count' => 45,
            'repost_count' => 151,
            'replies' => [
                [
                    'content' => '<p>Heh — this looks just like me!</p>',
                    'profile' => [
                        'display_name' => 'Simon',
                        'handle' => '@simonswiss',
                        'avatar' => '/images/simon-chilling.png',
                    ],
                    'posted_ago' => '2 hours ago',
                    'content' => '<p>Great job! I love it!</p>',
                    'like_count' => 5,
                    'reply_count' => 2,
                    'repost_count' => 1,
                ],
                // add more replies...
            ],
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
            'content' => <<<'HTML'
                <p>
                I made this! <a href="#">#myartwork</a> <a href="#">#eyes-care</a>
                </p>
                <img src="/images/simon-chilling.png" alt="" />
                HTML,
            'like_count' => 11,
            'reply_count' => 12,
            'repost_count' => 2,
            'replies' => [
                [
                    'content' => '<p>Heh — this looks just like me!</p>',
                    'profile' => [
                        'display_name' => 'Simon',
                        'handle' => '@simonswiss',
                        'avatar' => '/images/simon-chilling.png',
                    ],
                    'posted_ago' => '2 hours ago',
                    'content' => '<p>Great job! I love it!</p>',
                    'like_count' => 5,
                    'reply_count' => 2,
                    'repost_count' => 1,
                ],
                // add more replies...
            ],
        ],
        // add more items...
    ];

    $feedItems = json_decode(json_encode($feedItems));

    return view('profile', compact('feedItems'));
});
