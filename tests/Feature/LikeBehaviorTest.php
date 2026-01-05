<?php

use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('profile can like post', function () {
    $profile = Profile::factory()->create();
    $post = Post::factory()->create();

    $like = Like::createLike($profile, $post);

    expect($profile->likes)->toHaveCount(1)
        ->and($profile->likes->contains($like))->toBeTrue()
        ->and($post->likes)->toHaveCount(1)
        ->and($post->likes->contains($like))->toBeTrue()
        ->and($like->post->is($post))->toBeTrue()
        ->and($like->profile->is($profile))->toBeTrue();
});

test('profile cannot like the same post twice', function () {
    $profile = Profile::factory()->create();
    $post = Post::factory()->create();

    $like1 = Like::createLike($profile, $post);
    $like2 = Like::createLike($profile, $post);

    expect($like1->id)->toBe($like2->id)
        ->and($profile->likes)->toHaveCount(1)
        ->and($post->likes)->toHaveCount(1);
});

test('can remove a like ', function () {
    $profile = Profile::factory()->create();
    $post = Post::factory()->create();

    $like = Like::createLike($profile, $post);
    $success = Like::removeLike($profile, $post);

    expect($profile->likes)->toHaveCount(0)
        ->and($profile->likes->contains($like))->toBeFalse()
        ->and($post->likes)->toHaveCount(0)
        ->and($post->likes->contains($like))->toBeFalse()
        ->and($success)->toBeTrue();
});
