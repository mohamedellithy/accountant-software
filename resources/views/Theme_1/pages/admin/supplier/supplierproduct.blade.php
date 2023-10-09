@extends('layouts.master')
@section('content')
    <!-- Content -->
    <div class="container-fluid">

        <h4 class="fw-bold py-3 mb-4"></h4>
        <!-- Basic Layout -->

        <div class="row">

            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">بيانات المورد
                    </div>
                    <div class="card-body">

                        <div class="mb-3 d-flex">
                            <label class="form-label" for="basic-default-fullname">اسم المورد :</label>
                            <p>{{ $supplierproducts->name }}</p>

                        </div>
                        <div class="mb-3 d-flex">
                            <label class="form-label" for="basic-default-fullname">رقم المورد :</label>
                            <p>{{ $supplierproducts->phone }}</p>

                        </div>
                        </form>
                    </div>
                </div>
            </div>



            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">الاصناف                  </div>




                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($supplierproducts->products as $supplierproduct)
                                    <tr>
                                        <td>{{ $supplierproduct->name }}</td>
                                        <td>{{ $supplierproduct->quantity }}</td>
                                        <td>{{ $supplierproduct->price }}</td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                    <hr>
                </div>

            </div>
        </div>

    </div>

    </div>
    <!-- / Content -->
@endsection
