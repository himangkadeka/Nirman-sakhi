@extends('layouts.admin-app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Edit Data</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.dataupdate.updateApp') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Worker ID</label>
                                <input type="text" name="worker_id" class="form-control" value="{{ $data->worker_id }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">Status</label>
                                <input type="text" name="status" class="form-control" value="{{ $data->application_status }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">ack_no</label>
                                <input type="text" name="district" class="form-control" value="{{ $data->ack_no }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">sender_role_id</label>
                                <input type="text" name="sender_role_id" class="form-control" value="{{ $data->sender_role_id}}">
                            </div>
                            <div class="form-group">
                                <label for="name">sender_user_id</label>
                                <input type="text" name="sender_user_id" class="form-control" value="{{ $data->sender_user_id }}">
                            </div>
                            <div class="form-group">
                                <label for="name">sender_office_id</label>
                                <input type="text" name="sender_office_id" class="form-control" value="{{ $data->sender_office_id }}">
                            </div>
                            <div class="form-group">
                                <label for="name">application_from_user</label>
                                <input type="text" name="application_from_user" class="form-control" value="{{ $data->application_from_user }}">
                            </div>
                            <div class="form-group">
                                <label for="name">application_receiver_user_id</label>
                                <input type="text" name="application_receiver_user_id" class="form-control" value="{{ $data->application_receiver_user_id }}">
                            </div>
                            <div class="form-group">
                                <label for="name">Application sender user Id</label>
                                <input type="text" name="application_sender_user_id" class="form-control" value="{{ $data->application_sender_user_id }}">
                            </div>
                            <div class="form-group">
                                <label for="name">application_receiver_role_id</label>
                                <input type="text" name="application_receiver_role_id" class="form-control" value="{{ $data->application_receiver_role_id }}">
                            </div>

                            <div class="form-group">
                                <label for="name">Remarks</label>
                                <input type="text" name="already_registered" class="form-control" value="{{ $data->remarks }}" readonly>
                            </div>


                            <div class="form-group">
                                <label for="name">Updated AT</label>
                                <input type="text" name="already_registered" class="form-control" value="{{ $data->updated_at }}" readonly>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Data</button>
                        </form>

                    </div>
@endsection
