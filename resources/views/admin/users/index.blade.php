@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <h2>Users</h2>

                {{ $users->links() }}

                <table class="table table-stripped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>E-mail</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                    </thead>

                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->role_id }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                    </tr>
                    @endforeach
                </table>

                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
