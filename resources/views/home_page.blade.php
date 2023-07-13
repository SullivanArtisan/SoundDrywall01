@extends('layouts.home_page_base')
@section('function_page')

    @if (Auth::user()->roll == 'ASSISTANT')
        <script type="text/javascript">
            window.location = './assistant_home_page';//here double curly bracket
        </script>
    @endif

    <style>
        .btn-grad {
            background-image: linear-gradient(to right, #603813 0%, #b29f94  51%, #603813  100%);
            margin: 5px;
            padding: 15px 25px;
            text-align: center;
            text-transform: uppercase;
            transition: 0.3s;
            background-size: 200% auto;
            color: white;            
            box-shadow: 0 0 20px #eee;
            border-radius: 6px;
            display: block;
            border-color: transparent;
        }

        .btn-grad:hover {
            background-position: right center; /* change the direction of the change here */
            color: orange;
            text-decoration: none;
        }

         
        .btn-grad-2 {
            background-image: linear-gradient(to right, #EC6F66 0%, #F3A183  51%, #EC6F66  100%);
            margin: 5px;
            padding: 15px 25px;
            text-align: center;
            text-transform: uppercase;
            transition: 0.3s;
            background-size: 200% auto;
            color: white;            
            box-shadow: 0 0 20px #eee;
            border-radius: 6px;
            display: block;
            border-color: transparent;
        }

        .btn-grad-2:hover {
            background-position: right center; /* change the direction of the change here */
            color: brown;
            text-decoration: none;
        }
    </style>

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
                    <button class="btn-grad" type="button" style="margin: 6px;"><a href="{{route('project_main')}}">All Projects</a></button>
                </div>
            </div>
            <div class="card ml-1">
                <div class="card-body">
                    <button class="btn-grad" type="button" style="margin: 6px;"><a href="{{route('under_construction')}}">All Jobs</a></button>
                </div>
            </div>
            <div class="card ml-1">
                <div class="card-body">
                    <button class="btn-grad-2" type="button" style="margin: 6px;"><a href="{{route('material_associate')}}">Associate Material with a Job</a></button>
                </div>
            </div>
            <div class="card ml-1">
                <div class="card-body">
                    <button class="btn-grad-2" type="button" style="margin: 6px;"><a href="{{route('job_dispatch')}}">Dispatch a Staff To a Job</a></button>
                </div>
            </div>
        </div>
    </div>
@endsection
         
         