@extends('layouts.admin-app')

@section('title', 'Admin | Subscription Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Subscription Data')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">Edit Subscription</h4>

        <form action="{{ route('admin.subscription.update', $subscription->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label>Transaction Id</label>
                <input type="text" name="transaction_id" class="form-control" value="{{ old('total_amount', $subscription->transaction_id) }}"   oninput="this.value = this.value.toUpperCase();"  required>
            </div>

            <div class="form-group mb-3">
                <label>Payment Status</label>
                <select name="payment_status" class="form-control" required>
                    <option value="1" {{ $subscription->payment_status == '1' ? 'selected' : '' }}>Success</option>
                    <option value="0" {{ $subscription->payment_status == '0' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>

            <!-- Add more fields as needed -->

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.get-subscription') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
