@php
$name = 'attendance';
$user = Auth::user();
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
</style>
<div class="intro-y flex items-center mt-8">
                    <h2 class="text-lg font-medium mr-auto">
                        Clock Out
                    </h2>
                </div>
            
                <form method="POST" action="{{ url('attendance/clockout') }}">
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

                                <input id="crud-form-1" type="text" name="user_id" class="form-control w-full" placeholder="" value="{{ $user->id }}" hidden>

                            <div id="basic-datepicker" class="pb-5">
                                <div class="preview">
                                    <input class="datepicker form-control w-full block " name="date" data-single-mode="true" disabled>
                                </div>
                                <div class="source-code hidden">
                                    <button data-target="#copy-basic-datepicker" class="copy-code btn py-1 px-2 btn-outline-secondary"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code </button>
                                    <div class="overflow-y-auto mt-3 rounded-md">
                                        <pre id="copy-basic-datepicker" class="source-preview"> <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10"> HTMLOpenTaginput class=&quot;datepicker form-control w-56 block mx-auto&quot; data-single-mode=&quot;true&quot;HTMLCloseTag </code> </pre>
                                    </div>
                                </div>
                            </div>
                            <div id="basic-datepicker" class="">
                                <div class="preview">
                                    <input id="clock-out-input" class=" form-control w-full block " name="clock_out" data-single-mode="true" disabled>
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
                        <button type="submit" class="btn btn-primary w-24">Clock Out</button>
                </div>
                        </div>
                        <!-- END: Form Layout -->
                    </div>
                </div>
                </form>
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
      window.location.href = '{{ url("attendance") }}';
    });
  });
</script>
<script>
  // JavaScript code
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

    // Set the value of the clock-in and clock-out input fields with the current time
    // document.getElementById('clock-in-input').value = getCurrentTime();
    document.getElementById('clock-out-input').value = getCurrentTime();
});

</script>
@endsection
