@php
$name = 'overtime';
$clockInButton = !$existingAttendance;

@endphp
@extends('layouts.app')
@section('content')
<style>
    .custom-error-message {
    background-color: #dff0d8;
    color: red;
    border: 1px solid #d6e9c6;
    padding: 10px;
    margin-bottom: 20px;
}
.error_msg {
  color: #D8000C;

}
</style>
<div class="intro-y flex items-center mt-8">
                    <h2 class="text-lg font-medium mr-auto">
                        Add overtime
                    </h2>
                </div>
                <form method="POST" action="{{ route('overtime.store') }}">
                    @csrf
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 md:col-span-6">
                        <!-- BEGIN: Form Layout -->
                        <div class="intro-y box p-5">
                        @if(session('error'))
                            <div class="custom-error-message">
                                <strong>Error:</strong> {{ session('error') }}
                            </div>
                        @endif
                                <input id="crud-form-1" type="hidden" name="user_id" class="form-control w-full" placeholder="" value="{{ $user->id }}" >

                            <div>
                                <input id="crud-form-1" type="text" name="task_name" class="form-control w-full mx-auto"  placeholder="task name" value="" >
                            </div>
                            @error('task_name')
                                <span class="error_msg">{{ $message }}</span>
                            @enderror
                            
                            <div class="mt-5 mb-5">
                                <input class="datepicker form-control w-full mx-auto" id="date-input"  data-single-mode="true" disabled>
                            </div>

                            <div id="basic-datepicker" class="">
                                <div class="preview">
                                    <input id="clock-in-input" class="form-control w-full mx-auto"  data-single-mode="true" readonly>
                                </div>
                                <div id="message text-success text-center" style="text-align:center; color:green;" class="mt-2">
                                </div>
                                <div class="source-code hidden">
                                    <div class="overflow-y-auto mt-3 rounded-md">
                                        <pre id="copy-basic-datepicker" class="source-preview"> <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10"> HTMLOpenTaginput class=&quot;datepicker form-control w-56 block mx-auto&quot; data-single-mode=&quot;true&quot;HTMLCloseTag </code> </pre>
                                    </div>
                                </div>
                            </div>
                            <div class="text-left mt-5">
                    <button id="cancelButton" type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                        <button type="submit" class="btn btn-primary w-24">Clock In</button>
                </div>
                        </div>
                        <!-- END: Form Layout -->
                    </div>
                </div>
                </form>
                {{-- @endif --}}
@endsection
@section('js')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Get a reference to the cancel button
    const cancelButton = document.getElementById('cancelButton');

    // Add a click event listener to the cancel button
    cancelButton.addEventListener('click', function () {
      // Implement your desired cancel logic here.
      // For example, you can redirect to another page or close a modal.

      // Example: Redirect to the homepage
      window.location.href = 'ot';
    });
  });
</script>
<script>
   // JavaScript code
// document.addEventListener('DOMContentLoaded', function () {
//     // Function to get the current time in 12-hour format with AM/PM
//     function getCurrentTime() {
//         const now = new Date();
//         const hours = now.getHours();
//         const minutes = now.getMinutes();
//         const ampm = hours >= 12 ? 'PM' : 'AM';

//         // Convert hours to 12-hour format
//         const twelveHourFormat = (hours % 12) || 12;
//         const formattedHours = String(twelveHourFormat).padStart(2, '0');
//         const formattedMinutes = String(minutes).padStart(2, '0');

//         const time = formattedHours + ':' + formattedMinutes + ' ' + ampm;
//         return time;
//     }

//      // Function to get the current date in "d-m-y" format
//     //  function getCurrentDate() {
//     //     const now = new Date();
//     //     const day = String(now.getDate()).padStart(2, '0');
//     //     const month = String(now.getMonth() + 1).padStart(2, '0'); // January is 0, so we add 1
//     //     const year = String(now.getFullYear()).slice(-2); // Get last 2 digits of the year

//     //     const date = day + '-' + month + '-' + year;
//     //     return date;
//     // }

//     // Set the value of the clock-in and clock-out input fields with the current time
//     document.getElementById('clock-in-input').value = getCurrentTime();
//     document.getElementById('clock-out-input').value = getCurrentTime();

//     document.getElementById('date-input').value = getCurrentDate();

// });

document.addEventListener('DOMContentLoaded', function () {
    // Function to get the current time in 12-hour format with AM/PM
    function getCurrentTime() {
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const ampm = hours >= 12 ? 'PM' : 'AM';

        // Convert hours to 12-hour format
        const twelveHourFormat = (hours % 12) || 12;
        const formattedHours = String(twelveHourFormat).padStart(2, '0');
        const formattedMinutes = String(minutes).padStart(2, '0');

        const time = formattedHours + ':' + formattedMinutes + ' ' + ampm;
        return time;
    }

     // Function to get the current date in "d-m-y" format
     
    // Set the value of the clock-in and clock-out input fields with the current time
    document.getElementById('clock-in-input').value = getCurrentTime();
    document.getElementById('clock-out-input').value = getCurrentTime();

    document.getElementById('date-input').value = getCurrentDate();

});

</script>
@endsection
