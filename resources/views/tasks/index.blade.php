<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-6 text-center">Task Manager</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">Add New Task</a>

        <div class="space-y-4">
            @forelse($tasks as $task)
                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg shadow">
                    <div class="flex-grow">
                        <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                <span class="ml-3 text-lg {{ $task->completed ? 'line-through text-gray-500' : '' }}">{{ $task->title }}</span>
                            </label>
                        </form>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('tasks.edit', $task) }}" class="text-yellow-600 hover:text-yellow-800">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828L15.414 7.414 12 4l3.586-3.586zM15 8l-6 6-4-4 6-6 4-4zM16 4l2-2-2-2-2 2zM3 17a1 1 0 01-1-1v-2l6-6 4 4-6 6zM15 11l-4 4-2-2 4-4 2 2z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                        </a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 011 1v1a1 1 0 01-1 1H5a1 1 0 01-1-1v-1a1 1 0 011-1h4zM4 6a2 2 0 012-2h4a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm4 2a1 1 0 011 1v6a1 1 0 11-2 0V9a1 1 0 011-1zm4 0a1 1 0 011 1v6a1 1 0 11-2 0V9a1 1 0 011-1z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center">No tasks found. Start by adding a new task!</p>
            @endforelse
        </div>
    </div>
</body>
</html>