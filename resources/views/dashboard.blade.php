<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2>My notes:</h2>
                    <table class="notes">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Priority</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notes as $note)
                            <tr>
                                <td>{{ $note->getDescription() }}</td>
                                <td>{{ $note->getStatus() }}</td>
                                <td>{{ $note->getPriority() }}</td>
                                <td x-data="{open:false}"><button x-on:click="open = !open">Edit</button>
                                    <form x-show="open" class="stdForm" action="{{ route('note.edit', ['id' => $note->getId()]) }}" method="POST">
                                        @csrf
                                        <textarea id="description" name="description">{{ $note->getDescription() }}</textarea>
                                        <div class="input-field">
                                            <span>Priority:</span>
                                            <input type="radio" name="priority" id="low-priority" value="low" placeholder="Low" {{ $note->getPriority() == 'low' ? 'checked' : '' }}>
                                            <label for="low-priority">Low</label>
                                            <input type="radio" name="priority" id="medium-priority" value="medium" {{ $note->getPriority() == 'medium' ? 'checked' : '' }}>
                                            <label for="medium-priority">Medium</label>
                                            <input type="radio" name="priority" id="high-priority" value="high" {{ $note->getPriority() == 'high' ? 'checked' : '' }}>
                                            <label for="high-priority">High</label>
                                        </div>
                                        <button type="submit">Save changes</button>
                                    </form>
                                </td>
                                <td><button>Complete</button></td>
                            </tr>              
                            @endforeach  
                        </tbody>                                
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100" x-data="{open:false}">
                    <button x-on:click="open = !open">Add a note</button>
                    <form x-show="open" class="stdForm" action="{{ route('note.create') }}" method="POST">
                        @csrf
                        <textarea id="description" name="description" placeholder="Write a new note..."></textarea>
                        <div class="input-field">
                            <span>Priority:</span>
                            <input type="radio" name="priority" id="low-priority" value="low" placeholder="Low">
                            <label for="low-priority">Low</label>
                            <input type="radio" name="priority" id="medium-priority" value="medium" checked>
                            <label for="medium-priority">Medium</label>
                            <input type="radio" name="priority" id="high-priority" value="high">
                            <label for="high-priority">High</label>
                        </div>
                        <button type="submit">Add new</button>
                    </form>
                </div>
            </div>
        </div>
    </div> 
</x-app-layout>

@push('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
