@extends('layouts.admin')

@push('link')

<!-- bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

@endpush

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Data Alat</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Data</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
            <p style="">
            <a href="/alat" class="btn btn-primary">Kembali</a>
            </p>
                <div class="card">
                    <div class="card-body">
                        <!-- @if(Request::segment(1) == 'edit')
                        tampilin form/tampilin 
                        @endif -->
                        <form action="/edit/{{ Request::segment(2) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Alat</label>
                                <input type="text" name="nama" value="{{ $data -> nama }}" class="form-control" id="nama">
                            </div>
                            <div class="mb-3">
                                <label for="qty" class="form-label">Jumlah</label>
                                <input type="number" name="qty" value="{{ $data -> qty }}" class="form-control" id="qty">
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <input type="text" name="deskripsi" value="{{ $data -> deskripsi }}" class="form-control" id="deskripsi">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

@endsection