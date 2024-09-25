<style>
    .ql-container {
        height: 200px;
    }

    .ql-editor {
        min-height: 100% !important;
    }

    input[type="file"] {
        display: block;
    }

    .imageThumb {
        max-height: 75px;
        border: 2px solid;
        margin-left: 10px;
        margin-bottom: 3px;
        padding: 1px;
        cursor: pointer;
    }

    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }


    .cropper-container {
        width: 100% !important;
    }

    .modal-header {
        position: relative;
    }

    .modal-header .closeCrop {
        position: absolute;
        top: 13px;
        right: 15px;
    }

    label#thumbnail_image-error {
        position: absolute;
        top: 9rem !important
    }

    #ndp-nepali-box {
        top: 60px !important;
        left: 10px !important;
    }

    input#nepali-datepicker {
        width: 100% !important;
        height: 50% !important;
        border-radius: 0.2rem !important;
        border: 0.1px solid rgb(236, 231, 231);
        padding-left: 0.5rem !important;
    }
</style>
<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Course</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="{{ route('product.save') }}" method="POST" id="courseForm" enctype="multipart/form-data">

        <div class="row">
            <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3">
                <input type="hidden" name="id" id="id" value="{{ @$prevPost->id }}">
                <label for="Category" class="form-label">Program <span class="required-field">*</span></label>
                <select class="form-select" aria-label="Default select example" id="Progran" name="category_id">
                    <option selected disabled>Select Progran</option>
                    @foreach ($category as $categoryProduct)
                        <option value="{{ $categoryProduct->id }}" @if (@$prevPost->category_id == $categoryProduct->id) selected @endif>
                            {{ $categoryProduct->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3">
                <label for="Product_name" class="form-label">Product name <span class="required-field">*</span></label>
                <input type="text" class="form-control" id="product_name" name="product_name"
                    placeholder="Enter product name..." value="{{ @$prevPost->name }}">
            </div>
        </div>

        <div class="row mt-2" id="college">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="description" class="form-label">Description <span class="required-field"></span></label>
                <textarea class="form-control" id="description" name="description" rows="3"
                    placeholder="Enter description for the course...">{!! @$prevPost->description !!}</textarea>
            </div>

        </div>

        <div class="row mt-2" id="bachelor">
            <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3">
                <label for="price" class="form-label">Price <span class="required-field"></span></label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Enter price..."
                    value="{{ @$prevPost->price }}">
            </div>
            <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3">
                <label for="stock_quantity" class="form-label">Stock_quantity <span
                        class="required-field"></span></label>
                <input type="text" class="form-control" id="stock_quantity" name="stock_quantity"
                    placeholder="Enter stock_quantity ..." value="{{ @$prevPost->stock_quantity }}">
            </div>
            <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3">
                <label for="color" class="form-label">Color <span class="required-field"></span></label>
                <input type="text" class="form-control" id="color" name="color" placeholder="Enter color ..."
                    value="{{ @$prevPost->color }}">
            </div>
            <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3">
                <label for="size" class="form-label">Size <span class="required-field"></span></label>
                <input type="text" class="form-control" id="size" name="size" placeholder="Enter size ..."
                    value="{{ @$prevPost->size }}">
            </div>
        </div>

        <div class="row mt-2" id="bachelor">
            <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3">
                <label for="material" class="form-label">Material <span class="required-field"></span></label>
                <input type="text" class="form-control" id="material" name="material" placeholder="Enter order..."
                    value="{{ @$prevPost->material }}">
            </div>

        </div>


        <div class="row mt-2">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <label for="image">Thumbnail Image <span class="required-field">*</span></label>
                        <div class="relative" id="edit-image">
                            <div class="profile-user">
                                <label for="thumbnail_image"
                                    class="fe fe-camera profile-edit text-primary absolute"></label>
                            </div>
                            <input type="file" class="thumbnail_image" id="thumbnail_image"
                                style="position: absolute; clip: rect(0, 0, 0, 0); pointer-events: none;"
                                accept="image/*"name="image">
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
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary saveCourse"><i class="fa fa-save"></i>
        @if (empty(@$prevPost->id))
            Save
        @else
            Update
        @endif
    </button>
</div>
<script>
    $(document).ready(function() {
        var quill = new Quill('#details', {
            theme: 'snow'
        });

        $('#thumbnail_image').on('change', function(event) {
            const selectedFile = event.target.files[0];

            if (selectedFile) {
                $('._image').attr('src', URL.createObjectURL(selectedFile));
            }
        });

        //validation
        $('#courseForm').validate({
            rules: {
                Program_id: "required",
                course_name: "required",
                order_number: "required",
                details: "required",
                image: {
                    required: function() {
                        var id = $('#id').val();
                        return id === '';
                    }
                },
            },
            message: {
                Program_id: {
                    required: "This field is required."
                },
                course_name: {
                    required: "This field is required."
                },
                details: {
                    required: "This field is required."
                },
                order_number: {
                    required: "This field is required."
                },
                image: {
                    required: "This field is required."
                },
            },
            highlight: function(element) {
                $(element).addClass('border-danger')
            },
            unhighlight: function(element) {
                $(element).removeClass('border-danger')
            },
        });

        // Save news
        $('.saveCourse').off('click');
        $('.saveCourse').on('click', function() {
            if ($('#courseForm').valid()) {
                showLoader();
                $('#courseForm').ajaxSubmit({
                    success: function(response) {
                        if (response) {
                            if (response.type === 'success') {
                                showNotification(response.message, 'success');
                                courseTable.draw();
                                $('#courseForm')[0].reset();
                                $('#id').val('');
                                $('#courseModal').modal('hide');
                                hideLoader();
                            } else {
                                showNotification(response.message, 'error');
                                hideLoader();
                            }
                        }
                        hideLoader();
                    },
                    error: function(xhr) {
                        hideLoader();
                        var response = xhr.responseJSON;
                        showNotification(response ? response.message : 'An error occurred',
                            'error');
                    }
                });
            }
        });

    });
</script>
