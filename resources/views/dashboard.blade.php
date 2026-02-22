<!DOCTYPE html>
<html>
<head>
    <title>RDR2 Tracker</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .quest-name { cursor: pointer; }
        .quest-details { display: none; margin-top: 12px; padding: 10px; background: #1f2937; border-left: 3px solid #f0a500; border-radius: 4px; }
        .quest-details.open { display: block; }
        .quest-Discription { color: #bbb; margin-bottom: 8px; font-size: 0.9em; }
        .quest-what { color: #9ca3af; font-size: 0.9em; line-height: 1.5; }
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
        <!-- x -->
        <div class="card" style="background: #3a2a2a; border-color: #660;">
            <strong style="color: #f0a500;">DEBUG:</strong> 
            Categories count: {{ count($categories) }} | 
            Total tasks: {{ $totalCount }} | 
            Chapter: {{ $chapter }}
            @if(empty($categories))
                <p style="color: #ff6b6b;"><strong>⚠️ No categories found!</strong></p>
            @endif
        </div>
            

        @if($chapter == '1')
            <div class="card" style="background: #2d3d5c; border-color: #6699dd; text-align: center; padding: 40px;">
                <h2 style="color: #f0a500; margin-bottom: 20px;">Nothing is available until the start of Chapter 2</h2>
                <p style="font-size: 1.1em; color: #bbb;">Chapter 1 is just the tutorial chapter :D</p>
            </div>
        @else


        @foreach($categories as $catName => $catTasks)
            <div class="card">
                <h3 class="category-title">{{ $catName }}</h3>
                @if(count($catTasks) === 0)
                    <p style="color: #999; font-style: italic;">No tasks in this chapter</p>
                @else
                    @foreach($catTasks as $task)
                        <div class="task-item" style="flex-direction: column; align-items: flex-start;">
                            <div style="display: flex; align-items: center; width: 100%; margin-bottom: {{ $catName === 'Side Quests' && isset($task['Discription']) ? '0px' : '10px' }};">
                                <input type="checkbox" data-task-id="{{ $task['id'] }}" onchange="toggleTask(this)" {{ in_array($task['id'], $progress) ? 'checked' : '' }}>
                                @if($catName === 'Side Quests' && isset($task['Discription']))
                                    <span class="quest-name" onclick="toggleDetails(this)">{{ $task['name'] }}</span>
                                @else
                                    <span>{{ $task['name'] }}</span>
                                @endif
                                <span class="chapter-badge">Ch. {{ $task['chapter'] }}</span>
                            </div>
                            @if($catName === 'Side Quests' && isset($task['Discription']))
                                <div class="quest-details" style="margin-left: 40px; width: calc(100% - 40px);">
                                    <div class="quest-Discription"><strong>Discription:</strong> {{ $task['Discription'] }}</div>
                                    <div class="quest-what"><strong>What you do:</strong> {{ $task['what_you_do'] }}</div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
        @endif

        <form action="/reset" method="POST">
            @csrf
            <button type="submit" class="reset">Reset All Progress</button>
        </form>
    </div>

    <script>
        function toggleTask(checkbox) {
            const taskId = checkbox.getAttribute('data-task-id');
            fetch(`/toggle/${taskId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Content-Type': 'application/json'
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function toggleDetails(element) {
            const detailsDiv = element.closest('.task-item').querySelector('.quest-details');
            if (detailsDiv) {
                detailsDiv.classList.toggle('open');
            }
        }
    </script>
</body>
</html>