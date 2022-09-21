@extends('layouts.dashboard')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <select class="custom-select col-md-2" id="role">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ Str::ucfirst($role->name) }}</option>
                @endforeach
            </select>
            <button type="button" id="save" class="btn btn-warning ml-3">Save</button>
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
                            <th>Menu</th>
                            @foreach ($authorizationTypes as $type)
                                <th class="text-center">{{ Str::ucfirst($type->name) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                            <tr class='single-menu'>
                                <td>{{ Str::ucfirst($menu->name) }}</td>
                                @foreach ($authorizationTypes as $type)
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $type->id }}"
                                                id="defaultCheck1" @if ($authorizations->where('menu_id', $menu->id)->where('authorization_type_id', $type->id)->first()->has_access) checked @endif>
                                        </div>
                                    </td>
                                @endforeach
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

    <script src="{{ asset('/js/authorization/index.js') }}"></script>
@endsection
