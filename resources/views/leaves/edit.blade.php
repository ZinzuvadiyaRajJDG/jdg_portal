@php
$name = 'leave';
@endphp
@extends('layouts.app')
@section('content')
<style>
    .custom-success-message {
    background-color: #dff0d8;
    color: #3c763d;
    border: 1px solid #d6e9c6;
    padding: 10px;
    margin-bottom: 20px;
}
.info-msg,
.success-msg,
.warning-msg,
.error-msg {
  margin: 10px 0;
  padding: 10px;
  border-radius: 3px 3px 3px 3px;
}
.error-msg {
  color: #D8000C;
  background-color: #FFBABA;
}
.success-msg {
  color: #270;
  background-color: #DFF2BF;
}
.error_msg {
    color: #dc3645;
    font-weight: 300;
}
</style>
<div class="intro-y flex items-center mt-8">
                    <h2 class="text-lg font-medium mr-auto">
                        Edit Leave
                    </h2>
                </div>
                <form method="POST" action="{{ url('leave/'.$leave->id) }}">
                    @csrf
                    @method('PUT')

                    @if (session('error'))
                        <div class="error-msg">
                            {{ session('error') }}
                        </div>
                    @endif
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 lg:col-span-6">
                        <!-- BEGIN: Form Layout -->
                        <div class="intro-y box p-5">
                            <div>
                                <!--<label for="crud-form-1" class="form-label">User ID</label>-->
                                {{-- <input id="crud-form-1" type="text" name="user_id" class="form-control w-full" value="{{ $user->id }}" hidden> --}}
                            </div>
                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">Leave Heading</label>
                                <input id="crud-form-1" type="text" name="leave_heading" class="form-control w-full" placeholder="Leave Heading" value="{{ old('leave_heading',$leave->leave_heading) }}">
                                @error('leave_heading')
                                    <span class="error_msg">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div class="mt-3">
                                <label for="crud-form-1" class="form-label">Leave Reason</label>
                                <input id="crud-form-1" type="text" name="leave_reason" class="form-control w-full" placeholder="Leave Reason" value="{{ old('leave_heading') }}">
                                @error('leave_reason')
                                    <span class="error_msg">{{ $message }}</span>
                                @enderror
                            </div> --}}
                            
                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">Leave Reason</label>
                                <textarea class="ckeditor form-control" name="leave_reason">{{ old('leave_reason',$leave->leave_reason) }}</textarea>
                                @error('leave_reason')
                                    <span class="error_msg">{{ $message }}</span>
                                @enderror
                            </div>
                            

                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">Day</label><br>
                                    <input type="radio" id="half day" name="day" value="half day" {{ old('day',$leave->day) === 'half day' ? 'checked' : '' }}>
                                    <label for="html">Half Day</label><br>
                                    <input type="radio" id="full day" name="day" value="full day" {{ old('day',$leave->day) === 'full day' ? 'checked' : '' }}>
                                    <label for="css">Full Day</label><br>

                                    <input type="radio" id="medical leave" name="day" value="medical leave" {{ old('day',$leave->day) === 'medical leave' ? 'checked' : '' }}>
                                    <label for="css">Medical Leave</label><br>

                                    <input type="radio" id="emergency leave" name="day" value="emergency leave" {{ old('day',$leave->day) === 'emergency leave' ? 'checked' : '' }}>
                                    <label for="css">Emergency Leave</label><br>
                                    
                                    <input type="radio" id="paid holiday" name="day" value="paid holiday" {{ old('day',$leave->day) === 'paid holiday' ? 'checked' : '' }}>
                                    <label for="css">Paid Leave</label><br>
                                    <input type="radio" id="casual leave" name="day" value="casual leave" {{ old('day',$leave->day) === 'casual leave' ? 'checked' : '' }}>
                                    <label for="css">Casual Leave</label><br>
                                    @error('day')
                                        <span class="error_msg">{{ $message }}</span>
                                    @enderror
                            </div>

                            <div class="mt-3">
                                <label for="num-of-days" class="form-label">Number of Days</label>
                                <input id="num-of-days" type="number" name="total_day" class="form-control w-56 block" min="1" step="1" value="{{ old('total_day',$leave->total_day) }}">
                                @error('total_day')
                                    <span class="error_msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">Start Leave Date</label>

                                <div id="basic-datepicker" class="">
                                <div class="preview">
                                    <input class="datepicker form-control w-56 block" name="start_leave_date" data-single-mode="true" value="{{ old('start_leave_date',$startDate) }}">
                                    @error('start_leave_date')
                                        <span class="error_msg">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- @if ($errors->has('start_leave_date'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('start_leave_date') }}
                                    </div>
                                @endif --}}
                            </div>
                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">End Leave Date</label>
                                <div id="basic-datepicker" class="">
                                    <div class="preview">
                                        <input id="end-leave-date" class="datepicker form-control w-56 block" name="end_leave_date" data-single-mode="true" value="{{ old('end_leave_date',$endDate) }}" >
                                    </div>
                                    @error('end_leave_date')
                                        <span class="error_msg">{{ $message }}</span>
                                    @enderror
                                    {{-- @if ($errors->has('end_leave_date'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('end_leave_date') }}
                                        </div>
                                    @endif --}}
                                </div>
                            </div>
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
                @if ($errors->any())
                                <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
@endsection
@section('js')
<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get a reference to the cancel button
            const cancelButton = document.getElementById('cancelButton');

            // Add a click event listener to the cancel button
            cancelButton.addEventListener('click', function() {
                // Implement your desired cancel logic here.
                // For example, you can redirect to another page or close a modal.

                // Example: Redirect to the homepage
                window.location.href = '{{ url("leave") }}';
            });
        });
    </script>

<script>
    $(document).ready(function () {
        function updateEndDateDisabledState() {
            const selectedValue = $('input[name="day"]:checked').val();
            const numOfDays = parseInt($('#num-of-days').val());
            const endLeaveDateInput = $('#end-leave-date');

            if (selectedValue === 'half day' || selectedValue === 'full day') {
                endLeaveDateInput.prop('disabled', true);
                $('#num-of-days').prop('disabled', true);
                $('#num-of-days').val(1);
                
            } else {
                if(numOfDays <= 1)
                {
                    endLeaveDateInput.prop('disabled', true);
                }
                else
                {
                    endLeaveDateInput.prop('disabled', false);
                }
                // endLeaveDateInput.prop('disabled', false);
                $('#num-of-days').prop('disabled', false);
                // $('#num-of-days').val('');
            }
            
        }

        // Initial state
        updateEndDateDisabledState();

        $('input[name="day"]').change(updateEndDateDisabledState);

        $('#num-of-days').change(updateEndDateDisabledState);
    });
</script>


<script>
    $(document).ready(function () {
        $('#num-of-days').change(function () {
            const numOfDays = parseInt($(this).val());

            if (numOfDays > 1) {
                $('#end-leave-date').prop('disabled', false);
            } else {
                $('#end-leave-date').prop('disabled', true);
            }
        });
    });

</script>


<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
       $('.ckeditor').ckeditor();
    });
</script>
@endsection
