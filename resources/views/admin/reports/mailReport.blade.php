@extends('layouts.adminMainLayouts')

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        /* Add the CSS styles here */
        .select2-container {
            border: none !important;
            border-radius: 0 !important;
        }

        .select2-selection {
            border: none !important;
            outline: none !important;
        }

        .select2-selection__arrow {
            border: none !important;
        }
    </style>
@endpush

@section('current-page-title')
    Reports
@endsection
@section('current-page-title-icon')
    fas fa-ticket-alt
@endsection

@section('adminContent')
    <div class="row g-3 mb-3">
        <div class="col-lg-12">
            <form method="get" action="{{ route('mail.ticket.report') }}" id="mailForm" class="card">
                @csrf

                <input type="hidden" name="from" value="{{ $from }}">
                <input type="hidden" name="to" value="{{ $to }}">
                <input type="hidden" name="chapter" value="{{ $chapter }}">

                <div class="card-header bg-light">
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <h6 class="mb-0">
                                @if ($chapter == 'ALL')
                                    All Chapters
                                @else
                                    {{ $chapter }}
                                @endif
                            </h6>
                            <h6 class="mb-0">Ticket from {{ date('M j, Y', strtotime($from)) }} To: {{ date('M j, Y', strtotime($to)) }}</h6>
                        </div>
                        <div class="col-auto d-flex">
                            <div class="col-auto text-center pe-card">
                                <select class="form-select form-select-sm" id="recipientsList">
                                    <option value="">Select Recipient</option>
                                    @foreach ($recipientsList as $recipientsList)
                                        <option>{{ $recipientsList->chapter }}</option>
                                    @endforeach
                                </select>
                              </div>
                            <button type="button" id="recipientButton" class="btn btn-sm btn-primary me-2">Recipient Setup</button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="border border-top-0 border-200 ps-3">
                        <select class="form-control border-0 rounded-0 outline-none px-card" id="recipients" name="recipients[]" multiple>
 
                        </select>
                    </div>
                    <div class="border border-top-0 border-200 ps-3">
                        <select class="form-control border-0 rounded-0 outline-none px-card" id="CCrecipients" name="CCrecipients[]" multiple>
  
                        </select>
                    </div>
                    <div class="border border-y-0 border-200">
                        <input 
                            class="form-control border-0 rounded-0 outline-none px-card" 
                            id="subject" 
                            name="subject" 
                            type="text" 
                            aria-describedby="email-subject" 
                            placeholder="Subject"
                            value="Ticket Summary Report: {{ date('M j, Y', strtotime($from)) }} to {{ date('M j, Y', strtotime($to)) }}"
                        />
                    </div>
                    <div class="min-vh-50">
                        <textarea class="tinymce d-none" id="content" name="content">
                            <p>Good day!</p>
                            <p>Please see the attached Ticket Summary Report covering the period from {{ date('M j, Y', strtotime($from)) }} to {{ date('M j, Y', strtotime($to)) }}. This report includes all logged tickets from our ticketing system within the specified timeframe.</p>
                            <p>If you have any questions or need further clarification regarding the report, feel free to reach out.</p>
                            <p></p>
                            <p>Thank you, and best regards,</p>
                            <p>Fedcis Team</p>
                        </textarea>
                    </div>
                    <div class="bg-light px-card py-3">
                        <div class="d-inline-flex flex-column">
                            <div class="border px-2 rounded-3 d-flex flex-between-center bg-white dark__bg-1000 my-1 fs--1">
                                <span class="fs-1 far fa-file-pdf"></span>
                                <span class="ms-2">Ticket Summary Report {{ date('M j, Y', strtotime($from)) }} to {{ date('M j, Y', strtotime($to)) }}.pdf ({{ rand(700, 999) }}kb)</span>
                                <a class="text-300 p-1 ms-6" href="#!" data-bs-toggle="tooltip" data-bs-placement="right" title="Attachment">
                                    <span class="fas fa-check"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top border-200 d-flex flex-between-center">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary btn-sm px-5 me-2" type="button" id="send">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-admin.reports.modal.recipientSetup/>
@endsection

@push('javascript')
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="{{ asset('assets/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#recipients').select2({
                placeholder: 'To',
                allowClear: true, // Adds a clear button
            });

            $('#CCrecipients').select2({
                placeholder: 'CC',
                allowClear: true, // Adds a clear button
            });

            $('#recipientsList').on('change', function() {
                var selectedValue = $(this).val(); // Get the selected value

                $.ajax({
                    url: "/fetch-recipients/"+selectedValue,
                    type: "GET",
                    success: function (data) {
                        $.each(data, function (index, item) {
                            // var option = new Option(item.recepients, item.recepients, true, true);
                            // $('#recipients').append(option).trigger('change');

                            var selectedRecipients = []; // Create an array to store selected values
                            $.each(data, function (index, item) {
                                selectedRecipients.push(item.recepients); // Add values to the array
                            });
                            $('#recipients').val(selectedRecipients).trigger('change'); // Set all selected values
                        });
                    },error: function (error) {
                        console.log(error);
                    },
                });
            });

            tinymce.init({
                selector: "#content"
            });

            $("#send").click(function() {
                var editor = tinymce.get("content");
                var content = editor.getContent();

                if ($('#recipients').val() && $('#subject').val() && content) {
                    swal({
                        title: 'Are you sure?',
                        text: "Do you want to send this email?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((function(e) {
                        if (e == true) {
                            $('#mailForm').submit();
                        }
                    }))
                } else {
                    swal({
                        title: 'Oopss',
                        text: 'Please complete all the required fields!',
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonClass: 'btn btn-success',
                    })
                }
            })

            $("#recipientButton").click(function() {
                loadEmailList()
                $('#priorityModal').modal('toggle');
            })

            function loadEmailList(){
                $.ajax({
                    url     : '/fetch-emails',
                    type    : 'get',
                    dataType: 'json',
                    success : function(response) {
                        var ctr = 0
                        $('#emailsListTable tbody').empty();

                        $.each(response, function (key, value) {
                            ctr = ctr + 1;
                            $('#emailListTableContent').append('\n\
                                <tr>\n\
                                    <td>'+ctr+'</td>\n\
                                    <td>'+value.recepients+'</td>\n\
                                    <td>'+value.chapter+'</td>\n\
                                    <td class="text-end">\n\
                                        <div>\n\
                                            <button class="btn p-0 ms-2 removeEmail" type="button" id="'+value.id+'" title="Delete"><span class="text-500 fas fa-trash-alt"></span></button>\n\
                                        </div>\n\
                                    </td>\n\
                                </tr>\n\
                            ');
                        })
                    },error: function(xhr) {
                        console.log(xhr)
                    }
                });
            }

            $("#saveRecipient").click(function() {
                if($('#email').val() && $('#chapter').val()){          
                    $.ajax({
                        url: '/save-recipients',
                        method: 'POST',
                        data: $(recipientsForm).serialize(),
                        success: function(response) {
                            $('#email').val('')
                            loadEmailList()
                            loadEmailToSelect()
                            loadEmailToCC()

                            swal({
                                title: 'Success',
                                text: 'Email has been saved!',
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-success',
                            })
                        },error: function(xhr) {
                            console.log(xhr)
                        }
                    });
                }else{
                    swal({
                        title: 'Oopss',
                        text: 'Please complete all the required fields!',
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonClass: 'btn btn-success',
                    })
                }
            })

            $(document).on("click", ".removeEmail", function() {
                var id = $(this).attr('id');

                swal({
                    title: 'Are you sure?',
                    text: "Do you want to remove this email?",
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((function(e) {
                    if (e == true) {
                        $.ajax({
                            url     :  '/delete-email',
                            type    : 'post',
                            data    :  {id:id,'_token' : $("#csrf_status").val(),'_method' : $("#method_delete").val()},
                            dataType: 'json',
                            success : function(response){ 
                                loadEmailList()
                                loadEmailToSelect()
                                loadEmailToCC()

                                swal({
                                    title: 'Success',
                                    text: 'Email has been removed!',
                                    type: 'success',
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn btn-success',
                                })
                            },error: function(data){
                                alert("Error")
                            }
                        })
                    }
                }))
            });

        });

        function loadEmailToSelect(){
            var selectElement = $("#recipients");
            $("#recipients").empty();

            $.ajax({
                url     : '/fetch-emails',
                type    : 'get',
                dataType: 'json',
                success : function(response) {
                    var newOption = new Option("", "", false, false);
                    selectElement.append(newOption);

                    $.each(response, function (key, value) {
                        var newOption = new Option(value.recepients,value.recepients,false,false);
                        selectElement.append(newOption);
                    });

                    selectElement.trigger("change");
                },error: function(xhr) {
                    console.log(xhr)
                }
            });
        }

        loadEmailToSelect()

        function loadEmailToCC(){
            var selectElement = $("#CCrecipients");
            $("#CCrecipients").empty();

            $.ajax({
                url     : '/fetch-emails',
                type    : 'get',
                dataType: 'json',
                success : function(response) {
                    var newOption = new Option("", "", false, false);
                    selectElement.append(newOption);

                    $.each(response, function (key, value) {
                        var newOption = new Option(value.recepients,value.recepients,false,false);
                        selectElement.append(newOption);
                    });

                    selectElement.trigger("change");
                },error: function(xhr) {
                    console.log(xhr)
                }
            });
        }

        loadEmailToCC()
    </script>
@endpush
