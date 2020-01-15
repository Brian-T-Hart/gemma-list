@extends('layouts.app')

@section('content')

<div class="home-container row">
    @include('errors')

    <div id="lists-container" class="col-sm-12 lists-container sortable-lists">
    
        @foreach ($glists->sortBy('order') as $glist)

            @if (!$glist->archived)

                <div class="list-container" id="glist-container_{{ $glist->id }}">
                
                    <div class="list-header">
                        
                        <div class="glist-header" id="glist-header-{{ $glist->id }}">

                            <a class="glist-dropdown-btn dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                
                                <h3 class="list-name mb-1">{{ $glist->name }}</h3>
                                
                                <span class="caret"></span>

                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <button class="dropdown-item edit-glist-btn" data-id="{{ $glist->id }}">Edit List</button>

                                <form class="hidden-glist" method="POST" action="/glists/{{ $glist->id }}/archive">
                                
                                    @csrf
                                    @method('PATCH')

                                    <button class="dropdown-item" type="submit">Hide List</button>
                            
                                </form>

                                <form method="POST" action="/glists/{{ $glist->id }}/delete">

                                    @method('DELETE')

                                    @csrf

                                    <button class="dropdown-item" onclick="handleDelete({{$glist->id}})" type="submit">Delete List</button>

                                </form>

                            </div>

                            <div class="dropdown"></div>
                        
                        </div>

                        <div class="edit-glist mb-2 mt-2 hidden" id="edit-glist-{{ $glist->id }}">

                            <form class="edit-glist-form font-small" method="POST" action="/glists/{{ $glist->id }}">
                            
                                @csrf
                                @method('PATCH')

                                <input name="name" type="text" value="{{ $glist->name }}">

                                <button type="submit">update</button>

                                <button id="close-edit-{{ $glist->id }}">x</button>
                                
                            </form>

                        </div>
                        
                    </div>

                    <div class="add-task-container mb-2">

                        <form class="add-task-form font-small" method="POST" action="/glists/{{ $glist->id }}/task">

                            @csrf

                            <input class="add-task-input" type="text" name="title" placeholder="Add Task" required>

                            <button class="button task-add" type="submit">+</button>

                        </form>

                    </div>

                    <div id="task-container-{{ $glist->id }}" class="task-container sortable-tasks">
                        
                        @foreach ($glist->tasks->sortBy('order') as $task)

                            <form id="task_{{ $task->id }}" action="/tasks/completed/{{ $task->id }}" method="POST">

                                @method('PATCH')
                                @csrf

                                <input type="checkbox" name="completed" onChange="handleCheck()" {{ $task->completed ? 'checked' : '' }}>
                                
                                <label id="task-label-{{ $task->id }}" for="completed" class="checkbox {{ $task->completed ? 'is-completed' : '' }}" onClick="handleTaskEdit('{{ $task->id }}')">

                                {{ $task->title }}

                                </label>

                            </form>

                            <!-- edit task form -->
                            <form action="tasks/{{ $task->id }}" class="hidden" id="edit-task-form-{{ $task->id }}" onsubmit="handleTaskEditSubmit({{ $task->id }})">

                                @method('PATCH')
                                @csrf

                                <input type="text" name="title" value="{{ $task->title }}" />

                                <button type="submit">save</button>

                                <button id="close-task-edit-{{ $task->id }}" onClick="handleTaskEditCancel({{ $task->id }})">x</button>

                            </form>

                        @endforeach
                
                    </div>
            
                </div>

            @endif

        @endforeach

        <!-- add new list -->
        <div id="new-list-container" class="list-container">

            <form action="/glists" class="font-small" method="POST">

                @csrf

                <input name="name" type="text" value="{{ old('name') }}" placeholder="add a new list" required>
                
                <button class="button list-add" type="submit">+</button>

            </form>
        
        </div> <!-- end add new list -->

    </div>

</div>

@endsection
