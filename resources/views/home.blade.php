@extends('layouts.app')

@section('content')
<div class="main-container" id="main-container">

    <form method="POST" action="/glists">

        @csrf
        
        <input name="name" type="text" value="{{ old('name') }}" placeholder="add new list" required>
        
        <button class="button" type="submit">+</button>

    </form>
    
    @foreach ($glists as $glist)

    <div class="list-container">
    
        <h1 class="list-name">{{ $glist->name }}</h1>

        <div class="task-container">

            <form method="POST" action="/glists/{{ $glist->id }}/task">

                @csrf

                <input type="text" name="title" placeholder="Add Task" required>
                    
                <button class="button" type="submit">+</button>

            </form>
            
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
@endsection
