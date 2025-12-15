@extends('layouts.app')

@section('title', 'Create Todo')
@section('header', 'Create New Todo')

@section('header-actions')
    <a href="{{ route('todos.index') }}" class="btn btn-secondary">
        ← Back to Todos
    </a>
@endsection

@push('styles')
<style>
    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
        font-size: 15px;
    }

    .form-input, .form-textarea, .form-select {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 15px;
        font-family: inherit;
        transition: all 0.3s ease;
        background: #f7fafc;
    }

    .form-input:focus, .form-textarea:focus, .form-select:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .file-upload {
        position: relative;
        display: block;
    }

    .file-upload-input {
        display: none;
    }

    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 40px;
        border: 2px dashed #cbd5e0;
        border-radius: 10px;
        background: #f7fafc;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #4a5568;
        font-weight: 500;
    }

    .file-upload-label:hover {
        border-color: #667eea;
        background: #edf2f7;
    }

    .image-preview {
        margin-top: 16px;
        border-radius: 10px;
        overflow: hidden;
        display: none;
    }

    .image-preview img {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        padding-top: 12px;
    }

    .error-message {
        color: #e53e3e;
        font-size: 14px;
        margin-top: 6px;
    }
</style>
@endpush

@section('content')
<div class="content-card">
    <form action="{{ route('todos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="title" class="form-label">Title *</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                class="form-input" 
                value="{{ old('title') }}"
                placeholder="Enter todo title"
                required
            >
            @error('title')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea 
                id="description" 
                name="description" 
                class="form-textarea"
                placeholder="Add more details about this todo..."
            >{{ old('description') }}</textarea>
            @error('description')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="status" class="form-label">Status *</label>
            <select id="status" name="status" class="form-select" required>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            @error('status')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Image</label>
            <div class="file-upload">
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    class="file-upload-input"
                    accept="image/*"
                    onchange="previewImage(event)"
                >
                <label for="image" class="file-upload-label">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Click to upload an image</span>
                </label>
                <div class="image-preview" id="imagePreview">
                    <img src="" alt="Preview">
                </div>
            </div>
            @error('image')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                Create Todo
            </button>
            <a href="{{ route('todos.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.querySelector('img').src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@endsection
