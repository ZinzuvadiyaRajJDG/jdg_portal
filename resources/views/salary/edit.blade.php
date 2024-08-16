@php
$name = 'salary';
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
                        Update Salary
                    </h2>
                </div>
                <form action="{{ route('salary.update', ['salary' => $salary->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 lg:col-span-6">
                        <!-- BEGIN: Form Layout -->
                        <div class="intro-y box p-5">
                            <label for="crud-form-1" class="form-label">Employee Name</label>
                            <input type="text" class="form-control" value="{{ $salary->user->name }}" disabled>

                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">Salary</label>
                                <input id="crud-form-1" type="text" name="salary" class="form-control w-full" placeholder="Enter Salary" value="{{ old('salary',$salary->salary) }}">
                                @error('salary')
                                    <span class="error_msg">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label>Status</label>
                                <div class="mt-2" class="form-control w-full border">
                                    <select name="status" class="form-control">
                                        <option value="" >Select Status</option>
                                        <option value="paid" {{ (old('status',$salary->status) == 'paid')? "selected" : "" }}>Paid</option>
                                        <option value="unpaid" {{ (old('status',$salary->status) == 'unpaid')? "selected" : "" }}>Unpaid</option>
                                    </select>
                                    @error('status')
                                        <span class="error_msg">{{ $message }}</span>
                                    @enderror
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
      window.location.href = '{{ url('salary') }}';
    });
  });
</script>
@endsection