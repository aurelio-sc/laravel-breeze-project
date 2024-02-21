<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }} - {{ $user[0]->name }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if (count($active_notes))
                <section class="p-6 text-gray-900 dark:text-gray-100 flex flex-col gap-4">
                    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">My active notes:</h2>
                    <table class="notes w-full flex flex-col gap-2">
                        <thead>
                            <tr class="grid grid-cols-6 w-full text-left">
                                <th class="col-start-1 col-span-2 text-xl text-gray-800 dark:text-gray-100">Description</th>                                
                                <th class="col-start-3 col-span-1 text-xl text-xl text-gray-800 dark:text-gray-100">Priority</th>                                
                            </tr>
                        </thead>
                        <tbody class="flex flex-col gap-2">
                            @foreach ($active_notes as $note)
                            <tr class="grid grid-cols-6 w-full">
                                <td class="col-start-1 col-span-2 text-gray-300">{{ $note->getDescription() }}</td>                                
                                <td class="col-start-3 col-span-1" style="color:{{ $note->getPriorityColor() }}">{{ $note->getPriority() }}</td>
                                <td class="col-start-4 col-span-2 text-right flex flex-col gap-2" x-data="{open:false}">
                                    <div>
                                        <button class="text-gray-800 dark:text-gray-100 border-b border-transparent hover:border-gray-800 dark:hover:border-gray-100" x-on:click="open = !open">Edit</button>
                                    </div>
                                    <form class="stdForm w-full flex flex-col gap-2" x-show="open" action="{{ route('note.edit', ['id' => $note->getId()]) }}" method="POST">
                                        @csrf
                                        <textarea class="resize-none bg-transparent px-3 rounded" id="description" name="description">{{ $note->getDescription() }}</textarea>
                                        <div class="input-field flex flex-row gap-4">
                                            <span class="grow text-left">Priority:</span>
                                            <div class="radio-input flex items-center gap-1">
                                                <input class="checked:text-sky-600 bg-gray-300 checked:bg-none cursor-pointer" type="radio" name="priority" id="low-priority" value="low" placeholder="Low" {{ $note->getPriority() == 'low' ? 'checked' : '' }}>
                                                <label for="low-priority">Low</label>
                                            </div>
                                            <div class="radio-input flex items-center gap-1">
                                                <input class="checked:text-sky-600 bg-gray-300 checked:bg-none cursor-pointer" type="radio" name="priority" id="medium-priority" value="medium" {{ $note->getPriority() == 'medium' ? 'checked' : '' }}>
                                                <label for="medium-priority">Medium</label>
                                            </div>
                                            <div class="radio-input flex items-center gap-1">
                                                <input class="checked:text-sky-600 bg-gray-300 checked:bg-none cursor-pointer" type="radio" name="priority" id="high-priority" value="high" {{ $note->getPriority() == 'high' ? 'checked' : '' }}>
                                                <label for="high-priority">High</label>
                                            </div>
                                        </div>
                                        <button class="w-fit text-left border border-solid rounded px-2 py-1 text-gray-800 dark:text-gray-100" type="submit">Save changes</button>
                                    </form>
                                </td>
                                <td class="col-start-6 col-span-1 text-right">
                                    <form action="{{ route('note.complete', ['id' => $note->getId()]) }}" method="POST">
                                        @csrf
                                         <button class="text-gray-800 dark:text-gray-100 border-b border-transparent hover:border-gray-800 dark:hover:border-gray-100" type="submit">Complete</button>
                                    </form>
                                </td>
                            </tr>              
                            @endforeach  
                        </tbody>                                
                    </table>
                    {{ $active_notes->links() }}
                </section>
                @endif

                <section class="p-6 text-gray-900 dark:text-gray-100" x-data="{open:false}">
                    <button class="text-gray-800 dark:text-gray-100 border-b border-transparent hover:border-gray-800 dark:hover:border-gray-100" x-on:click="open = !open">Add a note</button>
                    <form x-show="open" class="stdForm w-1/3 flex flex-col gap-2" action="{{ route('note.create') }}" method="POST">
                        @csrf
                        <textarea class="resize-none bg-transparent px-3 rounded mt-2 placeholder-gray-300" id="description" name="description" placeholder="Note's description"></textarea>
                        <div class="input-field flex flex-row gap-4">
                            <span class="grow text-left">Priority:</span>
                            <div class="radio-input flex items-center gap-1">
                                <input class="checked:text-sky-600 bg-gray-300 checked:bg-none cursor-pointer" type="radio" name="priority" id="low-priority" value="low" placeholder="Low">
                                <label for="low-priority">Low</label>
                            </div>
                            <div class="radio-input flex items-center gap-1">
                                <input class="checked:text-sky-600 bg-gray-300 checked:bg-none cursor-pointer" type="radio" name="priority" id="medium-priority" value="medium" checked>
                                <label for="medium-priority">Medium</label>
                            </div>
                            <div class="radio-input flex items-center gap-1">
                                <input class="checked:text-sky-600 bg-gray-300 checked:bg-none cursor-pointer" type="radio" name="priority" id="high-priority" value="high">
                                <label for="high-priority">High</label>
                            </div>
                        </div>
                        <button class="w-fit text-left border border-solid rounded px-2 py-1 text-gray-800 dark:text-gray-100" type="submit">Add note</button>
                    </form>
                </section>

                @if (count($completed_notes))
                <section class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight mb-4">My completed notes:</h2>
                    <table class="notes w-full flex flex-col gap-2">
                        <thead>
                            <tr class="grid grid-cols-6 w-full text-left">
                                <th class="col-start-1 col-span-2 text-xl text-gray-800 dark:text-gray-100">Description</th>                                
                                <th class="col-start-3 col-span-1 text-xl text-gray-800 dark:text-gray-100">Priority</th>                                
                            </tr>
                        </thead>
                        <tbody class="flex flex-col gap-2">
                            @foreach ($completed_notes as $note)
                            <tr class="grid grid-cols-6 w-full">
                                <td class="col-start-1 col-span-2 text-gray-300">{{ $note->getDescription() }}</td>                                
                                <td class="col-start-3 col-span-1" style="color:{{ $note->getPriorityColor() }}">{{ $note->getPriority() }}</td>
                                <td class="col-start-4 col-span-2 text-right">
                                    <form action="{{ route('note.activate', ['id' => $note->getId()]) }}" method="POST">
                                        @csrf
                                        <button class="text-gray-800 dark:text-gray-100 border-b border-transparent hover:border-gray-800 dark:hover:border-gray-100" type="submit">Activate</button>
                                    </form>
                                </td>
                                <td class="col-start-6 col-span-1 text-right">
                                    <form action="{{ route('note.delete', ['id' => $note->getId()]) }}" method="POST">
                                        @csrf
                                        <button class="text-gray-800 dark:text-gray-100 border-b border-transparent hover:text-red-300 hover:border-red-300" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>              
                            @endforeach  
                        </tbody>                                
                    </table>
                </section>
                @endif                
            </div>
        </div>
    </div>
    
</x-app-layout>

@push('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
