<!DOCTYPE html>
<html>
<head>
    <title>RDR2 Tracker</title>
    <style>
        body { font-family: sans-serif; background: #1a1c2c; color: #eee; padding: 40px; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { background: #25283d; border: 1px solid #444; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        .progress-bar { background: #444; height: 10px; border-radius: 5px; margin: 15px 0; }
        .progress-fill { background: #f0a500; height: 100%; border-radius: 5px; transition: 0.3s; }
        .category-title { color: #f0a500; margin-bottom: 15px; border-bottom: 1px solid #444; padding-bottom: 5px; }
        .task-item { display: flex; align-items: center; margin-bottom: 10px; padding: 5px; }
        .task-item:hover { background: #2d314d; }
        input[type="checkbox"] { margin-right: 15px; transform: scale(1.5); cursor: pointer; }
        .chapter-badge { font-size: 0.7em; background: #444; padding: 2px 6px; border-radius: 4px; margin-left: 10px; }
        .nav { text-align: center; margin-bottom: 20px; }
        .nav a { color: #ccc; text-decoration: none; margin: 0 10px; padding: 5px 15px; border: 1px solid #444; border-radius: 20px; }
        .nav a.active { background: #f0a500; color: #000; border-color: #f0a500; }
        button.reset { background: #4e1a1a; color: white; border: 1px solid #900; padding: 10px 20px; border-radius: 5px; cursor: pointer; display: block; margin: 20px auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="text-align: center; color: #f0a500; margin-bottom: 20px;">🤠 RDR2 CHAPTER 1-3 PROGRESS TRACKER</h1>

        <div class="nav">
            <a href="/?chapter=all" class="{{ ($chapter ?? 'all') == 'all' ? 'active' : '' }}">All</a>
            <a href="/?chapter=1" class="{{ ($chapter ?? '') == '1' ? 'active' : '' }}">Chapter 1</a>
            <a href="/?chapter=2" class="{{ ($chapter ?? '') == '2' ? 'active' : '' }}">Chapter 2</a>
            <a href="/?chapter=3" class="{{ ($chapter ?? '') == '3' ? 'active' : '' }}">Chapter 3</a>
        </div>

        <div class="card">
            <h2>Overall Progress: {{ $percentage }}%</h2>
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $percentage }}%"></div>
            </div>
            <p>Completed: {{ $completedCount }} / {{ $totalCount }} tasks</p>
        </div>

        <!-- DEBUG INFO -->
        <div class="card" style="background: #3a2a2a; border-color: #660;">
            <strong style="color: #f0a500;">DEBUG:</strong> 
            Categories count: {{ count($categories) }} | 
            Total tasks: {{ $totalCount }} | 
            Chapter: {{ $chapter }}
            @if(empty($categories))
                <p style="color: #ff6b6b;"><strong>⚠️ No categories found!</strong></p>
            @endif
        </div>



        @foreach($categories as $catName => $catTasks)
            <div class="card">
                <h3 class="category-title">{{ $catName }}</h3>
                @foreach($catTasks as $task)
                    <div class="task-item">
                        <form action="/toggle/{{ $task['id'] }}" method="POST">
                            @csrf
                            <input type="checkbox" onchange="this.form.submit()" {{ in_array($task['id'], $progress) ? 'checked' : '' }}>
                        </form>
                        <span>{{ $task['name'] }}</span>
                        <span class="chapter-badge">Ch. {{ $task['chapter'] }}</span>
                    </div>
                @endforeach
            </div>
        @endforeach

        <form action="/reset" method="POST">
            @csrf
            <button type="submit" class="reset">Reset All Progress</button>
        </form>
    </div>
</body>
</html>