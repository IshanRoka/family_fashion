@extends('backend.layouts.main')

@section('title')
    Dashboard
@endsection

@section('styles')
    <style>
        .sales-card {
            margin: 10px;
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            transition: all 0.3s ease;
            /* background: linear-gradient(to bottom right, #ffffff, #f0f0f0); */
        }

        .sales-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #505050;
        }

        .card-text {
            font-size: 1.2rem;
            color: #666;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 15px;
        }

        .card-text strong {
            color: #5050509e;
            font-size: 1.5rem;
        }

        .card-icon {
            font-size: 2rem;
            color: #08c;
            margin-bottom: 15px;
        }

        .total-sales {
            /* background: linear-gradient(to bottom right, #ddd1ff, #3ed38d); */
            color: #007bff;
        }

        .year-sales {
            /* background: linear-gradient(to bottom right, #cdfff3, #b58e1a); */
            color: #ffc107;
        }

        .month-sales {
            /* background: linear-gradient(to bottom right, #edf664, #1976d2); */
            color: #28a745;
        }

        .daily-sales {
            /* background: linear-gradient(to bottom right, #f2cccf, #d455b7); */
            color: #dc3545;
        }

        .destination {
            /* background: linear-gradient(to bottom right, #fbfde1, #6f268a); */
            color: #007bff;
        }

        .package {
            /* background: linear-gradient(to bottom right, #cdd7ff, #b5341a); */
            color: #ffc107;
        }

        .trekking {
            /* background: linear-gradient(to bottom right, #f69f64, #19d2cc); */
            color: #28a745;
        }

        .activity {
            /* background: linear-gradient(to bottom right, #f1ccf2, #66d455); */
            color: #dc3545;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .table-striped tbody tr:hover {
            background-color: #f1f1f1;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.5rem 0.8rem;
            border-radius: 0.5rem;
            font-weight: bold;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #c2940a;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .text-gradient {
            font-weight: 700;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(45deg, #7f7b7a, #3e349a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('main-content')
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            {{-- <h4 class="mb-0">Welcome To Dashboard {{ Auth::user()->name }}</h4> --}}
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Starts:: Row 1 -->
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="sales-card year-sales">
                <div class="card-body">
                    <i class="fas fa-address-book card-icon"></i>
                    <!-- <i class="fas fa-calendar-alt card-icon"></i> -->
                    <h5 class="card-title">Contacted Us</h5>
                    <p class="card-text"><span style="flex-grow: 1;"></span><strong>
                            {{ !empty($contactsCount) ? $contactsCount : '0' }} </strong></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Ends:: Row 1 -->

    <!-- Starts:: Row 2 -->
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="sales-card daily-sales">
                <div class="card-body">
                    <!-- <i class="fa-solid fa-earth-americas  card-icon"></i> -->
                    <i class="fa-regular fa-newspaper card-icon"></i>
                    <h5 class="card-title">News & Blogs</h5>
                    <p class="card-text"><span style="flex-grow: 1;"></span><strong>
                            {{ !empty($newsAndBlogsCount) ? $newsAndBlogsCount : '0' }} </strong></p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="sales-card daily-sales">
                <div class="card-body">
                    <i class="fa-solid fa-users-line card-icon"></i>
                    <h5 class="card-title">Our Team</h5>
                    <p class="card-text"><span style="flex-grow: 1;"></span><strong>
                            {{ !empty($teamMembersCount) ? $teamMembersCount : '0' }} </strong></p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="sales-card daily-sales">
                <div class="card-body">
                    <i class="fa-regular fa-images card-icon"></i>
                    <h5 class="card-title">Gallery</h5>
                    <p class="card-text"><span style="flex-grow: 1;"></span><strong>
                            {{ !empty($galleryCount) ? $galleryCount : '0' }} </strong></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Ends:: Row 2 -->
@endsection
