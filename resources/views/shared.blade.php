@extends('layouts.app')

@section('content')

<div class="home-container row">

    @include('errors')

    <div id="lists-container" class="col-sm-12 lists-container sortable-lists">

        @if (count($glists) === 0)

        <div class="list-container">

            <div class="list-header">

                <h3>Shared Lists</h3>

            </div>

            <div class="font-weight-normal task-container">

                You do not have any shared lists at this time. When someone shares a list with you, it will be available here.

            </div>

        </div>

        @endif
    
        @foreach ($glists->sortBy('title') as $glist)

            @if (!$glist->shared_glists['archived'])

                <div class="list-container" id="glist-container_{{ $glist->id }}">
                
                    <div class="list-header">
                        
                        <div class="glist-header" id="glist-header-{{ $glist->id }}">

                            <a class="glist-dropdown-btn dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                
                                <h3 class="list-name mb-1">{{ $glist->name }}</h3>

                            </a>

                            <!-- <span class="drag-icon" title="click to drag"><i class="fas fa-grip-horizontal"></i></span> -->

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <!-- <button class="dropdown-item edit-glist-btn" data-id="{{ $glist->id }}" title="Edit List Name"><i class="far fa-edit"></i> Edit List Name</button> -->
                                
                                <!-- hide list -->
                                <!-- <form class="hidden-glist" method="POST" action="/glists/{{ $glist->id }}/archive">

                                    @csrf
                                    @method('PATCH')

                                    <button class="dropdown-item" type="submit" title="Hide List"><i class="far fa-eye-slash"></i> Hide List</button>
                            
                                </form> -->

                                <!-- import list -->
                                <!-- <button class="dropdown-item import-glist-btn" onclick="toggle('#import-list-{{ $glist->id }}')" title="Import tasks"><i class="far fa-copy"></i> Import Tasks From</button> -->

                                <!-- share list -->
                                <!-- <button class="dropdown-item share-glist-btn" onclick="toggle('#share-list-{{ $glist->id }}')" title="Share list"><i class="fas fa-share"></i> Share List</button> -->

                                <!-- delete completed tasks from glist -->
                                <form method="POST" action="/tasks/delete/{{ $glist->id }}">

                                    @method('DELETE')
                                    @csrf

                                    <button class="dropdown-item" type="submit" title="Delete completed tasks"><i class="far fa-trash-alt"></i> Delete Completed Tasks</button>

                                </form>

                                <!-- delete the list -->
                                <form method="POST" action="/shared/{{ $glist->id }}/delete">

                                    @method('DELETE')

                                    @csrf

                                    <button class="dropdown-item text-danger" onclick="handleShareLeave({{$glist->id}})" type="submit" title="Leave list"><i class="fas fa-minus-circle"></i> Leave List</button>

                                </form>

                            </div>

                            <!-- dropdown list of glists -->
                            <!-- <div class="hidden import-list mb-1" id="import-list-{{ $glist->id }}">
                                <div class="import-list-header pb-1 pt-1 pl-3">Import From<span class="pl-3 pr-3 pointer right" onclick="toggle('#import-list-{{ $glist->id }}')"><i class="fas fa-times"></i></span></div>
                                @foreach ($glists->sortBy('name') as $list)

                                        <form method="POST" action="/glists/{{ $list->id }}/copyto/{{ $glist->id }}">
                                                    
                                            @csrf

                                            <button class="archived-item dropdown-item pl-3" type="submit">{{ $list->name }}</button>
                                                
                                        </form>

                                @endforeach
                            </div> -->
                            <!-- end dropdown list -->
                        </div>

                        <!-- share glist form -->
                        <!-- <div class="hidden share-list mb-1" id="share-list-{{ $glist->id }}">

                            <form action="/glists/{{ $glist->id }}/share" method="POST" onsubmit="handleShareList()">
                                        
                                @csrf

                                <input autocomplete="off" name="email" placeholder="email" type="email"  required>

                                <input name="id" type="hidden" value="{{$glist->id}}">

                                <button class="btn-check" type="submit"><i class="fas fa-check"></i></button>

                                <button class="btn-cancel" id="close-share-list-{{ $glist->id }}" onclick="toggle('#share-list-{{ $glist->id }}')"><i class="fas fa-times"></i></button>
                            
                            </form>

                        </div> -->
                         <!-- end share list -->

                        <!-- edit glist name -->
                        <!-- <div class="edit-glist mb-2 mt-2 hidden" id="edit-glist-{{ $glist->id }}">

                            <form class="edit-glist-form font-small" method="POST" action="/glists/{{ $glist->id }}">
                            
                                @csrf
                                @method('PATCH')

                                <input name="name" type="text" value="{{ $glist->name }}">

                                <button class="btn-check" type="submit"><i class="fas fa-check"></i></button>

                                <button class="btn-cancel" id="close-edit-{{ $glist->id }}"><i class="fas fa-times"></i></button>
                                
                            </form>

                        </div> -->
                        
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
