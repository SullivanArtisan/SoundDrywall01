<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>2020_Assistant_Main_01</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <?php
        use App\Models\Job;
        use App\Models\Staff;
        use App\Models\JobDispatch;
        use Illuminate\Support\Facades\Log;

        $staff = Staff::where('id', Auth::user()->id)->first();
        $jobs_total = 0;
        if ($staff) {
            $jobs = JobDispatch::all()->where('jobdsp_staff_id', $staff->id)->where('jobdsp_status', '<>', 'DELETED')->where('jobdsp_status', '<>', 'COMPLETED')->where('jobdsp_status', '<>', 'CANCELED');
            // Log::Info("COUNT = ".count($jobs));
        } else {
            $err_msg = "Staff ".Auth::user()->f_name." ".Auth::user()->l_name."'s object cannot be accessed while just entering his/her main page.";
            Log::Info($err_msg);
        }
    ?>

    <div class="container pt-5" style="background: var(--bs-btn-bg); background-color:beige;">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-md-9" style="background: var(--bs-success-bg-subtle);">
                @if (Auth::user()->roll == 'ASSISTANT')
                    <h1>Assistant <span style="color:maroon; font-family: Georgia;">{{Auth::user()->f_name}}&nbsp;{{Auth::user()->l_name}}</span>'s Jobs List</h1>
                @else
                    <h1>Superintendent <span style="color:maroon; font-family: Georgia;">{{Auth::user()->f_name}}&nbsp;{{Auth::user()->l_name}}</span>'s Jobs List</h1>
                @endif
            </div>
            <div class="col-md-1">
                <div style="display: flex; justify-content: right;"><img class="rounded" style="max-width:100%; height:auto" src="assets/img/2020_assistant.jpg"></div>
            </div>
            <div class="col-2" style="display: flex; justify-content: center; align-items: flex-end;">
                <div style="font-family: Georgia; ">TwentyTwenty Contracting Ltd.</div>
            </div>
        </div>

        <!-- Jobs Section -->
        <div class="row text-white" style="max-height: 400px; background-color:grey; font-weight:bold !important;">
            <div class="col-2">Job Type</div>
            <div class="col-1">Job Name</div>
            <div class="col-2">Status</div>
            <div class="col-3">Job Address</div>
            <div class="col-2">Job City</div>
            <div class="col-2">Job Deadline</div>
        </div>
        <?php
            $listed_jobs = 0;
            foreach($jobs as $job) {
                $job_origin = Job::where('id', $job->jobdsp_job_id)->where('job_status', '<>', 'DELETED')->where('job_status', '<>', 'CANCELED')->where('job_status', '<>', 'COMPLETED')->first();
                
                if ($job_origin) {
                    $listed_jobs++;
                    if ($listed_jobs % 2) {
                        $outContents = "<div class=\"row\" style=\"background-color:gainsboro\">";
                    } else {
                        $outContents = "<div class=\"row\" style=\"background-color:PaleGreen\">";
                    }
                        $outContents .= "<div class=\"col-2\">";
                            $outContents .= "<a href=\"".route('assistant_job_selected', ['id='.$job_origin->id])."\">";
                            $outContents .= $job_origin->job_type;
                            $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-1\">";
                            $outContents .= "<a href=\"".route('assistant_job_selected', ['id='.$job_origin->id])."\">";
                            $outContents .= $job_origin->job_name;
                            $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            $outContents .= "<a href=\"".route('assistant_job_selected', ['id='.$job_origin->id])."\">";
                            $outContents .= $job_origin->job_status;
                            $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-3\">";
                            $outContents .= "<a href=\"".route('assistant_job_selected', ['id='.$job_origin->id])."\">";
                            $outContents .= $job_origin->job_address;
                            $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            $outContents .= "<a href=\"".route('assistant_job_selected', ['id='.$job_origin->id])."\">";
                            $outContents .= $job_origin->job_city;
                            $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            $outContents .= "<a href=\"".route('assistant_job_selected', ['id='.$job_origin->id])."\">";
                            $outContents .= $job_origin->job_till_time;
                            $outContents .= "</a>";
                        $outContents .= "</div>";
                    $outContents .= "</div>";
                    echo $outContents;
                } else {
                    $err_msg = "Job ID ".$job->jobdsp_job_id."'s object cannot be found from JobDispatch.";
                    Log::Info($err_msg);
                }
            }
        ?>

        <!-- Footage Section -->
        <div class="row">
            <div class="col-md-12" style="background-color:beige;">
                <div class="row my-4">
                    <div class="col"></div>
                    <div class="col">
                        <div class="row mt-2">
                            <div class="col">
                            </div>
                            <div class="col">
                                <form method="POST" action="{{ route('logout') }}" style="cursor: pointer">
                                    @csrf

                                    <a style="text-decoration:none;"  class="text-dark border rounded btn btn-secondary" 
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        <span style="font-weight:bold !important; color:white">{{ __('Log Out') }}</span>
                                    </a>
                                </form>
                            </div>
                            <div class="col">
                            </div>
                        </div>
                        <!--
                        <button class="btn btn-primary" type="button">
                            <a class="text-white" style="text-decoration: none !important;" href="{{ route('logout') }}">Log Out</a>
                        </button>
                        -->
                    </div>
                    <div class="col"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>