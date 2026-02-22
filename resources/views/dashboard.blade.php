<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RDR2 Chapter 1-3 Tracker</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #e0e0e0;
            padding: 2rem;
            margin: 0;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        h1 {
            color: #d4a574;
            font-size: 2.2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .chapter-filter {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        .filter-btn {
            padding: 0.5rem 1.5rem;
            background: rgba(26, 26, 46, 0.6);
            border: 1px solid rgba(212, 165, 116, 0.3);
            border-radius: 20px;
            color: #d4a574;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        .filter-btn:hover {
            border-color: #d4a574;
            background: rgba(212, 165, 116, 0.1);
        }
        .filter-btn.active {
            background: #d4a574;
            color: #1a1a2e;
            font-weight: bold;
        }
        .progress-section {
            background: rgba(26, 26, 46, 0.8);
            border: 1px solid #d4a574;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .progress-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: #d4a574;
            margin-bottom: 1rem;
        }
        .progress-bar {
            background: rgba(212, 165, 116, 0.2);
            height: 12px;
            border-radius: 6px;
            position: relative;
            overflow: hidden;
        }
        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #d4a574 0%, #f4d03f 100%);
            border-radius: 6px;
            transition: width 0.5s ease;
        }
        .progress-bar.small {
            width: 100px;
            height: 8px;
        }
        .category-card {
            background: rgba(26, 26, 46, 0.6);
            border: 1px solid rgba(212, 165, 116, 0.3);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        .category-card:hover {
            border-color: #d4a574;
            box-shadow: 0 4px 20px rgba(212, 165, 116, 0.15);
        }
        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(212, 165, 116, 0.2);
        }
        .category-title {
            color: #d4a574;
            font-size: 1.3rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .category-progress {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.9rem;
        }
        .task-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .task-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(26, 26, 46, 0.4);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid rgba(212, 165, 116, 0.2);
        }
        .task-item:hover {
            border-color: #d4a574;
        }
        .task-item.completed {
            background: rgba(212, 165, 116, 0.1);
            text-decoration: line-through;
            opacity: 0.7;
        }
        .task-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #d4a574;
            cursor: pointer;
        }
        .chapter-badge {
            background: rgba(212, 165, 116, 0.2);
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.75rem;
            margin-left: 0.5rem;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🤠 RDR2 Chapter 1-3 Progress Tracker</h1>
        
        <!-- Chapter Filter -->
        <div class="chapter-filter">
            <a href="/" class="filter-btn {{ $chapter === null ? 'active' : '' }}">All</a>
            <a href="/chapter/1" class="filter-btn {{ $chapter == 1 ? 'active' : '' }}">Chapter 1</a>
            <a href="/chapter/2" class="filter-btn {{ $chapter == 2 ? 'active' : '' }}">Chapter 2</a>
            <a href="/chapter/3" class="filter-btn {{ $chapter == 3 ? 'active' : '' }}">Chapter 3</a>
        </div>

        <!-- Overall Progress -->
        <div class="progress-section">
            <div class="progress-text">Overall Progress: {{ $percentage }}%</div>
            <div class="progress-bar">
                <div class="progress-bar-fill" style="width: {{ $percentage }}%;"></div>
            </div>
            <p style="margin-top: 1rem; opacity: 0.8;">Completed: {{ $completedCount }} / {{ $totalCount }} tasks</p>
        </div>

        <!-- Category Cards -->
        @foreach($groupedTasks as $category => $tasks)
            <div class="category-card">
                <div class="category-header">
                    <h2 class="category-title">
                        @if($category == 'Camp Upgrades')🏕️
                        @elseif($category == 'Side Quests')📜
                        @elseif($category == 'Dream Catchers')🪶
                        @elseif($category == 'Dinosaur Bones')🦴
                        @elseif($category == 'Rock Carvings')🗿
                        @endif
                        {{ $category }}
                    </h2>
                    <div class="category-progress">
                        <div class="progress-bar small">
                            <div class="progress-bar-fill" style="width: {{ $categoryProgress[$category]['percentage'] }}%;"></div>
                        </div>
                        <span>{{ $categoryProgress[$category]['completed'] }}/{{ $categoryProgress[$category]['total'] }} ({{ $categoryProgress[$category]['percentage'] }}%)</span>
                    </div>
                </div>
                
                <div class="task-list">
                    @foreach($tasks as $task)
                        <div class="task-item {{ in_array($task['id'], $progress ?? []) ? 'completed' : '' }}">
                            <form method="POST" action="/toggle/{{ $task['id'] }}">
                                @csrf
                                <input type="checkbox"
                                    onchange="this.form.submit()"
                                    {{ in_array($task['id'], $progress ?? []) ? 'checked' : '' }}>
                                {{ $task['name'] }}
                                <span class="chapter-badge">Ch. {{ $task['chapter'] }}</span>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>