@extends('layouts.app')

@section('content')

<div class="row pt-4">

    <aside class="col-md-3 side-bar">

        <form method="POST" action="/glists">

            @csrf
            
            <input name="name" type="text" value="{{ old('name') }}" placeholder="add new list" required>
            
            <button class="button" type="submit">+</button>

        </form>

        <form method="POST" action="/tasks">

            @method('DELETE')
    
            @csrf
            
            <button class="button mt-3" type="submit">Delete Completed</button>

        </form>

    </aside>

    <div class="col-md-9 lists-container">
    
        @foreach ($glists as $glist)

        <div class="list-container">
        
            <h2 class="list-name mb-1">{{ $glist->name }}</h2>

            <div class="add-task-container mb-2">

                <form class="add-task-form" method="POST" action="/glists/{{ $glist->id }}/task">

                    @csrf

                    <input class="add-task-input" type="text" name="title" placeholder="Add Task" required>
                        
                    <button class="button" type="submit">+</button>

                </form>

            </div>

            <div class="task-container">
                
                @foreach ($glist->tasks as $task)

                <form action="/tasks/{{ $task->id }}" method="POST">

                    @method('PATCH')
                    @csrf

                    <label for="completed" class="checkbox {{ $task->completed ? 'is-completed' : '' }}">

                    <input type="checkbox" name="completed" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>

                    {{ $task->title }}

                    </label>

                </form>
                
                <!-- <h4 class="task">{{$task->title}}</h4> -->

                @endforeach
            
            </div>
        
        </div>

        @endforeach

    </div>

</div>

@endsection