@extends('layouts.home_page_base')
@section('function_page')

    @if (Auth::user()->roll == 'ASSISTANT')
        <script type="text/javascript">
            window.location = './assistant_home_page';//here double curly bracket
        </script>
    @endif

    <div class="card mx-2 mt-3" style="background-color: #A9DFBF;">
        <div class="card-body">
            <h3 class="card-title text-primary">Hi, <span style="font-family: 'Times New Roman';font-weight: bold;font-style: italic; color:darkblue !important">{{Auth::user()->f_name}}&nbsp;{{Auth::user()->l_name}}</span>, welcome to TwentyTwenty Contracting Ltd's Home!</h4>
            <!--
            <p class="card-text">The functions in this group are good for H/L control options</p>
            -->
        </div>
    </div>
    <div class="container my-4">
        <div class="row">
            <h4 class="mx-2 mb-4 card-title text-info">Frequently Used Functions: </h4>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="vstack">
                        <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;"><a href="{{route('project_main')}}">All Projects</a></button></div>
                    </div>
                </div>
            </div>
            <div class="card ml-1">
                <div class="card-body">
                    <div class="vstack">
                        <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;"><a href="{{route('under_construction')}}">All Jobs</a></button></div>
                    </div>
                </div>
            </div>
            <div class="card ml-1">
                <div class="card-body">
                    <div class="vstack">
                        <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;"><a href="{{route('under_construction')}}">Associate Material To a Job</a></button></div>
                    </div>
                </div>
            </div>
            <div class="card ml-1">
                <div class="card-body">
                    <div class="vstack">
                        <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;"><a href="{{route('under_construction')}}">Dispatch a Staff To a Job</a></button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
