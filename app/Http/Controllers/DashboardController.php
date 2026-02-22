<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1) Use direct file paths instead of Storage facade
        $tasksPath = storage_path('app/tasks.json');
        $progressPath = storage_path('app/progress.json');

        $tasks = file_exists($tasksPath) ? json_decode(file_get_contents($tasksPath), true) : [];
        $progress = file_exists($progressPath) ? json_decode(file_get_contents($progressPath), true) : [];
        
        if (!is_array($tasks)) { $tasks = []; }
        if (!is_array($progress)) { $progress = []; }

        $chapter = $request->query('chapter', 'all');

        // 2) Get all unique categories first
        $allCategories = [];
        foreach ($tasks as $task) {
            $cat = $task['category'] ?? 'Other';
            if (!in_array($cat, $allCategories)) {
                $allCategories[] = $cat;
            }
        }

        // Initialize categories with empty arrays
        $categories = [];
        foreach ($allCategories as $cat) {
            $categories[$cat] = [];
        }

        // Filter and group tasks by category
        $filteredTasks = $tasks;

        if ($chapter !== 'all') {
            $filteredTasks = array_filter($tasks, function ($t) use ($chapter) {
                return (string) $t['chapter'] === (string) $chapter || (string) $t['chapter'] === 'all';
            });
        }

        foreach ($filteredTasks as $task) {
            $cat = $task['category'] ?? 'Other';
            $categories[$cat][] = $task;
        }

        // DEBUG: Check if categories are being populated
        if (empty($categories)) {
            \Log::warning('Categories empty!', [
                'tasksPath' => $tasksPath,
                'tasksCount' => count($tasks),
                'filteredCount' => count($filteredTasks),
                'chapter' => $chapter
            ]);
        }

        // 3) Overall progress stats
        $totalCount = count($tasks); // Total tasks in the whole JSON
        $completedCount = count($progress); // Total IDs in progress JSON
        $percentage = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;

        // Check if there are any tasks in the filtered results
        $hasAnyTasks = false;
        foreach ($categories as $catTasks) {
            if (!empty($catTasks)) {
                $hasAnyTasks = true;
                break;
            }
        }

        return view('dashboard', [
            'categories'     => $categories,
            'progress'       => $progress,
            'percentage'     => $percentage,
            'completedCount' => $completedCount,
            'totalCount'     => $totalCount,
            'chapter'        => $chapter,
            'hasAnyTasks'    => $hasAnyTasks,
        ]);
    }

    public function toggle($id)
    {
        $path = storage_path('app/progress.json');
        $progress = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
        if (!is_array($progress)) { $progress = []; }

        if (in_array($id, $progress)) {
            $progress = array_values(array_diff($progress, [$id]));
        } else {
            $progress[] = (int)$id;
        }

        file_put_contents($path, json_encode($progress));
        return redirect()->back();
    }

    public function reset()
    {
        file_put_contents(storage_path('app/progress.json'), json_encode([]));
        return redirect()->back();
    }
}