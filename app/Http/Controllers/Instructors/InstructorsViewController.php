<?php

declare(strict_types=1);

namespace App\Http\Controllers\Instructors;

use App\Http\Controllers\Controller;
use App\Http\Resources\Instructors\InstructorsResource;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class InstructorsViewController extends Controller
{
    public function __invoke(Request $request, Instructor $instructor): Response
    {
        return Inertia::render('Instructors/View', [
            'instructor' => new InstructorsResource($instructor),
        ]);
    }
}
