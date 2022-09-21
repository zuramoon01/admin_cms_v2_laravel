@extends('layouts.dashboard')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            <a href="{{ url(request()->path() . '/create') }}" id="save" class="btn btn-primary ml-3">Create</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <colgroup>
                        @foreach ($colSizes as $size)
                            <col class="col-md-{{ $size }}">
                        @endforeach
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            @foreach ($titles as $title)
                                <th>{{ Str::ucfirst($title) }}</th>
                            @endforeach
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productCategories as $productCategory)
                            <tr class='single-menu'>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $productCategory->category }}</td>
                                <td>{{ $productCategory->description }}</td>
                                <td class="text-center">
                                    <div class="d-flex">
                                        <a href="{{ url(request()->path() . "/$productCategory->id") }}"
                                            class="btn btn-warning btn-circle btn-sm mr-1">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <button data-url="{{ url(request()->path() . "/$productCategory->id") }}"
                                            class="btn btn-danger btn-circle btn-sm ml-1" onclick="deleteItem(this)">
                                            <i class="fab fa-facebook-f"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        const deleteItem = (e) => {
            const productCategory = e.parentElement.parentElement.parentElement;
            const url = {
                ...e.dataset
            }.url;

            axios
                .delete(url)
                .then(res => {
                    if (res.data === 'success') productCategory.remove()
                })
                .catch(err => console.log(err))
        }
    </script>
@endsection
