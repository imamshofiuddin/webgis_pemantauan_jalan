@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="container">
    <a href="{{ route('user.add') }}"><button class="btn btn-success my-3">Tambah User Pemerintah</button></a>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <table class="table table-sm table-responsive-sm">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach($users as $key => $user)
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route('user.delete', $user) }}"><button class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus user ini ?')">Hapus</button></a>
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
