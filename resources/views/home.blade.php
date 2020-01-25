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

                            </a>

                            <span class="drag-icon" title="click to drag"><i class="fas fa-grip-horizontal"></i></span>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <button class="dropdown-item edit-glist-btn" data-id="{{ $glist->id }}" title="Edit List Name"><i class="far fa-edit"></i> Name</button>
                                
                                <!-- hide list -->
                                <form class="hidden-glist" method="POST" action="/glists/{{ $glist->id }}/archive">

                                    @csrf
                                    @method('PATCH')

                                    <button class="dropdown-item" type="submit" title="Hide List"><i class="far fa-eye-slash"></i> List</button>
                            
                                </form>

                                <!-- delete completed tasks from glist -->
                                <form method="POST" action="/tasks/delete/{{ $glist->id }}">

                                    @method('DELETE')
                                    @csrf

                                    <button class="dropdown-item" type="submit" title="Delete completed tasks"><i class="far fa-trash-alt"></i> Tasks</button>

                                </form>

                                <!-- delete the list -->
                                <form method="POST" action="/glists/{{ $glist->id }}/delete">

                                    @method('DELETE')

                                    @csrf

                                    <button class="dropdown-item" onclick="handleDelete({{$glist->id}})" type="submit" title="Delete list"><i class="fas fa-trash"></i> List</button>

                                </form>

                            </div>

                            <div class="dropdown"></div>
                        
                        </div>

                        <!-- edit glist name -->
                        <div class="edit-glist mb-2 mt-2 hidden" id="edit-glist-{{ $glist->id }}">

                            <form class="edit-glist-form font-small" method="POST" action="/glists/{{ $glist->id }}">
                            
                                @csrf
                                @method('PATCH')

                                <input name="name" type="text" value="{{ $glist->name }}">

                                <button class="btn-check" type="submit"><i class="fas fa-check"></i></button>

                                <button class="btn-cancel" id="close-edit-{{ $glist->id }}"><i class="fas fa-times"></i></button>
                                
                            </form>

                        </div>
                        
                    </div>

                    <div class="add-task-container mb-2">

                        <form class="add-task-form font-small" method="POST" action="/glists/{{ $glist->id }}/task">

                            @csrf

                            <input class="add-task-input" type="text" name="title" placeholder="Add Task" onInput="handleBtnCheck()" required>

                            <button class="btn-check task-add" type="submit"><i class="fas fa-check"></i></button>

                        </form>

                    </div>

                    <div id="task-container-{{ $glist->id }}" class="task-container sortable-tasks">
                        
                        @foreach ($glist->tasks->sortBy('order') as $task)

                            <form id="task_{{ $task->id }}" action="/tasks/completed/{{ $task->id }}" method="POST">

                                @method('PATCH')
                                @csrf

                                <input type="checkbox" name="completed" onChange="handleCheck()" {{ $task->completed ? 'checked' : '' }}>
                                
                                <label id="task-label-{{ $task->id }}" for="completed" class="checkbox-label {{ $task->completed ? 'is-completed' : '' }}" onClick="handleTaskEdit('{{ $task->id }}')">

                                {{ $task->title }}

                                </label>

                            </form>

                            <!-- edit task form -->
                            <form action="tasks/{{ $task->id }}" class="hidden edit-task-form" id="edit-task-form-{{ $task->id }}" onsubmit="handleTaskEditSubmit({{ $task->id }})">

                                @method('PATCH')
                                @csrf

                                <input type="text" name="title" value="{{ $task->title }}" />

                                <button class="btn-check" type="submit" title="update"><i class="fas fa-check"></i></button>

                                <button class="btn-cancel" id="close-task-edit-{{ $task->id }}" onClick="handleTaskEditCancel({{ $task->id }})" title="cancel"><i class="fas fa-times"></i></button>

                            </form>

                        @endforeach
                
                    </div>
            
                </div>

            @endif

        @endforeach

    </div>

</div>

@endsection
