@php
    $name = 'salary';
    $currentYear = date('Y');
    $monthName = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
@endphp
@extends('layouts.app')
@section('content')
<h2 class="intro-y text-lg font-medium mt-10">
                    Salary List
                </h2>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y md:col-span-6 col-span-12 flex flex-wrap sm:flex-nowrap items-end mb-3 mt-2">
                        <a class="btn btn-primary shadow-md mr-2" href="{{ url('salary/create') }}">Add Salary</a>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-9 lg:col-span-6 flex flex-wrap sm:flex-nowrap mt-2 justify-end">
                        <form method="GET" action="{{ url('salary') }}" class="w-full">
                            <label for="" class="form-label">Monthly Salary</label><br>
                            <select name="month" id="year" class="form-control" style="width:32%;" required>
                                <option value="">Select Month</option>
                                @for ($month = 0; $month <= 11; $month++)
                                    <option value="<?= $month + 1 ?>" {{ request('month') == $month + 1 ? 'selected' : '' }}>
                                        <?= $monthName[$month] ?>
                                    </option>
                                @endfor
                            </select>
                            <select name="year" id="year" class="form-control" style="width:32%;" required>
                                <option value="">Select year</option>
                                @for ($i = 2020; $i <= $currentYear; $i++)
                                    <option value="<?= $i ?>" {{ request('year') == $i ? 'selected' : '' }}><?= $i ?></option>
                                @endfor
                            </select>
                            <button type="submit" class="btn btn-primary" style="width: auto; font-size: 12px;">Apply Filter</button>
                        </form>
                        <div class="hidden md:block mx-auto text-gray-600"></div>
                    </div>

                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto">
                        <table class="table table-report -mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">Name</th>
                                    <th class="whitespace-nowrap text-center">Total Salary</th>
                                    <th class="whitespace-nowrap text-center">Payable Amount</th>
                                    <th class="whitespace-nowrap text-center">Month/Year</th>
                                    <th class="whitespace-nowrap text-center">Status</th>
                                    <th class="whitespace-nowrap text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($salaries) > 0)

                                @foreach($salaries as $salary)
                                    @if (!empty($salary->user->getRoleNames()))
                                        @foreach ($salary->user->getRoleNames() as $role)
                                            @php $role_name =  $role; @endphp
                                        @endforeach
                                    @endif
                                    @can('management-team-salary')
                                        <tr class="intro-x">
                                            <td class="whitespace-nowrap text-center">{{ $salary->user->name ?? '' }}</td>
                                            <td class="whitespace-nowrap text-center">{{ $salary->salary }}</td>
                                            <td class="whitespace-nowrap text-center">{{ ($salary->payable_amount < 0)? "0.00" : $salary->payable_amount }}</td>
                                            <td class="whitespace-nowrap text-center">{{ \Carbon\Carbon::createFromDate($salary->year, $salary->month)->format('F Y') }}</td>
                                            <td class="whitespace-nowrap text-center">
                                                @php
                                                    $statusClass = $salary->status === 'paid' ? 'btn-rounded-success' : 'btn-rounded-danger';
                                                @endphp
                                                @if($salary->status == "paid")
                                                    <button class="btn {{ $statusClass }} btn-sm capitalize">
                                                        {{ $salary->status }}
                                                    </button>
                                                @else
                                                    <a class="btn {{ $statusClass }} btn-sm capitalize" href="javascript:;"
                                                        data-toggle="modal"
                                                        data-target="#salary-massage-modaladmin{{ $salary->id }}"> {{ $salary->status }} </a>
                                                @endif
                                            </td>
                                            <td >
                                                <div class="flex justify-center items-center">        
                                                    <a class="flex items-center mr-3 justify-center" href="{{ route('salary.edit',$salary->id) }}"><i data-feather="check-square" class="w-4 h-4 mr-1"></i>Edit</a>
                                                    <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal{{ $salary->id }}"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @if ($role_name != Auth::user()->roles->first()->name || $salary    ->user_id == Auth::user()->id)
                                            <tr class="intro-x">
                                                <td class="whitespace-nowrap text-center">{{ $salary->user->name ?? '' }}</td>
                                                <td class="whitespace-nowrap text-center">{{ $salary->salary }}</td>
                                                <td class="whitespace-nowrap text-center">{{ ($salary->payable_amount < 0)? "0.00" : $salary->payable_amount }}</td>
                                                <td class="whitespace-nowrap text-center">{{ \Carbon\Carbon::createFromDate($salary->year, $salary->month)->format('F Y') }}</td>
                                                <td class="whitespace-nowrap text-center">
                                                    @php
                                                        $statusClass = $salary->status === 'paid' ? 'btn-rounded-success' : 'btn-rounded-danger';
                                                    @endphp
                                                    @if($salary->status == "paid")
                                                        <button class="btn {{ $statusClass }} btn-sm capitalize">
                                                            {{ $salary->status }}
                                                        </button>
                                                    @else
                                                        <a class="btn {{ $statusClass }} btn-sm capitalize" href="javascript:;"
                                                            data-toggle="modal"
                                                            data-target="#salary-massage-modaladmin{{ $salary->id }}"> {{ $salary->status }} </a>
                                                    @endif
                                                </td>
                                                <td >
                                                    <div class="flex justify-center items-center">        
                                                        <a class="flex items-center mr-3 justify-center" href="{{ route('salary.edit',$salary->id) }}"><i data-feather="check-square" class="w-4 h-4 mr-1"></i>Edit</a>
                                                        <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal{{ $salary->id }}"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endcan
                                    <!-- BEGIN: Delete Confirmation Modal -->
                                    <div id="delete-confirmation-modal{{ $salary->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <div class="p-5 text-center">
                                                        <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                                                        <div class="text-3xl mt-5">Are you sure?</div>
                                                        <div class="text-gray-600 mt-2">
                                                            Do you really want to delete these records?
                                                            <br>
                                                            This process cannot be undone.
                                                        </div>
                                                    </div>
                                                    <div class="px-5 pb-8 text-center">
                                                    <form action="{{ route('salary.destroy', $salary->id) }}" method="POST">
                                                            <button type="button" data-dismiss="modal"
                                                                class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END: Delete Confirmation Modal -->

                                    <!-- BEGIN: Delete Confirmation Modal -->
                                    <div id="salary-massage-modaladmin{{ $salary->id }}" class="modal" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                        <div class="p-5 text-center">
                                                            <div class="text-3xl mt-5">Salary Paid Massage</div>
                                                            <div class="text-gray-600 mt-4">
                                                                <textarea name="salary_massage" id="salary_massage{{ $salary->id }}" rows="10" class="form-control"
                                                                    placeholder="Write a Massage" required>Dear {{ $salary->user->name ?? '' }},

I hope this email finds you well.

I am writing to inform you that the finance team at Just Digital Gurus has successfully processed your monthly salary payment for the Month of {{ \Carbon\Carbon::createFromDate($salary->year, $salary->month)->format('F Y') }}. The transaction has been completed, and the funds should reflect in your designated bank account.

Here are the details of your salary payment:

Transaction Date: {{ \Carbon\Carbon::now()->format('Y-m-d') }}
Transaction Amount: {{ $salary->payable_amount }}

We appreciate your hard work and dedication to Just Digital Gurus. If you have any questions or concerns regarding your salary payment or if there are any discrepancies, please do not hesitate to reach out to our finance team at finance@justdigitalgurus.com.

Thank you for your continued commitment to our team. We look forward to another successful month working together.

Best regards,
Finance Team
Just Digital Gurus
 </textarea>
                                                            </div>
                                                        </div>
                                                        <div class="px-5 pb-8 text-center">
                                                            {{-- @foreach ($employees as $employee) --}}
                                                            <button type="button" data-dismiss="modal"
                                                                class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                            <button class="btn btn-primary w-24 salary-status-btn" data-salary-id="{{ $salary->id }}" data-user-email="{{ $salary->user->email }}" data-salary-status="{{ $salary->status }}">
                                                                Send Mail
                                                            </button>
                                                            <!-- <button type="submit" name="status" value="rejected"
                                                                class="btn btn-primary w-24">Sand Mail</button> -->
                                                            {{-- @endforeach --}}
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END: Delete Confirmation Modal -->

                                @endforeach
                                @else
                                    <tr>    
                                        <td class="text-center mt-5" colspan="8" style="background-color: transparent;box-shadow: none;font-weight: 700;font-size: 28px;">Data Not Found..!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                </div>
             
@endsection
@section('js')
<script>
    // Wait for the DOM to be ready
    $(document).ready(function () {
        // Handle button click event
        $(".salary-status-btn").on("click", function () {
            // Get the salary ID and current status from the data attributes
            const salaryId = $(this).data("salary-id");
            const currentStatus = $(this).data("salary-status");
            const userEmail = $(this).data("user-email");
            const message = $('#salary_massage'+salaryId).val( );

  
            // Determine the new status
            const newStatus = currentStatus === "paid" ? "unpaid" : "paid";
  
            // Send an AJAX request to update the salary status
            $.ajax({
                url: "update-salary-status", // Replace with the URL to your Laravel route/controller method
                method: "POST",
                data: {
                    salary_id: salaryId,
                    status: newStatus,
                    message: message,
                    userEmail: userEmail,
                },
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}", // Add CSRF token to the request
                },
                success: function (response) {
                    // On success, update the button text and class
                    location.reload();  
                },
                error: function (xhr) {
                    // Handle errors if necessary
                    console.error("Error:", xhr.responseText);
                },
            });
        });
    });
  </script>
<script>
@if(session('success'))
    swal({
        title: "{{ session('success') }}",
        icon: "success",
        button: "OK",
    })
@endif
</script>
<script>
@if(session('error'))
    swal({
        title: "{{ session('error') }}",
        icon: "error",
        button: "OK",
    })
@endif
</script>
@endsection
