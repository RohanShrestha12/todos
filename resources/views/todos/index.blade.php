@extends('layouts.app')

@section('title', 'My Todos')
@section('header', 'My Todos')

@section('header-actions')
    <a href="{{ route('todos.create') }}" class="btn btn-primary">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/>
        </svg>
        New Todo
    </a>
@endsection

@push('styles')
<style>
    .todos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
    }

    .todo-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .todo-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        border-color: #667eea;
    }

    .todo-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: linear-gradient(135deg, #667eea20 0%, #764ba220 100%);
    }

    .todo-content {
        padding: 24px;
    }

    .todo-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 12px;
        gap: 12px;
    }

    .todo-title {
        font-size: 20px;
        font-weight: 600;
        color: #2d3748;
        line-height: 1.4;
        flex: 1;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-completed {
        background: #d1fae5;
        color: #065f46;
    }

    .todo-description {
        color: #718096;
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .todo-actions {
        display: flex;
        gap: 10px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }

    .btn-small {
        padding: 10px 18px;
        font-size: 14px;
        flex: 1;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 16px;
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 24px;
        opacity: 0.3;
    }

    .empty-state h2 {
        font-size: 24px;
        color: #4a5568;
        margin-bottom: 12px;
    }

    .empty-state p {
        color: #718096;
        margin-bottom: 24px;
    }
</style>
@endpush

@section('content')
@if($todos->count() > 0)
    <div class="todos-grid">
        @foreach($todos as $todo)
            <div class="todo-card">
                @if($todo->image)
                    <img src="{{ asset('storage/' . $todo->image) }}" alt="{{ $todo->title }}" class="todo-image">
                @else
                    <div class="todo-image"></div>
                @endif
                
                <div class="todo-content">
                    <div class="todo-header">
                        <h3 class="todo-title">{{ $todo->title }}</h3>
                        <span class="status-badge status-{{ $todo->status }}">
                            {{ $todo->status }}
                        </span>
                    </div>
                    
                    @if($todo->description)
                        <p class="todo-description">{{ $todo->description }}</p>
                    @endif
                    
                    <div class="todo-actions">
                        <a href="{{ route('todos.edit', $todo) }}" class="btn btn-secondary btn-small">
                            Edit
                        </a>
                        <form action="{{ route('todos.destroy', $todo) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Are you sure you want to delete this todo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-small" style="width: 100%;">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <h2>No todos yet</h2>
        <p>Start organizing your tasks by creating your first todo</p>
        <a href="{{ route('todos.create') }}" class="btn btn-primary">
            Create Your First Todo
        </a>
    </div>
@endif
@endsection


@push('styles')
<style>
    /* Previous styles remain... */
    
    .filters-bar {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .filter-group {
        display: flex;
        gap: 8px;
        align-items: center;
        flex: 1;
        min-width: 200px;
    }
    
    .filter-input {
        flex: 1;
        padding: 10px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
    }
    
    .filter-input:focus {
        outline: none;
        border-color: #667eea;
    }
    
    .filter-select {
        padding: 10px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        background: white;
        cursor: pointer;
    }
    
    .stats-bar {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    
    .stat-card {
        flex: 1;
        min-width: 200px;
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .stat-label {
        color: #718096;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #2d3748;
    }
    
    .stat-pending { color: #d97706; }
    .stat-completed { color: #059669; }
</style>
@endpush

@section('content')
<!-- Statistics -->
<div class="stats-bar">
    <div class="stat-card">
        <div class="stat-label">Total Tasks</div>
        <div class="stat-value">{{ $todos->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Pending</div>
        <div class="stat-value stat-pending">{{ $todos->where('status', 'pending')->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Completed</div>
        <div class="stat-value stat-completed">{{ $todos->where('status', 'completed')->count() }}</div>
    </div>
</div>

<!-- Filters -->
<form method="GET" action="{{ route('todos.index') }}" class="filters-bar">
    <div class="filter-group">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="#718096">
            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"/>
        </svg>
        <input 
            type="text" 
            name="search" 
            placeholder="Search todos..." 
            class="filter-input"
            value="{{ request('search') }}"
        >
    </div>
    
    <select name="status" class="filter-select" onchange="this.form.submit()">
        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
    </select>
    
    <select name="sort" class="filter-select" onchange="this.form.submit()">
        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date Created</option>
        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title</option>
        <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>Status</option>
    </select>
    
    <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">
        Apply
    </button>
</form>
