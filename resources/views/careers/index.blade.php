@extends('layouts.app')


@section('content')
    @php

        $name = 'careers';

    @endphp
    <style>
        .bg-primary{
            background-color: #1f3a8a;
        }
        .status-select{
            width: 100px;
        }
        .pending {
        background-color: #ffc107; /* Yellow for pending */
        color: #212529; /* Text color */
        }

        .hired {
            background-color: #28a745; /* Green for reviewed */
            color: #ffffff; /* Text color */
        }

        .interview {
            background-color: #007bff; /* Blue for scheduled interview */
            color: #ffffff; /* Text color */
        }

        .reviewed {
            background-color: #17a2b8; /* Teal for hired */
            color: #ffffff; /* Text color */
        }

        .rejected {
            background-color: #dc3545; /* Red for rejected */
            color: #ffffff; /* Text color */
        }
    </style>
    <h2 class="intro-y text-lg font-medium mt-10">
        Careers Management
    </h2>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 sm:col-span-6 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-start">
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <form method="GET" action="{{ url('careers') }}">
                    <div class="grid grid-cols-12 gap-3 mt-5 items-end">
                        <div class="intro-y col-span-12 sm:col-span-3">
                            <label for="status">Status:</label><br>
                            <select name="status" id="status" class="form-select">
                                <option value="">Select Status</option>
                                <option value="pending" {{ (isset($_GET['status']) && $_GET['status'] == 'pending')? 'selected' : '' }}>Pending</option>
                                <option value="reviewed" {{ (isset($_GET['status']) && $_GET['status'] == 'reviewed')? 'selected' : '' }}>Reviewed</option>
                                <option value="interview" {{ (isset($_GET['status']) && $_GET['status'] == 'interview')? 'selected' : '' }}>Scheduled Interview</option>
                                <option value="Hired" {{ (isset($_GET['status']) && $_GET['status'] == 'Hired')? 'selected' : '' }}>Hired</option>
                                <option value="Rejected" {{ (isset($_GET['status']) && $_GET['status'] == 'Rejected')? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-3">
                            <label for="month">Month:</label><br>
                            <input type="month" id="month" name="month" class="form-control" value="{{ isset($_GET['month']) ? $_GET['month'] : '' }}"/>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-3">                                
                            <button type="submit" class="btn btn-primary whitespace-nowrap">Apply Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="intro-y col-span-12 overflow-auto xl:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">ID</th>
                        <th class=" whitespace-nowrap">Name</th>

                        <th class=" whitespace-nowrap">Contact No.</th>
                        <th class=" whitespace-nowrap">Position</th>
                        <!-- <th class=" whitespace-nowrap">Skills</th> -->
                        <th class=" whitespace-nowrap">Date</th>
                        <th class=" whitespace-nowrap thd-width">Status</th>
                        <th class="text-center" colspan="3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($careers as $career)
                    @php
                        $whatsapp_message = "Hello $career->first_name $career->last_name, I hope you are doing well. This is Rashmi from Just Digital Gurus. We have received your application. Could you please let us know your availability for an online interview?";
                    @endphp
                        <tr>
                            <td>{{ $career->id }} 
                                @if($career->previous_applied == 1)
                                    <a class="btn btn-sm attendance-status-btn btn-rounded-danger p-1">
                                        Previous Applied
                                    </a>
                                @endif
                            </td>
                            <td class=" whitespace-nowrap">{{ $career->first_name }} {{ $career->last_name }}</td>

                            <td class=" whitespace-nowrap"><a href="https://wa.me/{{ $career->number }}?text={{ $whatsapp_message }}" style="text-decoration: underline;">{{ $career->number }}</a></td>
                            <td class=" whitespace-nowrap">{{ $career->position }}</td>
                            <!-- <td class="text-center">{{ $career->skills }}</td> -->

                            <td class=" whitespace-nowrap">{{ $career->created_at->format('d M, Y') }}</td>
                            <td class="thd-width">
                                <div class="dropdown" data-placement="right">
                                    <button class="dropdown-toggle btn status-dropdown-btn status-dropdown-btn{{ $career->id }} {{ $career->status }}" aria-expanded="false">{{ $career->status }}</button>
                                    <div class="dropdown-menu w-40">
                                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                            <a  class="block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md whitespace-nowrap status-click" data-id="{{ $career->id }}" data-status="pending">Pending</a>
                                            <a  class="block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md whitespace-nowrap status-click" data-id="{{ $career->id }}" data-status="reviewed">Reviewed</a>
                                            <a  class="block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md whitespace-nowrap status-click" data-id="{{ $career->id }}" data-status="interview">Scheduled Interview</a>
                                            <a  class="block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md whitespace-nowrap status-click" data-id="{{ $career->id }}" data-status="Hired">Hired</a>
                                            <a href="javascript:;" data-toggle="modal" data-target="#rejected-message-modal{{ $career->id }}" class="block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md whitespace-nowrap" >Rejected Applications</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center table-report__action">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3" href="{{ route('careers.show', $career->id) }}">
                                        <i data-feather="eye" class="w-4 h-4 mr-1"></i>
                                    </a>
                                    <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal{{ $career->id }}">
                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                    </a>
                                </div>
                            </td>

                        </tr>
                        <!-- BEGIN: Rejected message Modal -->
                        <div id="rejected-message-modal{{ $career->id }}" class="modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <form id="rejection-form{{ $career->id }}" data-id="{{ $career->id }}">
                                            @csrf
                                            <div class="p-5 text-center">
                                                <div class="text-3xl mt-5">Rejection Message</div>
                                                <div>
                                                    <div class="mt-2"> 
                                                        <select name="rejected_message" id="rejectionMessageSelect{{ $career->id }}" class="form-control w-full rejected_message{{ $career->id }}" required onchange="handleRejectionSelectChange({{ $career->id }})">
                                                            <option value="">Select Message</option>
                                                            <option value="Not a good fit">Not a good fit</option>
                                                            <option value="From another city">From another city</option>
                                                            <option value="other">Other</option>
                                                        </select> 
                                                    </div>
                                                </div>
                                                <div id="otherRejectionTextArea{{ $career->id }}" class="text-gray-600 mt-4" style="display: none;">
                                                    <textarea name="rejected_message" rows="4" class="form-control rejected_message{{ $career->id }}" placeholder="Write a Rejection Message"></textarea>
                                                </div>
                                            </div>
                                            <div class="px-5 pb-8 text-center">
                                                <button type="button" id="close-rejection-model{{ $career->id }}" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                <button type="submit" class="btn btn-primary w-24" id="submitBtn">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Rejected message Modal -->
                        <!-- BEGIN: Delete Confirmation Modal -->
                        <div id="delete-confirmation-modal{{ $career->id }}" class="modal" tabindex="-1"
                            aria-hidden="true">
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
                                            {{-- @foreach ($users as $user) --}}
                                            <form action="{{ route('careers.destroy', $career->id) }}" method="POST">
                                                <button type="button" data-dismiss="modal"
                                                    class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                            {{-- @endforeach --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Delete Confirmation Modal -->
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $careers->links() }}
        </div>
    </div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.status-select').each(function () {
            var selectedStatus = $(this).val().toLowerCase();
            $(this).addClass(selectedStatus);
        });

        $('.status-click').click(function () {
            var selectedStatus = $(this).data('status');
            var recordId = $(this).data('id');
            var row = $('.status-dropdown-btn'+recordId);
            // console.log('status  : ' + selectedStatus);
            // console.log('id  : ' + recordId);

            // exit();
            // Send AJAX request to update the status
            $.ajax({
                type: 'POST',
                url: "{{ route('careers.update_status') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    id: recordId,
                    status: selectedStatus
                },
                success: function (response) {
                    console.log(selectedStatus);
                    row.removeClass();
                    row.addClass("dropdown-toggle btn status-dropdown-btn status-dropdown-btn"+ recordId + " " + selectedStatus);
                    row.text(selectedStatus.charAt(0).toUpperCase() + selectedStatus.slice(1));
                    swal({
                        title: "Success",
                        text: "Status updated successfully",
                        icon: "success",
                        button: "OK",
                    });
                },
                error: function (error) {
                    console.error(error);
                    // You can handle error actions here if needed
                }
            });
        });
        $('form[id^="rejection-form"]').submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var recordId = form.data('id');
        // var rejectionMessage = $('.rejected_message'+recordId).val();
        var selectElement = $('#rejectionMessageSelect' + recordId);
        var rejectionMessage = selectElement.val();

        // Check if "Other" is selected, then get the value from the textarea
        if (rejectionMessage === 'other') {
            rejectionMessage = $('#otherRejectionTextArea' + recordId + ' textarea').val();
        }
        // console.log(rejectionMessage);
        // exit();
        var row = $('.status-dropdown-btn' + recordId);

        // Send AJAX request to update the status and rejection message
        $.ajax({
            type: 'POST',
            url: "{{ route('careers.update_status') }}",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: {
                id: recordId,
                status: 'Rejected',
                rejected_message: rejectionMessage
            },
            success: function (response) {
                console.log('Rejected');
                row.removeClass();
                row.addClass("dropdown-toggle btn status-dropdown-btn status-dropdown-btn" + recordId + " Rejected");
                row.text('Rejected');
                swal({
                    title: "Success",
                    text: "Rejection message sent and status updated successfully",
                    icon: "success",
                    button: "OK",
                });
                $('#close-rejection-model'+recordId).click();
                // form.closest('.modal').modal('hide'); // Close the modal
            },
            error: function (error) {
                console.error(error);
                // Handle error if needed
            }
        });
    });
    });
</script>
<script>
    function disableButton() {
        // Disable the button to prevent multiple submissions
        document.getElementById('submitBtn').disabled = true;
        return true; // Allow the form to be submitted
    }
</script>
<script>
    function handleRejectionSelectChange(careerId) {
        var selectElement = document.getElementById('rejectionMessageSelect' + careerId);
        var otherMessageTextArea = document.getElementById('otherRejectionTextArea' + careerId);

        if (selectElement.value === 'other') {
            otherMessageTextArea.style.display = 'block';
        } else {
            otherMessageTextArea.style.display = 'none';
        }
    }
</script>
@endsection
