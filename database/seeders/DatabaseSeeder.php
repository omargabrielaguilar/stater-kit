<?php

namespace Database\Seeders;

use App\Models\Follow;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // Crear perfiles
            $profiles = Profile::factory()->count(20)->create();
            $profileIds = $profiles->pluck('id')->toArray();

            // ========== POSTS INICIALES (BULK INSERT) ==========
            $postsData = [];
            $now = now();

            foreach ($profileIds as $profileId) {
                for ($i = 0; $i < 5; $i++) {
                    $postsData[] = [
                        'profile_id' => $profileId,
                        'parent_id' => null,
                        'repost_of_id' => null,
                        'content' => fake()->realText(200),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }

            DB::table('posts')->insert($postsData);
            $postIds = DB::table('posts')->pluck('id')->toArray();
            $postsByProfile = DB::table('posts')
                ->select('id', 'profile_id')
                ->get()
                ->groupBy('profile_id');

            // ========== FOLLOWS (BULK INSERT) ==========
            $followsData = [];
            $followsSet = []; // Para evitar duplicados

            foreach ($profileIds as $followerId) {
                // Obtener perfiles para seguir (excluyendo el mismo)
                $availableProfiles = array_diff($profileIds, [$followerId]);
                $toFollowCount = rand(3, min(7, count($availableProfiles)));
                $toFollow = array_rand(array_flip($availableProfiles), $toFollowCount);
                $toFollow = is_array($toFollow) ? $toFollow : [$toFollow];

                foreach ($toFollow as $followingId) {
                    $key = "{$followerId}-{$followingId}";
                    if (!isset($followsSet[$key])) {
                        $followsData[] = [
                            'follower_profile_id' => $followerId,
                            'following_profile_id' => $followingId,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                        $followsSet[$key] = true;
                    }
                }
            }

            if (! empty($followsData)) {
                DB::table('follows')->insert($followsData);
            }

            // ========== LIKES (BULK INSERT) ==========
            $likesData = [];
            $likesSet = []; // Para evitar duplicados

            foreach ($profileIds as $profileId) {
                // Posts que no son del perfil actual
                $availablePosts = collect($postsByProfile)->filter(function ($posts, $pid) use ($profileId) {
                    return $pid != $profileId;
                })->flatten()->pluck('id')->toArray();

                if (empty($availablePosts)) continue;

                $toLikeCount = rand(10, min(20, count($availablePosts)));
                $toLike = array_rand(array_flip($availablePosts), $toLikeCount);
                $toLike = is_array($toLike) ? $toLike : [$toLike];

                foreach ($toLike as $postId) {
                    $key = "{$profileId}-{$postId}";
                    if (!isset($likesSet[$key])) {
                        $likesData[] = [
                            'profile_id' => $profileId,
                            'post_id' => $postId,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                        $likesSet[$key] = true;
                    }
                }
            }

            if (! empty($likesData)) {
                // Insertar en chunks para evitar problemas con queries muy grandes
                foreach (array_chunk($likesData, 500) as $chunk) {
                    DB::table('likes')->insert($chunk);
                }
            }

            // ========== REPOSTS (BULK INSERT) ==========
            $repostsData = [];
            $repostsSet = [];

            foreach ($profileIds as $profileId) {
                // Posts que no son del perfil actual
                $availablePosts = collect($postsByProfile)->filter(function ($posts, $pid) use ($profileId) {
                    return $pid != $profileId;
                })->flatten()->pluck('id')->toArray();

                if (empty($availablePosts)) continue;

                $toRepostCount = rand(2, min(5, count($availablePosts)));
                $toRepost = array_rand(array_flip($availablePosts), $toRepostCount);
                $toRepost = is_array($toRepost) ? $toRepost : [$toRepost];

                foreach ($toRepost as $postId) {
                    $key = "{$profileId}-{$postId}";
                    if (!isset($repostsSet[$key])) {
                        $repostsData[] = [
                            'profile_id' => $profileId,
                            'parent_id' => null,
                            'repost_of_id' => $postId,
                            'content' => rand(0, 1) ? 'Check this out!' : null,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                        $repostsSet[$key] = true;
                    }
                }
            }

            if (!empty($repostsData)) {
                DB::table('posts')->insert($repostsData);
            }

            // ========== REPLIES (BULK INSERT) ==========
            $repliesData = [];
            $replyCount = rand(20, 30);

            for ($i = 0; $i < $replyCount; $i++) {
                $parentPostId = $postIds[array_rand($postIds)];
                $parentPost = $postsByProfile->flatten()->firstWhere('id', $parentPostId);

                // Buscar un perfil diferente al del post padre
                $availableRepliers = array_diff($profileIds, [$parentPost->profile_id]);
                $replierId = $availableRepliers[array_rand($availableRepliers)];

                $repliesData[] = [
                    'profile_id' => $replierId,
                    'parent_id' => $parentPostId,
                    'repost_of_id' => null,
                    'content' => fake()->realText(150),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            if (!empty($repliesData)) {
                DB::table('posts')->insert($repliesData);
            }
        });
    }
}
