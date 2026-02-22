<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - RDR2 Progress Tracker</title>
    <style>
        :root {
            --bg-primary: #1a1a1a;
            --bg-secondary: #222;
            --bg-gradient-start: #1a1a1a;
            --bg-gradient-end: #2d2d2d;
            --border-color: #d4af37;
            --text-primary: #e0e0e0;
            --text-secondary: #d4af37;
            --text-light: #f0c04f;
            --text-error: #ff6b6b;
            --bg-error: #3a1a1a;
            --border-error: #900;
            --bg-success: #1a3a1a;
            --border-success: #4a9d4a;
            --text-success: #6dd46d;
            --accent-primary: #f0a500;
            --input-bg: #1a1a1a;
            --input-border: #444;
            --input-focus-border: #d4af37;
        }

        html[data-theme="light"] {
            --bg-primary: #f5f5f5;
            --bg-secondary: #ffffff;
            --bg-gradient-start: #f5f5f5;
            --bg-gradient-end: #e8e8e8;
            --border-color: #b8860b;
            --text-primary: #333;
            --text-secondary: #b8860b;
            --text-light: #cd9b1d;
            --text-error: #cc0000;
            --bg-error: #ffe6e6;
            --border-error: #cc0000;
            --bg-success: #e6f7e6;
            --border-success: #4a9d4a;
            --text-success: #2d7a2d;
            --accent-primary: #d9860a;
            --input-bg: #fafafa;
            --input-border: #ddd;
            --input-focus-border: #b8860b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
            min-height: 100vh;
            color: var(--text-primary);
            transition: background 0.3s ease, color 0.3s ease;
        }

        .header {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--input-border);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .header h1 {
            color: var(--accent-primary);
            margin: 0;
        }

        .header-actions {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .theme-toggle-btn {
            background: none;
            border: 1px solid var(--border-color);
            color: var(--border-color);
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.2em;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .theme-toggle-btn:hover {
            background: var(--border-color);
            color: var(--bg-primary);
            transform: scale(1.05);
        }

        .back-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: var(--text-light);
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
        }

        .settings-section {
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .settings-section h2 {
            color: var(--border-color);
            margin-bottom: 25px;
            font-size: 22px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--border-color);
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--input-border);
            border-radius: 4px;
            background: var(--input-bg);
            color: var(--text-primary);
            font-size: 14px;
            transition: border-color 0.3s ease, background-color 0.3s ease, color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: var(--input-focus-border);
            box-shadow: 0 0 5px rgba(212, 175, 55, 0.3);
        }

        .error-message {
            color: var(--text-error);
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .success-message {
            background: var(--bg-success);
            border: 1px solid var(--border-success);
            color: var(--text-success);
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        .avatar-picker {
            margin-bottom: 20px;
        }

        .avatar-picker > label {
            margin-bottom: 12px;
        }

        .avatar-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .avatar-option {
            position: relative;
            cursor: pointer;
        }

        .avatar-option input[type="radio"] {
            display: none;
        }

        .avatar-option img {
            width: 100%;
            border: 2px solid var(--input-border);
            border-radius: 50%;
            transition: all 0.3s;
            object-fit: cover;
        }

        .avatar-option input[type="radio"]:checked + img {
            border-color: var(--border-color);
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.6);
            transform: scale(1.05);
        }

        .avatar-option img:hover {
            border-color: var(--border-color);
        }

        .upload-section {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--input-border);
        }

        .upload-text {
            color: var(--border-color);
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 10px;
            display: block;
        }

        .upload-btn {
            width: auto;
            padding: 10px 20px;
            background: var(--input-border);
            color: var(--border-color);
            border: 1px solid var(--border-color);
            margin-top: 0;
            font-size: 14px;
            display: inline-block;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.3s;
        }

        .upload-btn:hover {
            background: var(--border-color);
            color: var(--bg-primary);
            border-color: var(--border-color);
        }

        .avatar-preview-container {
            margin-top: 15px;
            text-align: center;
            min-height: 80px;
            display: none;
        }

        .avatar-preview-container.show {
            display: block;
        }

        .preview-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid var(--border-color);
            object-fit: cover;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
        }

        #avatarFileInput {
            display: none;
        }

        .crop-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.9);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }

        .crop-modal.show {
            display: flex;
        }

        .crop-container {
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .crop-container h2 {
            color: var(--border-color);
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
        }

        .crop-canvas-wrapper {
            position: relative;
            width: 300px;
            height: 300px;
            margin: 0 auto 20px;
            border: 2px solid var(--input-border);
            overflow: hidden;
            background: var(--input-bg);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        #cropCanvas {
            display: block;
            cursor: grab;
        }

        #cropCanvas:active {
            cursor: grabbing;
        }

        .circle-overlay {
            position: absolute;
            width: 280px;
            height: 280px;
            border: 2px solid var(--border-color);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            box-shadow: inset 0 0 20px rgba(212, 175, 55, 0.3);
        }

        .crop-actions {
            display: flex;
            gap: 10px;
        }

        .crop-actions button {
            flex: 1;
            padding: 10px;
            border-radius: 4px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.3s;
        }

        .crop-actions button.cancel {
            background: var(--bg-error);
            border: 1px solid var(--border-error);
            color: var(--text-error);
        }

        .crop-actions button.cancel:hover {
            background: var(--border-error);
            color: white;
        }

        .crop-actions button.confirm {
            background: var(--border-color);
            color: var(--bg-primary);
        }

        .crop-actions button.confirm:hover {
            background: var(--text-light);
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: var(--border-color);
            color: var(--bg-primary);
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.3s ease, color 0.3s ease;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background: var(--text-light);
        }

        .submit-btn:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SETTINGS</h1>
        <div class="header-actions">
            <button class="theme-toggle-btn" onclick="toggleTheme()" title="Toggle theme">
                <span id="themeIcon">🌙</span>
            </button>
            <a href="{{ route('dashboard') }}" class="back-link">← Back to Dashboard</a>
        </div>
    </div>

    <div class="container">
        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <!-- Profile Settings Section -->
        <div class="settings-section">
            <h2>Profile Settings</h2>
            <form method="POST" action="{{ route('update-profile') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Username</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ Auth::user()->name }}"
                        required
                    >
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="avatar-picker">
                    <label>Profile Picture</label>
                    <div class="avatar-grid">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="avatar-option">
                                <input 
                                    type="radio" 
                                    name="profile_picture" 
                                    value="avatar{{ $i }}.png"
                                    {{ str_ends_with(Auth::user()->profile_picture, 'avatar' . $i . '.png') ? 'checked' : '' }}
                                >
                                <img src="/images/avatars/avatar{{ $i }}.png" alt="Avatar {{ $i }}">
                            </label>
                        @endfor
                    </div>
                    
                    <div class="upload-section">
                        <span class="upload-text">Or upload your own</span>
                        <input type="file" id="avatarFileInput" accept="image/*">
                        <button type="button" class="upload-btn" id="uploadBtn" onclick="document.getElementById('avatarFileInput').click()">📁 Select Avatar</button>
                        
                        <div class="avatar-preview-container" id="previewContainer">
                            <img id="previewImage" class="preview-image" alt="Avatar preview">
                        </div>
                    </div>
                </div>

                <input type="hidden" name="custom_avatar" id="customAvatarInput" value="">

                <button type="submit" class="submit-btn">Save Profile</button>
            </form>
        </div>

        <!-- Password Settings Section -->
        <div class="settings-section">
            <h2>Change Password</h2>
            <form method="POST" action="{{ route('update-password') }}">
                @csrf

                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input 
                        type="password" 
                        id="current_password" 
                        name="current_password" 
                        required
                    >
                    @error('current_password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                    >
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required
                    >
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">Update Password</button>
            </form>
        </div>
    </div>

    <!-- Crop Modal -->
    <div class="crop-modal" id="cropModal">
        <div class="crop-container">
            <h2>Crop Your Avatar</h2>
            <div class="crop-canvas-wrapper">
                <canvas id="cropCanvas"></canvas>
                <div class="circle-overlay"></div>
            </div>
            <div class="crop-actions">
                <button type="button" class="cancel" onclick="closeCropModal()">Cancel</button>
                <button type="button" class="confirm" onclick="saveCrop()">Save Avatar</button>
            </div>
        </div>
    </div>

    <script>
        let cropImage = null;
        let canvasContext = null;
        let imageX = 0;
        let imageY = 0;
        let imageScale = 1;
        let isDragging = false;
        let dragStartX = 0;
        let dragStartY = 0;
        let selectedFilename = '';

        const canvas = document.getElementById('cropCanvas');
        canvasContext = canvas.getContext('2d');
        canvas.width = 300;
        canvas.height = 300;

        document.getElementById('avatarFileInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                selectedFilename = file.name;
                const reader = new FileReader();
                reader.onload = function(event) {
                    cropImage = new Image();
                    cropImage.onload = function() {
                        imageX = 0;
                        imageY = 0;
                        imageScale = 1;
                        openCropModal();
                    };
                    cropImage.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        function openCropModal() {
            document.getElementById('cropModal').classList.add('show');
            drawCropCanvas();
        }

        function closeCropModal() {
            document.getElementById('cropModal').classList.remove('show');
            cropImage = null;
        }

        function drawCropCanvas() {
            if (!cropImage) return;

            canvasContext.fillStyle = '#1a1a1a';
            canvasContext.fillRect(0, 0, canvas.width, canvas.height);

            canvasContext.save();
            canvasContext.translate(canvas.width / 2, canvas.height / 2);
            canvasContext.scale(imageScale, imageScale);
            canvasContext.drawImage(cropImage, imageX - canvas.width / (2 * imageScale), imageY - canvas.height / (2 * imageScale));
            canvasContext.restore();
        }

        function zoomImage(direction) {
            const oldScale = imageScale;
            imageScale = Math.max(0.1, Math.min(3, imageScale + direction));
            
            const adjustment = canvas.width / 2 * (1 / oldScale - 1 / imageScale);
            imageX += adjustment;
            imageY += adjustment;
            
            drawCropCanvas();
        }

        canvas.addEventListener('mousedown', function(e) {
            isDragging = true;
            dragStartX = e.clientX;
            dragStartY = e.clientY;
        });

        canvas.addEventListener('mousemove', function(e) {
            if (isDragging) {
                const deltaX = e.clientX - dragStartX;
                const deltaY = e.clientY - dragStartY;
                imageX += deltaX / imageScale;
                imageY += deltaY / imageScale;
                dragStartX = e.clientX;
                dragStartY = e.clientY;
                drawCropCanvas();
            }
        });

        canvas.addEventListener('mouseup', function() {
            isDragging = false;
        });

        canvas.addEventListener('mouseleave', function() {
            isDragging = false;
        });

        canvas.addEventListener('wheel', function(e) {
            e.preventDefault();
            const direction = e.deltaY > 0 ? -0.1 : 0.1;
            zoomImage(direction);
        });

        function saveCrop() {
            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = 300;
            tempCanvas.height = 300;
            const tempContext = tempCanvas.getContext('2d');

            tempContext.save();
            tempContext.translate(150, 150);
            tempContext.scale(imageScale, imageScale);
            tempContext.drawImage(cropImage, imageX - 150 / imageScale, imageY - 150 / imageScale);
            tempContext.restore();

            const circleCanvas = document.createElement('canvas');
            circleCanvas.width = 300;
            circleCanvas.height = 300;
            const circleContext = circleCanvas.getContext('2d');

            circleContext.fillStyle = 'white';
            circleContext.beginPath();
            circleContext.arc(150, 150, 140, 0, Math.PI * 2);
            circleContext.fill();

            const croppedCanvas = document.createElement('canvas');
            croppedCanvas.width = 300;
            croppedCanvas.height = 300;
            const croppedContext = croppedCanvas.getContext('2d');

            croppedContext.putImageData(tempContext.getImageData(0, 0, 300, 300), 0, 0);
            croppedContext.globalCompositeOperation = 'destination-in';
            croppedContext.drawImage(circleCanvas, 0, 0);

            document.getElementById('customAvatarInput').value = croppedCanvas.toDataURL('image/png');
            
            document.querySelectorAll('input[name="profile_picture"]').forEach(input => {
                input.checked = false;
            });

            closeCropModal();
            
            document.getElementById('uploadBtn').textContent = '📁 ' + selectedFilename;
            document.getElementById('previewImage').src = croppedCanvas.toDataURL('image/png');
            document.getElementById('previewContainer').classList.add('show');
        }

        // Theme Toggle
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme') || 'dark';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
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
