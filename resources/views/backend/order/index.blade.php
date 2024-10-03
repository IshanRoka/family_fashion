@extends('backend.layouts.main')

@section('title')
    Order
@endsection
<style>
    input#trashed_file {
        border: 1px solid rgb(0, 99, 198) !important
    }
</style>
@section('main-content')
    <div class="row ">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Order List
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
                                                    <th>Customer Name</th>
                                                    <th>Customer Email</th>
                                                    <th>Product</th>
                                                    <th>Size</th>
                                                    <th>Quantity</th>
                                                    <th>Total Price</th>
                                                    <th>Image</th>
                                                    <th>Status</th>
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
@endsection

@section('script')
    <script>
        function showSuccessMessage(message) {
            var messageDiv = $('<div></div>')
                .text(message)
                .css({
                    'position': 'fixed',
                    'top': '20px',
                    'right': '20px',
                    'padding': '10px 20px',
                    'background-color': '#28a745',
                    'color': '#fff',
                    'border-radius': '5px',
                    'z-index': '9999',
                    'display': 'none',
                    'box-shadow': '0 4px 8px rgba(0, 0, 0, 0.2)'
                });
            $('body').append(messageDiv);
            messageDiv.fadeIn(300).delay(3000).fadeOut(300, function() {
                $(this).remove();
            });
        }

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
                        "data": "customerName"
                    },
                    {
                        "data": "customerEmail"
                    },
                    {
                        "data": "productName"
                    },
                    {
                        "data": "size"
                    },
                    {
                        "data": "qty"
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
                    "url": '{{ route('order.list') }}',
                    "type": "POST",
                    "data": function(d) {
                        var type = $('#trashed_file').is(':checked') == true ? 'trashed' :
                            'nottrashed';
                        d.type = type;
                    }
                },
                "initComplete": function() {
                    this.api().columns([]).every(function() {
                        var column = this;
                        var input = document.createElement("input");
                        var columnName = column.header().innerText.trim();
                        $(input).appendTo($(column.header()).empty())
                            .attr('placeholder', columnName).css('width',
                                '100%')
                            .addClass(
                                'search-input-highlight')
                            .on('keyup change', function() {
                                column.search(this.value).draw();
                            });
                    });
                }
            });

            $('#courseTable').on('change', '.status-select', function() {
                var orderId = $(this).data('id');
                var newStatus = $(this).val();

                $.ajax({
                    url: '{{ route('order.update') }}',
                    method: 'POST',
                    data: {
                        id: orderId,
                        status: newStatus,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        showSuccessMessage(
                            'Status updated successfully!'); // Display the success message
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating status:', xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endsection
