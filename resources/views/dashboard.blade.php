
<!DOCTYPE html>
<html>
<head>
    <title>RDR2 Tracker</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>

        @font-face {
            font-family: 'Chinese Rocks';
            src: url('/fonts/chinese rocks rg.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }

        :root {
            --bg-primary: #000000;
            --bg-secondary: #120000;
            --bg-tertiary: #222;
            --bg-hover: #2d314d;
            --border-color: #360606;
            --text-primary: #540310;
            --text-secondary: #ccc;
            --text-tertiary: #bbb;
            --text-muted: #9ca3af;
            --accent-primary: #540310;
            --accent-secondary: #540310;
            --accent-light: #540310;
            --error-bg: #3a1a1a;
            --error-border: #900;
            --error-text: #ff6b6b;
            --success-bg: #1f2937;
            --task-hover: #2d314d;
        }

        html[data-theme="light"] {
            --bg-primary: #eed7b7;
            --bg-secondary: #f7ebda;
            --bg-tertiary: #f9f9f9;
            --bg-hover: #e8e8e8;
            --border-color: #b5915e;
            --text-primary: #333;
            --text-secondary: #555;
            --text-tertiary: #666;
            --text-muted: #888;
            --accent-primary: #630615;
            --accent-secondary: #630615;
            --accent-light: #630615;
            --error-bg: #ffe6e6;
            --error-border: #cc0000;
            --error-text: #cc0000;
            --success-bg: #e6f7e6;
            --task-hover: #f0f0f0;
        }

        * {
            color: var(--text-primary);
        }

        .not-header, .not-header * {
            font-family: 'Chinese Rocks', Impact, sans-serif !important;
            font-weight: normal !important;
            font-size: 24px !important;
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
            border-bottom: 1px solid #540310;
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
        .user-dropdown { display: none; position: absolute; top: 40px; right: 0; background: #540310; color: #fff; border: 1px solid var(--accent-secondary); border-radius: 4px; min-width: 150px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); z-index: 1000; overflow: hidden; }
        .user-dropdown.open { display: block; }
        .user-dropdown a, .user-dropdown button { display: block; padding: 10px 15px; color: #fff; text-decoration: none; border: none; background: none; cursor: pointer; width: 100%; text-align: left; font-size: 0.9em; font-family: inherit; }
        .user-dropdown a:hover, .user-dropdown button:hover { background: var(--bg-hover); }
        .user-dropdown a.logout, .user-dropdown button.logout { color: var(--error-text); }
        .user-dropdown a.logout:hover, .user-dropdown button.logout:hover { background: var(--error-bg); }
        .container { max-width: 800px; margin: 0 auto; padding: 40px; }
        .card { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; margin-bottom: 20px; transition: background-color 0.3s ease, border-color 0.3s ease; }
        .progress-bar { background: var(--border-color); height: 10px; border-radius: 5px; margin: 15px 0; }
        .progress-fill { background: var(--accent-primary); height: 100%; border-radius: 5px; transition: 0.3s; }
        .category-title { color: var(--accent-primary); margin-bottom: 15px; border-bottom: 1px solid var(--border-color); padding-bottom: 5px; }
        .subcategory-title { color: var(--text-secondary); margin: 10px 0 5px; font-size: 1em; letter-spacing: 0.5px; cursor: pointer; background: var(--bg-tertiary); border: 1px solid var(--border-color); border-radius: 6px; font-weight: 700; display: block; text-align: left; width: 100%; padding: 10px 12px; }
        .subcategory-title:hover { background: var(--bg-hover); }
        .subcategory-title::before { content: "▾"; margin-right: 8px; display: inline-block; transition: transform 0.2s ease; }
        .subcategory-title[aria-expanded="false"]::before { content: "▸"; }
        .subcategory-body { margin-left: 10px; padding-left: 10px; border-left: 2px solid var(--border-color); display: none; }
        .subcategory-body.expanded { display: block; }
        .collapsible-category { color: var(--accent-primary); margin-bottom: 15px; border-bottom: 1px solid var(--border-color); padding-bottom: 5px; cursor: pointer; background: none; border: none; font-size: 1.2em; font-weight: bold; text-align: left; width: 100%; }
        .collapsible-category::before { content: "▸"; margin-right: 8px; display: inline-block; transition: transform 0.2s ease; }
        .collapsible-category[aria-expanded="true"]::before { content: "▾"; }
        .category-body { display: none; }
        .category-body.expanded { display: block; }
        .task-item { display: flex; align-items: center; margin-bottom: 10px; padding: 5px; }
        .task-item:hover { background: var(--task-hover); }
        input[type="checkbox"] { margin-right: 15px; transform: scale(1.5); cursor: pointer; }
        .chapter-badge { font-size: 0.7em; background: var(--border-color); padding: 2px 6px; border-radius: 4px; margin-left: 10px; }
        .nav {
            text-align: center;
            margin-bottom: 20px;
            max-width: 1800px;
            width: 95vw;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 18px;
            padding: 12px 0;
        }
        .nav a {
            flex: 0 1 auto;
        }
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
    @if(session('settings_updated'))
        <div id="settingsUpdatedModal" style="position:fixed; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.35); z-index:9999; display:flex; align-items:center; justify-content:center; pointer-events:auto;">
            <div style="background:#222; border:2px solid #f0a500; border-radius:10px; padding:24px 32px; text-align:center; box-shadow:0 8px 32px rgba(0,0,0,0.7); min-width:260px; position:relative;">
                <button id="closeSettingsUpdated" style="position:absolute; top:8px; right:12px; background:none; border:none; color:#f0a500; font-size:1.3em; cursor:pointer;">&times;</button>
                <h2 style="color:#f0a500; margin-bottom:0;">Settings updated</h2>
            </div>
        </div>
        <script>
            setTimeout(function() {
                var modal = document.getElementById('settingsUpdatedModal');
                if (modal) modal.style.display = 'none';
            }, 5000);
            document.getElementById('closeSettingsUpdated').onclick = function() {
                var modal = document.getElementById('settingsUpdatedModal');
                if (modal) modal.style.display = 'none';
            };
        </script>
    @endif
    @if(session('progress_reset'))
        <div id="progressResetModal" style="position:fixed; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.7); z-index:9999; display:flex; align-items:center; justify-content:center;">
            <div style="background:#222; border:2px solid #c0392b; border-radius:10px; padding:40px 30px; max-width:350px; margin:auto; text-align:center; box-shadow:0 8px 32px rgba(0,0,0,0.7);">
                <h2 style="color:#c0392b; margin-bottom:18px;">Progress reset</h2>
            </div>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = '{{ route('dashboard') }}';
            }, 1500);
        </script>
    @endif
    <div class="header" style="display: flex; align-items: center; justify-content: center; position: relative;">
        <button class="theme-toggle-btn" onclick="toggleTheme()" title="Toggle theme">
            <span id="themeIcon">🌙</span>
        </button>
        <h1 style="flex: 1; text-align: center; margin: 0; color: var(--accent-primary);">RDR2 CHAPTER 1 - 4 PROGRESS TRACKER</h1>
        <div class="user-menu" style="position: absolute; top: 20px; right: 40px; z-index: 10;">
            <button class="user-menu-trigger" id="userMenuTrigger" title="{{ Auth::user()->name }}" style="background: none; border: none; padding: 0; cursor: pointer; display: flex; align-items: center; gap: 8px;">
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
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var trigger = document.getElementById('userMenuTrigger');
            var dropdown = document.getElementById('userDropdown');
            var menu = trigger.parentElement;
            if (trigger && dropdown && menu) {
                menu.addEventListener('mouseenter', function() {
                    dropdown.classList.add('open');
                });
                menu.addEventListener('mouseleave', function() {
                    dropdown.classList.remove('open');
                });
            }
        });
        </script>
    </div>

    <div class="container not-header">

        <div class="nav">
            <a href="/?chapter=all" class="{{ ($chapter ?? 'all') == 'all' ? 'active' : '' }}">All</a>
            <a href="/?chapter=1" class="{{ ($chapter ?? '') == '1' ? 'active' : '' }}">Chapter 1</a>
            <a href="/?chapter=2" class="{{ ($chapter ?? '') == '2' ? 'active' : '' }}">Chapter 2</a>
            <a href="/?chapter=3" class="{{ ($chapter ?? '') == '3' ? 'active' : '' }}">Chapter 3</a>
            <a href="/?chapter=4" class="{{ ($chapter ?? '') == '4' ? 'active' : '' }}">Chapter 4</a>
            <a href="/?chapter=collectables" class="{{ ($chapter ?? '') == 'collectables' ? 'active' : '' }}">Collectables</a>
            <a href="/?chapter=complete" class="{{ ($chapter ?? '') == 'complete' ? 'active' : '' }}">Complete</a>
        </div>

        @if($chapter == '1')
            <div class="card" style="background: #2d3d5c; border-color: #6699dd; text-align: center; padding: 40px;">
                <h2 style="color: #f0a500; margin-bottom: 20px;">Nothing is available until the start of Chapter 2</h2>
                <p style="font-size: 1.1em; color: #bbb;">Chapter 1 is just the tutorial chapter :D</p>
            </div>
        @else

        <div class="card overall-progress-card">
            <h2 class="overall-progress-title">Overall Progress: {{ $percentage }}%</h2>
            <div class="progress-bar">
                <div class="progress-fill overall-progress-fill" style="width: {{ $percentage }}%"></div>
            </div>
            <p class="overall-progress-text">Completed: {{ $completedCount }} / {{ $totalCount }} tasks</p>
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
        
            

        @foreach($categories as $catName => $catTasks)
            @if(count($catTasks) === 0)
                @continue
            @endif
            <div class="card task-section-card" data-category="{{ $catName }}">
                @if($catName === 'Dinosaur Bones')
                    <button type="button" class="collapsible-category" data-cat-id="cat-dinosaur-bones" onclick="toggleCategory('cat-dinosaur-bones')" aria-expanded="false">{{ $catName }}</button>
                    <div class="category-body" id="cat-dinosaur-bones">
                @elseif($catName === 'Rock Carvings')
                    <button type="button" class="collapsible-category" data-cat-id="cat-rock-carvings" onclick="toggleCategory('cat-rock-carvings')" aria-expanded="false">{{ $catName }}</button>
                    <div class="category-body" id="cat-rock-carvings">
                @elseif($catName === 'Dream Catchers')
                    <button type="button" class="collapsible-category" data-cat-id="cat-dream-catchers" onclick="toggleCategory('cat-dream-catchers')" aria-expanded="false">{{ $catName }}</button>
                    <div class="category-body" id="cat-dream-catchers">
                @elseif($catName === 'Side Quests')
                    <button type="button" class="collapsible-category" data-cat-id="cat-side-quests" onclick="toggleCategory('cat-side-quests')" aria-expanded="false">{{ $catName }}</button>
                    <div class="category-body" id="cat-side-quests">
                @elseif($catName === 'Cigarette Cards')
                    <button type="button" class="collapsible-category" data-cat-id="cat-cigarette-cards" onclick="toggleCategory('cat-cigarette-cards')" aria-expanded="false">{{ $catName }}</button>
                    <div class="category-body" id="cat-cigarette-cards">
                @elseif($catName === 'Camp Upgrades')
                    <button type="button" class="collapsible-category" data-cat-id="cat-camp-upgrades" onclick="toggleCategory('cat-camp-upgrades')" aria-expanded="false">{{ $catName }}</button>
                    <div class="category-body" id="cat-camp-upgrades">
                @elseif($catName === 'Steam Achievements')
                    <button type="button" class="collapsible-category" data-cat-id="cat-steam-achievements" onclick="toggleCategory('cat-steam-achievements')" aria-expanded="false">{{ $catName }}</button>
                    <div class="category-body" id="cat-steam-achievements">
                @else
                    <h3 class="category-title">{{ $catName }}</h3>
                @endif
                @php
                    $sectionTotal = is_array($catTasks) ? count($catTasks) : 0;
                    $sectionCompleted = 0;
                    if (is_array($catTasks)) {
                        foreach ($catTasks as $task) {
                            if (in_array($task['id'], $progress)) $sectionCompleted++;
                        }
                    }
                    $sectionPercent = $sectionTotal > 0 ? round(($sectionCompleted / $sectionTotal) * 100) : 0;
                @endphp
                <div class="progress-bar section-progress-bar" style="margin-top: 18px; margin-bottom: 10px;">
                    <div class="progress-fill section-progress-fill" style="width: {{ $sectionPercent }}%; background: var(--accent-primary); height: 12px; border-radius: 6px;"></div>
                </div>
                <p class="section-progress-text" style="margin-bottom: 0; font-size: 0.95em; color: var(--text-secondary);">Section Progress: {{ $sectionCompleted }} / {{ $sectionTotal }} ({{ $sectionPercent }}%)</p>
                @if(count($catTasks) === 0)
                    <p style="color: #999; font-style: italic;">No tasks in this chapter</p>
                @else
                    @php $currentSub = null; @endphp
                    @foreach($catTasks as $task)
                        @php $subcat = $task['sub_category'] ?? null; @endphp

                        @if($subcat)
                            @if($subcat !== $currentSub)
                                @if($currentSub !== null)
                                    </div>
                                @endif
                                @php $subcatId = 'subcat-' . \Illuminate\Support\Str::slug($subcat, '-'); @endphp
                                <button type="button" class="subcategory-title" data-subcat-id="{{ $subcatId }}" onclick="toggleSubcategory('{{ $subcatId }}')" aria-expanded="false">{{ $subcat }}</button>
                                <div class="subcategory-body" id="{{ $subcatId }}">
                                @php $currentSub = $subcat; @endphp
                            @endif
                        @else
                            @if($currentSub !== null)
                                </div>
                                @php $currentSub = null; @endphp
                            @endif
                        @endif

                        <div class="task-item" style="flex-direction: column; align-items: flex-start;">
                            <div style="display: flex; align-items: center; width: 100%; margin-bottom: {{ (($catName === 'Side Quests' || $catName === 'Camp Upgrades') && (isset($task['Discription']) || isset($task['cost']))) ? '0px' : '10px' }};">
                                <input type="checkbox" data-task-id="{{ $task['id'] }}" onchange="toggleTask(this)" {{ in_array($task['id'], $progress) ? 'checked' : '' }}>
                                @if(($catName === 'Side Quests' && isset($task['Discription'])) || ($catName === 'Camp Upgrades' && isset($task['cost'])) || (($catName === 'Rock Carvings' || $catName === 'Dinosaur Bones' || $catName === 'Dream Catchers') && isset($task['location'])))
                                    <span class="quest-name" onclick="toggleDetails(this)">{{ $task['name'] }}</span>
                                @else
                                    <span>{{ $task['name'] }}</span>
                                @endif
                                @if(isset($task['chapter']))
                                    <span class="chapter-badge">Ch. {{ $task['chapter'] }}</span>
                                @endif
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
                                    @if(isset($task['effect']))
                                        <div class="quest-what"><strong>Effect:</strong> {{ $task['effect'] }}</div>
                                    @endif
                                </div>
                            @elseif(($catName === 'Rock Carvings' || $catName === 'Dinosaur Bones' || $catName === 'Dream Catchers') && isset($task['location']))
                                <div class="quest-details" style="margin-left: 40px; width: calc(100% - 40px);">
                                    <div class="quest-Discription"><strong>Location:</strong> {{ $task['location'] }}</div>
                                </div>
                            @endif
                        </div>


                    @endforeach
                    @if($currentSub && !empty($catTasks))
                        </div>
                    @endif
                @endif
                @if($catName === 'Dinosaur Bones')
                    </div>
                @elseif($catName === 'Rock Carvings')
                    </div>
                @elseif($catName === 'Dream Catchers')
                    </div>
                @elseif($catName === 'Side Quests')
                    </div>
                @elseif($catName === 'Cigarette Cards')
                    </div>
                @elseif($catName === 'Camp Upgrades')
                    </div>
                @endif
            </div>
        @endforeach
        @endif

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

            // Instant UI feedback before the request completes.
            refreshAllSectionProgresses();

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
                    // Update overall progress stats.
                    const overallTitle = document.querySelector('.overall-progress-title');
                    const overallFill = document.querySelector('.overall-progress-fill');
                    const overallText = document.querySelector('.overall-progress-text');

                    if (overallTitle) {
                        overallTitle.textContent = `Overall Progress: ${data.percentage}%`;
                    }
                    if (overallFill) {
                        overallFill.style.width = `${data.percentage}%`;
                    }
                    if (overallText) {
                        overallText.textContent = `Completed: ${data.completedCount} / ${data.totalCount} tasks`;
                    }

                    // Ensure every section tracker is recalculated live.
                    refreshAllSectionProgresses();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Keep section trackers in sync with current checkbox states.
                refreshAllSectionProgresses();
            });
        }

        function updateSectionProgress(sectionCard) {
            const sectionCheckboxes = sectionCard.querySelectorAll('input[type="checkbox"][data-task-id]');
            const total = sectionCheckboxes.length;
            const completed = sectionCard.querySelectorAll('input[type="checkbox"][data-task-id]:checked').length;
            const percent = total > 0 ? Math.round((completed / total) * 100) : 0;

            const progressFill = sectionCard.querySelector('.section-progress-fill');
            if (progressFill) {
                progressFill.style.width = `${percent}%`;
            }

            const progressText = sectionCard.querySelector('.section-progress-text');
            if (progressText) {
                progressText.textContent = `Section Progress: ${completed} / ${total} (${percent}%)`;
            }
        }

        function refreshAllSectionProgresses() {
            document.querySelectorAll('.task-section-card').forEach(updateSectionProgress);
        }

        function toggleDetails(element) {
            const detailsDiv = element.closest('.task-item').querySelector('.quest-details');
            if (detailsDiv) {
                detailsDiv.classList.toggle('open');
            }
        }

        function toggleSubcategory(subcatId) {
            const body = document.getElementById(subcatId);
            if (!body) return;

            const isOpen = body.classList.toggle('expanded');
            body.style.display = isOpen ? 'block' : 'none';

            const button = document.querySelector(`button[data-subcat-id="${subcatId}"]`);
            if (button) {
                button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            }
        }

        function toggleCategory(catId) {
            const body = document.getElementById(catId);
            if (!body) return;

            const isOpen = body.classList.toggle('expanded');
            body.style.display = isOpen ? 'block' : 'none';

            const button = document.querySelector(`button[data-cat-id="${catId}"]`);
            if (button) {
                button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
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

        document.addEventListener('DOMContentLoaded', function() {
            const chapter = '{{ $chapter ?? 'all' }}';
            if (chapter === '2' || chapter === '3' || chapter === '4' || chapter === 'complete') {
                document.querySelectorAll('.collapsible-category').forEach(btn => {
                    const catId = btn.getAttribute('data-cat-id');
                    const body = document.getElementById(catId);
                    if (body) {
                        btn.setAttribute('aria-expanded', 'true');
                        body.classList.add('expanded');
                        body.style.display = 'block';
                    }
                });
            }

            if (chapter === 'complete') {
                const cigaretteCardsBody = document.getElementById('cat-cigarette-cards');
                if (cigaretteCardsBody) {
                    cigaretteCardsBody.querySelectorAll('.subcategory-title').forEach(btn => {
                        const subcatId = btn.getAttribute('data-subcat-id');
                        const subBody = document.getElementById(subcatId);
                        if (subBody) {
                            btn.setAttribute('aria-expanded', 'true');
                            subBody.classList.add('expanded');
                            subBody.style.display = 'block';
                        }
                    });
                }
            }

            // Initial sync in case rendered counts are stale.
            refreshAllSectionProgresses();
        });
    </script>
</body>
</html>