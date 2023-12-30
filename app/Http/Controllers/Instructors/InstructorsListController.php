<?php

declare(strict_types=1);

namespace App\Http\Controllers\Instructors;

use App\Http\Controllers\Controller;
use App\Http\Resources\Instructors\InstructorsCollection;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class InstructorsListController extends Controller
{
    public function __invoke(Request $request)
    {
        $instructors = Instructor::query()
            ->get();
        return Inertia::render('Instructors/List', [
            'instructors' => new InstructorsCollection($instructors)
        ]);
    }
}
