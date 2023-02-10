@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" type="text/css" href="/themes/cork/assets/css/tables/table-basic.css">
@endpush
@section('breadcrumb')
<ul class="navbar-nav flex-row">
    <li>
        <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><span>{{ __('Departemen') }}</span></li>
                    {{--
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>Breadcrumbs</span></li>
                     --}}
                </ol>
            </nav>
        </div>
    </li>
</ul>
@endsection

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
            <!-- Button trigger modal -->
            <div class="text-right">
                <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#createNew">
                    Buat Baru
                </button>
            </div>
            <form class="form-inline my-2 my-lg-0" method="GET">
                <div>
                    <input name="name" type="text" class="form-control product-search" id="input-search" placeholder="Cari Departemen..." @if(Request::filled('name')) value="{{ Request::input('name') }}" @endif required>
                </div>
            </form>
            <div class="my-4">
                @include('layouts._partials.alert')
            </div>
            <div class="modal fade" id="createNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Buat Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ action('DepartmentController@store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">Nama Departemen</label>
                                    <input name="name" type="text" class="form-control" id="name" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-dark">
                    <thead class="thead-dark|thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Departemen</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $company)
                            <tr>
                                <th scope="row">{{ $company->id }}</th>
                                <td>{{ $company->name }}</td>
                                <td>
                                    <ul class="table-controls">
                                        <li>
                                            <a href="javascript:void(0);" title="EDIT" data-toggle="modal" data-target="#edit{{ $company->id }}">
                                                <i class="fas fa-pencil"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" title="DELETE" data-toggle="modal" data-target="#delete{{ $company->id }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{
                $data->appends([
                    'name' => Request::filled('name') ? Request::input('name') : null
                ])->links()
            }}
        </div>
    </div>
</div>

@foreach ($data as $company)
    {{-- Edit Modal --}}
    <div class="modal fade" id="edit{{ $company->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ action('DepartmentController@update', ['id' => $company->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Departemen</label>
                            <input value="{{ $company->name }}" name="name" type="text" class="form-control" id="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Delete --}}
    <div class="modal fade" id="delete{{ $company->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">HAPUS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ action('DepartmentController@destroy', ['id' => $company->id]) }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Departemen</label>
                            <input value="{{ $company->name }}" name="name" type="text" class="form-control" id="name" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection