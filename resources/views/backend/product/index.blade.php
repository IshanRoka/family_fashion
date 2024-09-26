@extends('backend.layouts.main')

@section('title')
    Course
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
            <h5 class="page-title fs-21 mb-1">Product</h5>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pe-1 mb-xl-0">
                <button type="button" class="btn btn-primary addCourseButton" data-bs-toggle="modal"
                    data-bs-target="#courseModal"><i class="fa fa-add"></i> Add</button>
            </div>
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
    <!-- Start::row-1 -->
    {{-- crop modal-start --}}

    <div class="modal cropModel fade" id="cropModel" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Crop Image</h5>
                    <button type="button" class="closeCrop" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-12">
                                <img id="image" src="#" style="height: 200px; width: 250px;">
                            </div>
                            <div class="col-md-12">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                    <div id="controls">
                        <button id="rotateLeft">Rotate Left</button>
                        <button id="rotateRight">Rotate Right</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn_btn cancel_btn cancelCrop" id="cancelCrop">Cancel</button>
                    <button type="button" class="btn_btn submit_btn" id="cropImage">Crop</button>
                </div>
            </div>
        </div>
    </div>
    {{-- crop modal-end --}}

    <div class="row ">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Product List
                    </div>
                    <div class="row ms-0">
                        <div class="form-check col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <input class="form-check-input" type="checkbox" value="Y" id="trashed_file"
                                name="trashed_file">
                            <label class="form-check-label" for="trashed_file">
                                View Trashed
                            </label>
                        </div>
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
                                                    <th>Category</th>
                                                    <th>Description</th>
                                                    <th>Stock</th>
                                                    <th>Material</th>
                                                    <th>Size</th>
                                                    <th>Color</th>
                                                    <th>Price</th>
                                                    <th>Image</th>
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
                        "data": "category"
                    },
                    {
                        "data": "description"
                    },
                    {
                        "data": "stock_quantity"
                    },
                    {
                        "data": "material"
                    },
                    {
                        "data": "size"
                    },
                    {
                        "data": "color"
                    },
                    {
                        "data": "price"
                    },
                    {
                        "data": "image"
                    },
                    {
                        "data": "action"
                    },
                ],
                "ajax": {
                    "url": '{{ route('product.list') }}',
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


            // Edit news-start
            $(document).off('click', '.editNews');
            $(document).on('click', '.editNews', function() {
                var id = $(this).data('id');
                var url = '{{ route('product.form') }}';
                var data = {
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#courseModal .modal-content').html(response);
                    $('#courseModal').modal('show');
                });
            });
            //edit news -end

            // view trashed items-start
            $('#trashed_file').off('change');
            $('#trashed_file').on('change', function(e) {
                courseTable.draw();
            });
            // view trashed items-ends


            // Delete news
            $(document).off('click', '.deleteNews');
            $(document).on('click', '.deleteNews', function() {

                var type = $('#trashed_file').is(':checked') == true ? 'trashed' :
                    'nottrashed';

                Swal.fire({
                    title: type === "nottrashed" ? "Are you sure you want to delete this item" :
                        "Are you sure you want to delete permanently  this item",
                    text: "You won't be able to revert it!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DB1F48",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoader();
                        var id = $(this).data('id');
                        var data = {
                            id: id,
                            type: type,
                        };
                        var url = '{{ route('product.delete') }}';
                        $.post(url, data, function(response) {
                            if (response) {
                                if (response.type === 'success') {
                                    showNotification(response.message, 'success');
                                    courseTable.draw();
                                    hideLoader();
                                } else {
                                    showNotification(response.message, 'error');
                                    hideLoader();
                                }
                            }
                        });
                    }
                });
            });

            //Restore
            $(document).off('click', '.restore');
            $(document).on('click', '.restore', function() {
                Swal.fire({
                    title: "Are you sure you want to restore Post?",
                    text: "This will restore the Post.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Restore it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoader();
                        var id = $(this).data('id');
                        var data = {
                            id: id,
                            type: 'restore'
                        };
                        var url = '{{ route('product.restore') }}';
                        $.post(url, data, function(response) {
                            if (response) {
                                if (response.type === 'success') {
                                    showNotification(response.message, 'success');
                                    courseTable.draw();
                                    hideLoader();
                                } else {
                                    showNotification(response.message, 'error');
                                    hideLoader();
                                }
                            }
                        });
                    }
                });
            });

            //View Post
            $(document).off('click', '.viewPost');
            $(document).on('click', '.viewPost', function() {
                var id = $(this).data('id');
                var url = '{{ route('product.view') }}';
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
