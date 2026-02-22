<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
        public function index($chapter = null)
        {
            $tasksJson = Storage::get('tasks.json');
            $tasks = json_decode($tasksJson, true) ?? [];

            // Filter by chapter if specified
            if ($chapter !== null) {
                $tasks = array_filter($tasks, function($task) use ($chapter) {
                    return $task['chapter'] == $chapter;
                });
            }

            $progress = [];
            if (Storage::exists('progress.json')) {
                $progressJson = Storage::get('progress.json');
                $progress = json_decode($progressJson, true);
                if (!is_array($progress)) {
                    $progress = [];
                }
            }

            // Group tasks by category
            $groupedTasks = [];
            foreach ($tasks as $task) {
                $category = $task['category'];
                if (!isset($groupedTasks[$category])) {
                    $groupedTasks[$category] = [];
                }
                $groupedTasks[$category][] = $task;
            }

            // Calculate category progress
            $categoryProgress = [];
            foreach ($groupedTasks as $category => $categoryTasks) {
                $completedInCategory = 0;
                foreach ($categoryTasks as $task) {
                    if (in_array($task['id'], $progress)) {
                        $completedInCategory++;
                    }
                }
                $categoryProgress[$category] = [
                    'completed' => $completedInCategory,
                    'total' => count($categoryTasks),
                    'percentage' => count($categoryTasks) > 0 ? round(($completedInCategory / count($categoryTasks)) * 100) : 0
                ];
            }

            $completedCount = count($progress);
            $totalCount = count($tasks);
            $percentage = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;

            return view('dashboard', compact('groupedTasks', 'progress', 'percentage', 'categoryProgress', 'completedCount', 'totalCount', 'chapter'));
        }

        public function toggle($id)
        {
            // Read current progress
            $progress = [];
            if (Storage::exists('progress.json')) {
                $progressJson = Storage::get('progress.json');
                $progress = json_decode($progressJson, true);
            }

            // Ensure it's an array
            if (!is_array($progress)) {
                $progress = [];
            }

            // Toggle the task
            if (in_array($id, $progress)) {
                $progress = array_diff($progress, [$id]);
            } else {
                $progress[] = $id;
            }

            // Save back to JSON
            Storage::put('progress.json', json_encode(array_values($progress)));

            return redirect('/');
        }
}