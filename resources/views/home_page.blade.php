@extends('layouts.home_page_base')
@section('function_page')
    <div class="card mx-2 mt-3" style="background-color: #A9DFBF;">
        <div class="card-body">
            <h3 class="card-title text-primary">Hi, <span style="font-family: 'Times New Roman';font-weight: bold;font-style: italic; color:darkblue !important">{{Auth::user()->f_name}}&nbsp;{{Auth::user()->l_name}}</span>, welcome to Sound Drywall's Home!</h4>
            <!--
            <p class="card-text">The functions in this group are good for H/L control options</p>
            -->
        </div>
    </div>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="w-25">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mx-2 mb-4 card-title text-center text-info">Common Controls</h4>
                                <div class="vstack">
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;"><a href="{{route('project_main')}}">All Projects</a></button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">All Jobs</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Chat</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">View Histories</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">View Logs</button></div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="w-25">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mx-2 mb-4 card-title text-center text-info">Common DB Access</h4>
                                <div class="vstack">
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Drywall Boards</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Drywall Joint Compound</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Drywall Joint Tapes</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Drywall Joint Screws</button></div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
