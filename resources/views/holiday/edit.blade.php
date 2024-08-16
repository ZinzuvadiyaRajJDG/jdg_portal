@php
$name = 'holiday';
@endphp
@extends('layouts.app')
@section('content')

<style>
    .error_msg {
    color: #dc3645;
    font-weight: 300;
}
</style>
<div class="intro-y flex items-center mt-8">
                    <h2 class="text-lg font-medium mr-auto">
                        Update Holiday
                    </h2>
                </div>
                <form action="{{ route('holiday.update', ['holiday' => $holiday->id]) }}" method="POST">
                    @csrf
                    @method('PUT')


                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 lg:col-span-6">
                            <!-- BEGIN: Form Layout -->
                            <div class="intro-y box p-5">
                                <div>
                                    <label for="crud-form-1" class="form-label">Holiday Name</label>
                                    <input id="crud-form-1" type="text" name="name" class="form-control w-full" placeholder="Enter Holiday Name" value="{{ old('name',$holiday->name) }}">
                                    @error('name')
                                        <span class="error_msg">{{ $message }}</span>
                                    @enderror
                                </div> 
                                <div class="mt-3">
                                    <label for="day" class="form-label">Number of Days</label>
                                    <input id="day" type="number" name="day" class="form-control w-full block" min="1" step="1" value="{{ old('day',$holiday->day) }}" placeholder="Enter Number of Day">
                                    @error('day')
                                        <span class="error_msg">{{ $message }}</span>
                                    @enderror
                                </div>      
                                <div class="mt-3">
                                    <label for="crud-form-2" class="form-label">Holiday Date</label>
                                    <input id="crud-form-2" type="date" name="date" class="form-control w-full" placeholder="Enter Holiday Date" value="{{ old('date', \Carbon\Carbon::parse($holiday->date)->format('Y-m-d')) }}">
                                    @error('date')
                                        <span class="error_msg">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="end_date" class="form-label">End Holiday Date</label>
                                    <input id="end_date" type="date" name="end_date" class="form-control w-full" placeholder="Enter End Date" value="{{ old('end_date', \Carbon\Carbon::parse($holiday->end_date)->format('Y-m-d')) }}">
                                    @error('end_date')
                                        <span class="error_msg">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="text-right mt-5">
                                    <button type="button" id="cancelButton" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                    <button type="submit" class="btn btn-primary w-24">Save</button>
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
      window.location.href = '{{ url("holiday") }}';
    });
  });
</script>


<script>
    $(document).ready(function () {
        function updateEndDate() {
            const numOfDays = parseInt($('#day').val());

            if (numOfDays > 1) {
                $('#end_date').prop('disabled', false);
            } else {
                $('#end_date').prop('disabled', true);
            }
            
        }

        // Initial state
        updateEndDate();

        $('#day').change(updateEndDateDisabledState);
    });
</script>

<script>
    $(document).ready(function () {
        $('#day').change(function () {
            const numOfDays = parseInt($(this).val());

            if (numOfDays > 1) {
                $('#end_date').prop('disabled', false);
            } else {
                $('#end_date').prop('disabled', true);
            }
        });
    });

</script>

@endsection