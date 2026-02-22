<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        // 1) Use direct file paths
        $tasksPath = storage_path('app/tasks.json');
        // Use user-specific progress file
        $progressPath = storage_path('app/user-progress/' . $user->id . '.json');

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
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $progressDir = storage_path('app/user-progress');
        
        // Create user-progress directory if it doesn't exist
        if (!is_dir($progressDir)) {
            mkdir($progressDir, 0755, true);
        }

        $path = $progressDir . '/' . $user->id . '.json';
        $progress = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
        if (!is_array($progress)) { $progress = []; }

        if (in_array($id, $progress)) {
            $progress = array_values(array_diff($progress, [$id]));
        } else {
            $progress[] = (int)$id;
        }

        file_put_contents($path, json_encode($progress));
        return response()->json(['success' => true]);
    }

    public function reset()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in.');
        }

        $user = Auth::user();
        $path = storage_path('app/user-progress/' . $user->id . '.json');
        
        file_put_contents($path, json_encode([]));
        return redirect()->back()->with('success', 'Progress reset successfully!');
    }
}