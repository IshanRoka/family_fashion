@extends('backend.layouts.main')

@section('title')
    Customer
@endsection
<style>
    input#trashed_file {
        border: 1px solid rgb(0, 99, 198) !important
    }
</style>
@section('main-content')
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Customer</h5>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="courseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{-- Content goes here --}}
            </div>
        </div>
    </div>
    <!-- Page Header Close -->


    <div class="row ">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Customer List
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="datatable-basic_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 mb-3">
                                    <div class="dataTables_length" id="datatable-basic_length">
                                        <table id="courseTable"
                                            class="table table-bordered text-nowrap w-100 dataTable no-footer mt-3"
                                            aria-describedby="datatable-basic_info">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                    <th>Phone Number</th>
                                                    <th>Action</th>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->
@endsection

@section('script')
    <script>
        var courseTable;
        $(document).ready(function() {

            $('.addCourseButton').on('click', function(e) {
                e.preventDefault();
                var url = '{{ route('product.form') }}';
                $.get(url, function(response) {
                    $('#courseModal .modal-content').html(response);
                    $('#courseModal').modal('show');
                });
            });


            courseTable = $('#courseTable').DataTable({
                "sPaginationType": "full_numbers",
                "bSearchable": false,
                "lengthMenu": [
                    [5, 10, 15, 20, 25, -1],
                    [5, 10, 15, 20, 25, "All"]
                ],
                'iDisplayLength': 15,
                "sDom": 'ltipr',
                "bAutoWidth": false,
                "aaSorting": [
                    [0, 'desc']
                ],
                "bSort": false,
                "bProcessing": true,
                "bServerSide": true,
                "oLanguage": {
                    "sEmptyTable": "<p class='no_data_message'>No data available.</p>"
                },
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [1]
                }],
                "aoColumns": [{
                        "data": "sno"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "address"
                    },
                    {
                        "data": "phone_number"
                    },
                    {
                        "data": "action"
                    },
                ],
                "ajax": {
                    "url": '{{ route('customer.list') }}',
                    "type": "POST",
                    "data": function(d) {
                        var type = $('#trashed_file').is(':checked') == true ? 'trashed' :
                            'nottrashed';
                        d.type = type;
                    }
                },
                "initComplete": function() {
                    // Ensure text input fields in the header for specific columns with placeholders
                    this.api().columns([]).every(function() {
                        var column = this;
                        var input = document.createElement("input");
                        var columnName = column.header().innerText.trim();
                        // Append input field to the header, set placeholder, and apply CSS styling
                        $(input).appendTo($(column.header()).empty())
                            .attr('placeholder', columnName).css('width',
                                '100%') // Set width to 100%
                            .addClass(
                                'search-input-highlight') // Add a CSS class for highlighting
                            .on('keyup change', function() {
                                column.search(this.value).draw();
                            });
                    });
                }
            });

            $(document).off('click', '.viewPost');
            $(document).on('click', '.viewPost', function() {
                var id = $(this).data('id');
                var url = '{{ route('customer.view') }}';
                var data = {
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#courseModal .modal-content').html(response);
                    $('#courseModal').modal('show');
                });
            });

        });
    </script>
@endsection
