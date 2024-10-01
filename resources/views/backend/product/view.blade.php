@if ($type == 'error')
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">
            Error
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        {{ $message }}
    </div>
@else
    <div class="modal-header">
        <h5 class="modal-title">View Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <em class="icon ni ni-cross"></em>
        </a>
    </div>
    <div class="modal-body">
        <div class="card-inner">
            <div class="nk-block">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Body</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Product Name</th>
                            <td>{{ $productDetails->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Category</th>
                            <td>{{ $productDetails->category_name->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Description</th>
                            <td>{!! $productDetails->description !!}</td>
                        </tr>
                        <tr>
                            <th scope="row">Stock</th>
                            <td>{{ $productDetails->stock_quantity }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Material</th>
                            <td>{{ $productDetails->material }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Size</th>
                            <td>{{ $productDetails->size }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Color</th>
                            <td>{{ $productDetails->color }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Price</th>
                            <td>{{ $productDetails->price }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Image</th>
                            <?php
                            $photo = asset('images/no-image.jpg');
                            if (!empty($productDetails->image)) {
                                $photo = asset('storage/product/' . $productDetails->image);
                            }
                            ?>
                            <td><img src="{{ $photo }}" height="100px" alt="Image">
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
