<?php

declare(strict_types=1);

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class RulesPageController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $content = ContentPage::query()->where('slug', 'rules')->first();

        return Inertia::render('ContentPage', [
            'content' => $content?->content ?? 'Нет контента',
            'title' => $content?->title ?? 'Правила пользования',
        ]);
    }
}
