@extends('layouts.admin')

@push('link')

<!-- bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<!-- toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />


@endpush

@section('content')
<div class="content-wrapper m">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Peminjaman</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Data Peminjaman</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
  <div class="container">
        <a href="/peminjaman/add" type="button" class="btn btn-success">Tambah +</a>
        <!-- search -->
          <div class="row g-3 align-items-center mt-2">
            <div class="col-auto">
              <label for="search" class="col-form-label">Search</label>
            </div>
            <div class="col-auto">
            <form action="#" method="GET">
                <input type="search" id="search" name="search" class="form-control" aria-describedby="passwordHelpInline">
            </form>
            </div>
          </div>
        <!-- table data -->
          <div class="row mt-2">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Peminjam</th>
                  <th scope="col">Nama Alat</th>
                  <th scope="col">Stock</th>
                  <th scope="col">Deskripsi</th>
                  <th scope="col">No Hp</th>
                  <th scope="col">Tgl Peminjaman</th>
                  <th scope="col">Tgl Pengembalian</th>
                  <th scope="col">Status</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
              <!-- @php
                $no = 1;
              @endphp -->
              @foreach ($data as $index => $row)
                <tr>
                  <th scope="row">{{ $index + $data->firstItem() }}</th>
                  <td>{{ $row -> peminjam }}</td>
                  <td>{{ $row -> nama }}</td>
                  <td>{{ $row -> qty }}</td>
                  <td>{{ $row -> deskripsi }}</td>
                  <td>0{{ $row -> notelepon }}</td>
                  
                  <td>{{ date('d-M-Y', strtotime($row -> created_at )) }}</td>
                  @if($row->tgl_dikembalikan == "" || $row->tgl_dikembalikan == null )
                  <td >-</td>
                  @else
                  <td>{{ date('d-M-Y', strtotime($row -> tgl_dikembalikan )) }}</td>
                  @endif
                  <td>
                        @if ($row->status == "Belum Dikembalikan")
                            <a href="ubah-status/{{$row->id}}" class="btn btn-danger btn-icon-split btn-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text">Belum Dikembalikan</span>
                            </a>
                        @else
                            <a href="{{route('peminjaman')}}" class="btn btn-success btn-icon-split btn-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text">Sudah Dikembalikan</span>
                            </a>
                        @endif
                      </td>
                  <td>
                      <a href="/peminjaman/{{$row -> id}}"  class="btn btn-success">Edit</a>
                      <a href="#" class="btn btn-danger delete" data-id="{{$row -> id}}" data-nama="{{ $row -> peminjam }}">Delete</a>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
            {{ $data->links() }}
          </div>
  </div>
  
</div>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<!-- sweetalert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.1.slim.js" integrity="sha256-tXm+sa1uzsbFnbXt8GJqsgi2Tw+m4BLGDof6eUPjbtk=" crossorigin="anonymous"></script> -->
<!-- toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>
    $('.delete').click(function(){
      var idpinjam = $(this).attr('data-id');
      var namaalat = $(this).attr('data-peminjam');


      swal({
        title: "Yakin?",
        text: "Kamu akan menghapus Data ini? ",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          window.location = "/delete-pinjam/"+idpinjam+" "
          swal("Data berhasil di hapus", {
            icon: "success",
          });
        } else {
          swal("Data tidak jadi di hapus");
        }
      });  
    });
  </script>

  <script>
    @if (Session::has('success'))
    toastr.success(" {{ Session::get('success')}} ")
    @endif
    @if (Session::has('error'))
    toastr.error(" {{ Session::get('error')}} ")
    @endif
  </script>
  

@endsection