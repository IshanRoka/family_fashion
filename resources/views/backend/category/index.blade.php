@extends('backend.layouts.main')

@section('title')
    Category
@endsection

@section('styles')
    <style>
        label#upload-image-error {
            position: absolute;
            top: 8.2rem !important
        }
    </style>
@endsection

@section('main-content')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Category</h5>
        </div>
    </div>

    <div class="modal fade" id="CategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4">
            <div class="card custom-card">
                <form action="{{ route('category.save') }}" method="POST" id="faqForm">
                    <input type="hidden" name="id" value="" id="id">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <label for="name" class="form-label">Category Name <span
                                        class="required-field">*</span></label>
                                <input type="text" class="form-control" id="name" placeholder="Enter category name"
                                    value="" name="name">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <label for="image">Thumbnail Image <span class="required-field">*</span></label>
                                <div class="relative" id="edit-image">
                                    <div class="profile-user">
                                        <label for="thumbnail_image"
                                            class="fe fe-camera profile-edit text-primary absolute"></label>
                                    </div>
                                    <input type="file" class="thumbnail_image" id="thumbnail_image"
                                        style="position: absolute; clip: rect(0, 0, 0, 0); pointer-events: none;"
                                        accept="image/*"name=" image">
                                    <div class="img-rectangle mt-2">
                                        @if (!empty($image))
                                            {!! $image !!}
                                        @else
                                            <img src="{{ asset('/no-image.jpg') }}" alt="Default Image"id="img_introduction"
                                                class="_image">
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-4 ms-1">
                                    <p class="p-0 m-0">Accepted Format :<span class="text-muted"> jpg/jpeg/png</span></p>
                                    <p class="p-0 m-0">File size :<span class="text-muted"> (300x475) in pixels</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-success saveData"><i class="fa fa-save"></i> Create
                            Category</button>

                    </div>
                </form>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Category List
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="datatable-basic_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 mb-3">
                                    <div class="dataTables_length" id="datatable-basic_length">
                                        <table id="categoryTable"
                                            class="table table-bordered text-nowrap w-100 dataTable no-footer mt-3"
                                            aria-describedby="datatable-basic_info">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Category</th>
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
        var categoryTable;
        $(document).ready(function() {

            $('#thumbnail_image').on('change', function(event) {
                const selectedFile = event.target.files[0];
                if (selectedFile) {
                    $('._image').attr('src', URL.createObjectURL(selectedFile));
                }
            });
            categoryTable = $('#categoryTable').DataTable({
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
                    [1]
                ],
                "bSort": true,
                "bProcessing": true,
                "bServerSide": true,
                "oLanguage": {
                    "sEmptyTable": "<p class='no_data_message'>No data available.</p>"
                },
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0, 2]
                }],
                "aoColumns": [{
                        "data": "sno"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "action"
                    },
                ],
                "ajax": {
                    "url": '{{ route('category.list') }}',
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


            $('#faqForm').validate({
                rules: {
                    name: 'required'
                },
                message: {
                    name: 'This is required field.'
                },
                highlight: function(element) {
                    $(element).addClass('border-danger')
                },
                unhighlight: function(element) {
                    $(element).removeClass('border-danger')
                },
            });

            $('.saveData').off('click')
            $('.saveData').on('click', function() {
                if ($('#faqForm').valid()) {
                    showLoader();

                    // Submit the form using AJAX
                    $('#faqForm').ajaxSubmit({
                        success: function(response) {
                            if (response.type === 'success') {
                                $('.saveData').html(
                                    '<i class="fa fa-save"></i> Create Category');
                                showNotification(response.message, 'success');
                                categoryTable.draw();
                                $('#faqForm')[0].reset();
                                $('#id').val('');
                                $('#thumbnail_image').val('');
                                $('.saveData').removeClass('btn-primary').addClass(
                                    'btn-success').html(
                                    '<i class="fa fa-save"></i> Create FAQ');
                            } else {
                                showNotification(response.message, 'error');
                                hideLoader();
                            }
                            hideLoader();
                        },
                        error: function(xhr) {
                            var response = xhr.responseJSON;
                            showNotification(response && response.message ? response.message :
                                'Something went wrong. Please try again later', 'error');
                            hideLoader();
                        }
                    });
                }
            });

            $(document).off('click', '.editCategory');
            $(document).on('click', '.editCategory', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#id').val(id);
                $('#name').val($(this).data('name'));

                if ($('#id').val()) {
                    $('.saveData').removeClass('btn-success').addClass('btn-primary').html(
                        '<i class="fa fa-save"></i> Update Category');
                } else {
                    $('.saveData').removeClass('btn-primary').addClass('btn-success').html(
                        '<i class="fa fa-save"></i> Create Category');
                }
            });

            $(document).off('click', '.deleteCategory');
            $(document).on('click', '.deleteCategory', function() {
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
                        var url = '{{ route('category.delete') }}';
                        $.post(url, data, function(response) {
                            if (response) {
                                if (response.type === 'success') {
                                    showNotification(response.message, response.type)
                                    categoryTable.draw();
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

        });
    </script>
@endsection
