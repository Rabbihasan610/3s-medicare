<?php

namespace App\Services\Assistant\Indexing\Sources;

use App\Models\Blog;
use App\Services\Assistant\Indexing\KnowledgeSource;
use App\Services\Assistant\Support\TextNormalizer;

/*
| Blog posts.
|
| Indexed, but weighted down at ranking time (config('assistant.source_weights'))
| because posts age and are often promotional - an answer about what Amlaek
| offers today should prefer the service pages over a two-year-old article. Set
| the weight to 1.0 to treat them as equals, or drop this source from the
| Indexer's list to leave them out entirely.
*/
class BlogSource implements KnowledgeSource
{
    public function type(): string
    {
        return 'blog';
    }

    public function documents(): iterable
    {
        $blogs = Blog::where('status', 'active')->orderBy('id')->get();

        foreach ($blogs as $blog) {
            $en = TextNormalizer::plain($blog->description);
            $ar = TextNormalizer::plain($blog->description_ar ?: $blog->description);

            if (trim($en) === '' && trim($ar) === '') {
                continue;
            }

            // `url` is stored as a path and resolved against the running host at
            // read time, so an index built locally stays correct in production.
            $url = \Illuminate\Support\Facades\Route::has('blog.details') && $blog->slug
                ? route('blog.details', $blog->slug, false)
                : (\Illuminate\Support\Facades\Route::has('blogs') ? route('blogs', [], false) : url('/'));

            yield [
                'source_key' => (string) $blog->id,
                'route_name' => \Illuminate\Support\Facades\Route::has('blog.details') ? 'blog.details' : 'home',
                'url'        => $url,
                'title'      => (string) $blog->title,
                'title_ar' => $blog->title_ar,
                'bodies'   => [
                    'en' => trim($blog->title . "\n\n" . $en),
                    'ar' => trim(($blog->title_ar ?: $blog->title) . "\n\n" . $ar),
                ],
            ];
        }
    }
}
