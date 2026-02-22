<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - RDR2 Progress Tracker</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #e0e0e0;
        }

        .container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }

        .register-box {
            background: #222;
            border: 2px solid #d4af37;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        }

        .register-box h1 {
            text-align: center;
            color: #d4af37;
            margin-bottom: 30px;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #d4af37;
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
            border: 1px solid #444;
            border-radius: 4px;
            background: #1a1a1a;
            color: #e0e0e0;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #d4af37;
            box-shadow: 0 0 5px rgba(212, 175, 55, 0.3);
        }

        .error-message {
            color: #ff6b6b;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .avatar-picker {
            margin-bottom: 20px;
        }

        .avatar-picker label {
            margin-bottom: 12px;
        }

        .avatar-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
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
            border: 2px solid #444;
            border-radius: 50%;
            transition: all 0.3s;
            object-fit: cover;
        }

        .avatar-option input[type="radio"]:checked + img {
            border-color: #d4af37;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.6);
            transform: scale(1.05);
        }

        .avatar-option img:hover {
            border-color: #d4af37;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #d4af37;
            color: #1a1a1a;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 24px;
        }

        button:hover {
            background: #f0c04f;
        }

        button:active {
            transform: scale(0.98);
        }

        .upload-section {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #444;
        }

        .upload-text {
            color: #d4af37;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 10px;
            display: block;
        }

        .upload-btn {
            width: auto;
            padding: 10px 20px;
            background: #444;
            color: #d4af37;
            border: 1px solid #d4af37;
            margin-top: 0;
            font-size: 14px;
            display: inline-block;
        }

        .upload-btn:hover {
            background: #555;
            color: #f0c04f;
            border-color: #f0c04f;
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

        .preview-filename {
            color: #d4af37;
            font-size: 12px;
            margin-bottom: 10px;
            max-width: 200px;
            margin-left: auto;
            margin-right: auto;
            word-break: break-word;
        }

        .preview-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid #d4af37;
            object-fit: cover;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
        }

        .change-avatar-link {
            color: #d4af37;
            font-size: 11px;
            margin-top: 8px;
            cursor: pointer;
            text-decoration: underline;
            display: block;
        }

        .change-avatar-link:hover {
            color: #f0c04f;
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
            background: #222;
            border: 2px solid #d4af37;
            border-radius: 8px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .crop-container h2 {
            color: #d4af37;
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
        }

        .crop-canvas-wrapper {
            position: relative;
            width: 300px;
            height: 300px;
            margin: 0 auto 20px;
            border: 2px solid #444;
            overflow: hidden;
            background: #1a1a1a;
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
            border: 2px solid #d4af37;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            box-shadow: inset 0 0 20px rgba(212, 175, 55, 0.3);
        }

        .crop-controls {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .crop-control-btn {
            display: none;
        }

        .crop-actions {
            display: flex;
            gap: 10px;
        }

        .crop-actions button {
            flex: 1;
            margin-top: 0;
            padding: 10px;
        }

        .crop-actions button.cancel {
            background: #4e1a1a;
            border: 1px solid #900;
            color: white;
        }

        .crop-actions button.confirm {
            background: #d4af37;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .login-link a {
            color: #d4af37;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #f0c04f;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
        }

        .alert-danger {
            background: #3a1a1a;
            border: 1px solid #ff6b6b;
            color: #ff6b6b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-box">
            <h1>Register</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/register">
                @csrf

                <div class="form-group">
                    <label for="name">Username</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        required 
                        autofocus
                    >
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
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
                    <label for="password_confirmation">Confirm Password</label>
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

                <div class="avatar-picker">
                    <label>Choose Your Avatar (or we'll pick one of the above!)</label>
                    <div class="avatar-grid">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="avatar-option">
                                <input 
                                    type="radio" 
                                    name="profile_picture" 
                                    value="avatar{{ $i }}.png"
                                    {{ old('profile_picture') == "avatar{$i}.png" ? 'checked' : '' }}
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

                <button type="submit">Register</button>
            </form>

            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Login here</a>
            </div>
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
            
            // Keep the center point fixed during zoom
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
            // Create a temporary canvas for the circular crop
            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = 300;
            tempCanvas.height = 300;
            const tempContext = tempCanvas.getContext('2d');

            // Draw the image
            tempContext.save();
            tempContext.translate(150, 150);
            tempContext.scale(imageScale, imageScale);
            tempContext.drawImage(cropImage, imageX - 150 / imageScale, imageY - 150 / imageScale);
            tempContext.restore();

            // Create circle clip
            const circleCanvas = document.createElement('canvas');
            circleCanvas.width = 300;
            circleCanvas.height = 300;
            const circleContext = circleCanvas.getContext('2d');

            circleContext.fillStyle = 'white';
            circleContext.beginPath();
            circleContext.arc(150, 150, 140, 0, Math.PI * 2);
            circleContext.fill();

            // Mask the image with the circle
            const croppedCanvas = document.createElement('canvas');
            croppedCanvas.width = 300;
            croppedCanvas.height = 300;
            const croppedContext = croppedCanvas.getContext('2d');

            croppedContext.putImageData(tempContext.getImageData(0, 0, 300, 300), 0, 0);
            croppedContext.globalCompositeOperation = 'destination-in';
            croppedContext.drawImage(circleCanvas, 0, 0);

            // Save to hidden input
            document.getElementById('customAvatarInput').value = croppedCanvas.toDataURL('image/png');
            
            // Deselect default avatars
            document.querySelectorAll('input[name="profile_picture"]').forEach(input => {
                input.checked = false;
            });

            closeCropModal();
            
            // Update button text with filename
            document.getElementById('uploadBtn').textContent = '📁 ' + selectedFilename;
            
            // Show preview
            document.getElementById('previewImage').src = croppedCanvas.toDataURL('image/png');
            document.getElementById('previewContainer').classList.add('show');
        }
    </script>
</body>
</html>
