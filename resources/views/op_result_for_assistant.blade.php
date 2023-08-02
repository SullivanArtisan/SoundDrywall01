<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>2020_Assistant_Main_01</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container py-5 text-dark" style="background: var(--bs-btn-bg); background-color:beige;">
        <!-- Header Section -->
        <div class="row">
            <div class="col-md-9 my-2" style="">
                <h1>Hi, <span style="font-family: 'Times New Roman';font-weight: bold;font-style: italic; color:brown !important">{{Auth::user()->f_name}} {{Auth::user()->l_name}}</span>!    Material's update result:</h1>
            </div>
            <div class="col-md-1 my-4">
                        <button class="btn btn-secondary text-center" type="button">
                            <a style="text-decoration:none;"  class="text-white" 
                                href="{{url()->previous()}}">
                                <span style="font-weight:bold !important;">{{ __('Back') }}</span>
                            </a>
                        </button>
            </div>
            <div class="col-md-2 my-4" style="">
                <form method="POST" action="{{ route('logout') }}" style="cursor: pointer">
                    @csrf
                    <a style="text-decoration:none;"  class="text-dark border rounded btn btn-dark" 
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <span style="font-weight:bold !important; color:white">{{ __('Log Out') }}</span>
                    </a>
                </form>
            </div>
        </div>

        <!-- Operation Result Section -->
        <div class="row my-2">
            <div class="col">
                @if(session('status'))
                <div class="alert alert-success">
                    <?php
                        $text = session('status');
                        echo $text;
                    ?>
                </div>
                @endif
            </div>
        </div>
    </div>

</body>

</html>