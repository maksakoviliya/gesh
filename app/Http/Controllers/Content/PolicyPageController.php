<?php

declare(strict_types=1);

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class PolicyPageController extends Controller
{
    public function __invoke(Request $request)
    {
        $content = ContentPage::query()->where('slug', 'policy')->first();

        return Inertia::render('ContentPage', [
            'content' => $content?->content ?? 'Нет контента',
            'title' =>  $content?->title ?? 'Политикаконфиденциальности',
        ]);
    }
}
