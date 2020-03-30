@extends('layouts.app')

@section('content')

        <div class="true-center">

            <div class="title m-b-md">

                GemmaList

                <h3 class="sub-title text-center">Get things done</h3>

                <div class="chevron-down text-center">
            
                    <i class="fas fa-chevron-down pointer" onclick="scrollToMore()"></i>

                </div>

            </div>

        </div>

        <div id="more" class="true-center">

            <div class="d-flex flex-column justify-content-center">

                <div>

                    <h2 class="text-center text-white">Get More Done with GemmaList</h2>

                </div>

                <div class="mb-5 mt-4">

                    <img class="d-block m-auto rounded-lg" src="{{ asset('images/benefits.png') }}">

                </div>

                <div class="text-center">

                    <a href="/register"><button class="btn btn-primary">Get Started</button>

                </div>

            <div>

        </div>

@endsection
