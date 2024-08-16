@php
$name = 'attendance';
$pause_time_massage = [];
if(isset($attendance->pause_time_massage))
{
    foreach(json_decode($attendance->pause_time_massage, true) as $message)
    {    
        $pause_time_massage[] = $message; 
    }
}
@endphp



@extends('layouts.app')
@section('content')



<h2 class="intro-y text-lg font-medium mt-10">
    Time Management
</h2>

<div class="grid grid-cols-12 gap-6 mt-5 ">
    @if($currentdate->format('d-m-Y') == $attendance->date)

    <div class="intro-y lg:col-span-6 col-span-12  flex flex-wrap sm:flex-nowrap mt-2 mb-3  " style="align-items: end">
    @if($attendance->clock_out == null)
        @if($resume_count > $pause_count)
                <a class="btn btn-primary shadow-md mr-2" style="height: 2.5rem;" href="javascript:;" data-toggle="modal" data-target="#pause-massage-modal"> Pause Time </a>
        @endif
        @if($resume_count == $pause_count)
            <form action="{{ url('attendance/clock-resume') }}" method="post">
                @csrf
                <button id="clock-in-input" type="submit" name="clock_resume" class="btn btn-primary shadow-md mr-2" style="height: 2.5rem;">Resume Time</button>
            </form>
        @endif()
    @endif
    </div>
    @endif
</div>
    <div class="intro-y col-span-12 overflow-auto overflow-visible">
<table class="table table-report -mt-2">
    <thead>
        <tr>
            <th class="whitespace-nowrap text-center">Start Time</th>
            <th class="whitespace-nowrap text-center">Stop Time</th>
            <th class="whitespace-nowrap text-center">Stop Time Message</th>
        </tr>
    </thead>
    <tbody>
        @for($i = 0; $i < $resume_count; $i++ )
            <tr>
                <td class="text-center"> 
                    @if($attendance->resume_time && $attendance->resume_time[$i])
                            <li>{{ $attendance->resume_time[$i] }}</li>
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($attendance->pause_time) && isset($attendance->pause_time[$i]))
                        <li>{{ $attendance->pause_time[$i] }}</li>
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($pause_time_massage[$i]))
                        <li>{{ $pause_time_massage[$i] }}</li>
                    @endif
                </td>
            </tr>
        @endfor
    </tbody>
</table>

</div>

<!-- BEGIN: Delete Confirmation Modal -->
<div id="pause-massage-modal" class="modal" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <form action="{{ url('attendance/clock-pause') }}" method="POST" onsubmit="return disableButton()">
                    @csrf

                     
 <!-- BEGIN: Basic Select -->
                
                    <div class="p-5 text-center">
                        <div class="text-3xl mt-5">Pause Message</div>
                        <div>
                            <div class="mt-2"> 
                                <select  name="pause_massage" id="pauseMassageSelect" class="form-control w-full" required onchange="handleSelectChange()">
                                    <option value="">Select Message</option>
                                    <option value="BREAK TIME">BREAK TIME</option>
                                    <option value="SMALL BREAK">SMALL BREAK</option>
                                    <option value="LEAVING FOR HOME">LEAVING FOR HOME</option>
                                    <option value="other">Other</option>
                                </select> 
                            </div>
                        </div>
                        <div id="otherMassageTextArea" class="text-gray-600 mt-4" style="display: none;">
                            <textarea name="pause_massage_other"  rows="4" class="form-control" placeholder="Write a Pause Message" ></textarea>
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        {{-- @foreach ($employees as $employee) --}}
                        <button type="button" data-dismiss="modal"
                            class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                        <button type="submit" name="clock_pause" class="btn btn-primary w-24" id="submitBtn">Pause</button>

                        {{-- @endforeach --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END: Delete Confirmation Modal -->

@endsection
@section('js')
<script>
    @if (session('success'))
        swal({
            title: "{{ session('success') }}",
            icon: "success",
            button: "OK",
        })
    @endif
    @if (session('error'))
        swal({
            title: "{{ session('error') }}",
            icon: "error",
            button: "OK",
        })
    @endif
</script>

<script>
    function disableButton() {
        // Disable the button to prevent multiple submissions
        document.getElementById('submitBtn').disabled = true;
        return true; // Allow the form to be submitted
    }
</script>
<script>
    function handleSelectChange() {
        var selectElement = document.getElementById('pauseMassageSelect');
        // alert(selectElement.value);

        var otherMassageTextArea = document.getElementById('otherMassageTextArea');

        if (selectElement.value == 'other') {
            otherMassageTextArea.style.display = 'block';
        } else {
            otherMassageTextArea.style.display = 'none';
        }
    }
</script>
@endsection
