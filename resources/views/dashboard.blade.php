<!DOCTYPE html>
<html>
<head>
    <title>RDR2 Tracker</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --bg-primary: #1a1c2c;
            --bg-secondary: #25283d;
            --bg-tertiary: #222;
            --bg-hover: #2d314d;
            --border-color: #444;
            --text-primary: #eee;
            --text-secondary: #ccc;
            --text-tertiary: #bbb;
            --text-muted: #9ca3af;
            --accent-primary: #f0a500;
            --accent-secondary: #d4af37;
            --accent-light: #f0c04f;
            --error-bg: #3a1a1a;
            --error-border: #900;
            --error-text: #ff6b6b;
            --success-bg: #1f2937;
            --task-hover: #2d314d;
        }

        html[data-theme="light"] {
            --bg-primary: #f5f5f5;
            --bg-secondary: #ffffff;
            --bg-tertiary: #f9f9f9;
            --bg-hover: #e8e8e8;
            --border-color: #ddd;
            --text-primary: #333;
            --text-secondary: #555;
            --text-tertiary: #666;
            --text-muted: #888;
            --accent-primary: #d9860a;
            --accent-secondary: #b8860b;
            --accent-light: #cd9b1d;
            --error-bg: #ffe6e6;
            --error-border: #cc0000;
            --error-text: #cc0000;
            --success-bg: #e6f7e6;
            --task-hover: #f0f0f0;
        }

        * {
            color: var(--text-primary);
        }

        body { 
            font-family: sans-serif; 
            background: var(--bg-primary); 
            color: var(--text-primary);
            margin: 0; 
            padding: 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .header { 
            background: var(--bg-primary); 
            border-bottom: 1px solid var(--border-color); 
            padding: 20px 40px; 
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .header h1 { 
            color: var(--accent-primary); 
            margin: 0; 
            text-align: center;
            flex: 1;
        }

        .theme-toggle-btn {
            background: none;
            border: none;
            color: var(--accent-secondary);
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.2em;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .theme-toggle-btn:hover {
            background: var(--accent-secondary);
            color: var(--bg-primary);
            transform: scale(1.05);
        }

        .user-menu { position: absolute; top: 20px; right: 40px; }
        .user-menu-trigger { background: none; border: none; padding: 0; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: transform 0.2s; }
        .user-menu-trigger:hover { transform: scale(1.05); }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--accent-secondary); object-fit: cover; }
        .avatar-arrow { color: var(--accent-secondary); font-size: 1.2em; transition: transform 0.3s; }
        .user-menu-trigger:hover .avatar-arrow { transform: rotate(90deg); }
        .user-dropdown { display: none; position: absolute; top: 40px; right: 0; background: var(--bg-tertiary); border: 1px solid var(--accent-secondary); border-radius: 4px; min-width: 150px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); z-index: 1000; overflow: hidden; }
        .user-dropdown.open { display: block; }
        .user-dropdown a, .user-dropdown button { display: block; padding: 10px 15px; color: var(--accent-secondary); text-decoration: none; border: none; background: none; cursor: pointer; width: 100%; text-align: left; font-size: 0.9em; font-family: inherit; }
        .user-dropdown a:hover, .user-dropdown button:hover { background: var(--bg-hover); }
        .user-dropdown a.logout, .user-dropdown button.logout { color: var(--error-text); }
        .user-dropdown a.logout:hover, .user-dropdown button.logout:hover { background: var(--error-bg); }
        .container { max-width: 800px; margin: 0 auto; padding: 40px; }
        .card { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; margin-bottom: 20px; transition: background-color 0.3s ease, border-color 0.3s ease; }
        .progress-bar { background: var(--border-color); height: 10px; border-radius: 5px; margin: 15px 0; }
        .progress-fill { background: var(--accent-primary); height: 100%; border-radius: 5px; transition: 0.3s; }
        .category-title { color: var(--accent-primary); margin-bottom: 15px; border-bottom: 1px solid var(--border-color); padding-bottom: 5px; }
        .task-item { display: flex; align-items: center; margin-bottom: 10px; padding: 5px; }
        .task-item:hover { background: var(--task-hover); }
        input[type="checkbox"] { margin-right: 15px; transform: scale(1.5); cursor: pointer; }
        .chapter-badge { font-size: 0.7em; background: var(--border-color); padding: 2px 6px; border-radius: 4px; margin-left: 10px; }
        .nav { text-align: center; margin-bottom: 20px; }
        .nav a { color: var(--text-secondary); text-decoration: none; margin: 0 10px; padding: 5px 15px; border: 1px solid var(--border-color); border-radius: 20px; transition: all 0.3s ease; }
        .nav a.active { background: var(--accent-primary); color: var(--bg-primary); border-color: var(--accent-primary); }
        button.reset { background: var(--error-bg); color: white; border: 1px solid var(--error-border); padding: 10px 20px; border-radius: 5px; cursor: pointer; display: block; margin: 20px auto; }
        .quest-name { cursor: pointer; }
        .quest-details { display: none; margin-top: 12px; padding: 10px; background: var(--success-bg); border-left: 3px solid var(--accent-primary); border-radius: 4px; }
        .quest-details.open { display: block; }
        .quest-Discription { color: var(--text-tertiary); margin-bottom: 8px; font-size: 0.9em; }
        .quest-what { color: var(--text-muted); font-size: 0.9em; line-height: 1.5; }
    </style>
</head>
<body>
    <div class="header">
        <button class="theme-toggle-btn" onclick="toggleTheme()" title="Toggle theme">
            <span id="themeIcon">🌙</span>
        </button>
        <h1>RDR2 CHAPTER 1-3 PROGRESS TRACKER</h1>
        <div class="user-menu">
            <button class="user-menu-trigger" onclick="toggleUserMenu()" title="{{ Auth::user()->name }}">
                <img src="{{ Auth::user()->profile_picture }}" alt="Avatar" class="user-avatar">
                <span class="avatar-arrow">▶</span>
            </button>
            <div class="user-dropdown" id="userDropdown">
                <a href="{{ route('settings') }}">⚙️ Settings</a>
                <form method="POST" action="{{ route('logout') }}" class="logout">
                    @csrf
                    <button type="submit">🚪 Logout</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">

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
        <!-- <div class="card" style="background: #3a2a2a; border-color: #660;">
            <strong style="color: #f0a500;">DEBUG:</strong> 
            Categories count: {{ count($categories) }} | 
            Total tasks: {{ $totalCount }} | 
            Chapter: {{ $chapter }}
            @if(empty($categories))
                <p style="color: #ff6b6b;"><strong>⚠️ No categories found!</strong></p>
            @endif
        </div> -->
        
            

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
                            <div style="display: flex; align-items: center; width: 100%; margin-bottom: {{ (($catName === 'Side Quests' || $catName === 'Camp Upgrades') && isset($task['description']) || isset($task['cost'])) ? '0px' : '10px' }};">
                                <input type="checkbox" data-task-id="{{ $task['id'] }}" onchange="toggleTask(this)" {{ in_array($task['id'], $progress) ? 'checked' : '' }}>
                                @if(($catName === 'Side Quests' && isset($task['Discription'])) || ($catName === 'Camp Upgrades' && isset($task['cost'])))
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
                            @elseif($catName === 'Camp Upgrades' && isset($task['cost']))
                                <div class="quest-details" style="margin-left: 40px; width: calc(100% - 40px);">
                                    <div class="quest-Discription"><strong>Cost:</strong> {{ $task['cost'] }}</div>
                                    <div class="quest-Discription"><strong>Requirement:</strong> {{ $task['requirement'] }}</div>
                                    <div class="quest-what"><strong>Effect:</strong> {{ $task['effect'] }}</div>
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
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('open');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('.user-menu');
            if (!userMenu.contains(event.target)) {
                document.getElementById('userDropdown').classList.remove('open');
            }
        });

        function toggleTask(checkbox) {
            const taskId = checkbox.getAttribute('data-task-id');
            fetch(`/toggle/${taskId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update progress stats
                    document.querySelector('.card h2').textContent = `Overall Progress: ${data.percentage}%`;
                    document.querySelector('.progress-fill').style.width = `${data.percentage}%`;
                    document.querySelector('.card p').textContent = `Completed: ${data.completedCount} / ${data.totalCount} tasks`;
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

        // Theme Toggle
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme') || 'dark';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Update icon
            const icon = document.getElementById('themeIcon');
            icon.textContent = newTheme === 'dark' ? '🌙' : '☀️';
        }

        // Load saved theme on page load
        function initTheme() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            const html = document.documentElement;
            html.setAttribute('data-theme', savedTheme);
            
            const icon = document.getElementById('themeIcon');
            icon.textContent = savedTheme === 'dark' ? '🌙' : '☀️';
        }

        // Initialize theme when page loads
        document.addEventListener('DOMContentLoaded', initTheme);
        // Also call it immediately in case DOM is already loaded
        initTheme();
    </script>
</body>
</html>