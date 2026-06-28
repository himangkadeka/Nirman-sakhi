@extends('layouts.admin-app')

@section('title', 'Admin | Edit Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Edit Application Data')

@section('style')
    <style>
        * { box-sizing: border-box; }

        .form-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #dee2e6;
        }
        .form-page-title { font-size: 13px; font-weight: 500; color: #212529; }
        .form-page-sub   { font-size: 10.5px; color: #6c757d; margin-top: 1px; }

        .edit-section { margin-bottom: 16px; }
        .edit-section-label {
            font-size: 10px;
            font-weight: 500;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding-bottom: 5px;
            border-bottom: 0.5px solid #e9ecef;
            margin-bottom: 8px;
        }

        .field-grid-2 { display: grid; grid-template-columns: 1fr 1fr;     gap: 8px 16px; }
        .field-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px 16px; }

        .field-group { display: flex; flex-direction: column; gap: 3px; }
        .field-group label {
            font-size: 10.5px;
            font-weight: 500;
            color: #6c757d;
        }
        .field-group label .ro-hint {
            font-size: 9px;
            color: #adb5bd;
            font-weight: 400;
        }
        .field-group .form-control {
            font-size: 11px;
            padding: 5px 8px;
            height: 28px;
            border: 0.5px solid #ced4da;
            border-radius: 3px;
            color: #212529;
            background: #fff;
        }
        .field-group .form-control:focus {
            border-color: #185FA5;
            box-shadow: 0 0 0 2px rgba(24,95,165,0.12);
            outline: none;
        }
        .field-group .form-control[readonly] {
            background: #f1f3f5;
            color: #6c757d;
            cursor: not-allowed;
            border-color: #e9ecef;
        }

        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 14px;
            padding-top: 10px;
            border-top: 0.5px solid #dee2e6;
        }
        .readonly-note { font-size: 10px; color: #6c757d; }

        .btn-gov-primary {
            font-size: 11px;
            padding: 5px 16px;
            border: 0.5px solid #B5D4F4;
            border-radius: 3px;
            background: #E6F1FB;
            color: #185FA5;
            font-weight: 500;
            cursor: pointer;
        }
        .btn-gov-primary:hover { background: #B5D4F4; }

        .btn-gov-secondary {
            font-size: 11px;
            padding: 5px 12px;
            border: 0.5px solid #ced4da;
            border-radius: 3px;
            background: #f8f9fa;
            color: #495057;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-gov-secondary:hover { background: #e9ecef; }

        .badge-readonly {
            font-size: 10px;
            padding: 2px 7px;
            border-radius: 2px;
            background: #FAEEDA;
            color: #854F0B;
            border: 0.5px solid #FAC775;
            font-weight: 500;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <form action="{{ route('admin.dataupdate.update') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $data->id }}">

            <div class="form-page-header">
                <div>
                    <div class="form-page-title">Edit Application Data</div>
                    <div class="form-page-sub">Update worker application record</div>
                </div>
                <span class="badge-readonly">Editable fields only</span>
            </div>

            {{-- Read-only info --}}
            <div class="edit-section">
                <div class="edit-section-label">Read-only info</div>
                <div class="field-grid-3">
                    <div class="field-group">
                        <label>Phone Number <span class="ro-hint">(read-only)</span></label>
                        <input type="text" name="phone_no" class="form-control"
                               value="{{ $data->phone_no }}" readonly>
                    </div>
                    <div class="field-group">
                        <label>Worker ID <span class="ro-hint">(read-only)</span></label>
                        <input type="text" name="worker_id" class="form-control"
                               value="{{ $data->worker_id }}" readonly>
                    </div>
                    <div class="field-group">
                        <label>Status <span class="ro-hint">(read-only)</span></label>
                        <input type="text" name="status" class="form-control"
                               value="{{ $data->status }}" readonly>
                    </div>
                    <div class="field-group">
                        <label>District ID <span class="ro-hint">(read-only)</span></label>
                        <input type="text" name="district" class="form-control"
                               value="{{ $data->district }}" readonly>
                    </div>
                    <div class="field-group">
                        <label>Already Registered <span class="ro-hint">(read-only)</span></label>
                        <input type="text" name="already_registered" class="form-control"
                               value="{{ $data->already_registered }}" readonly>
                    </div>
                </div>
            </div>

            {{-- Office & routing --}}
            <div class="edit-section">
                <div class="edit-section-label">Office &amp; routing</div>
                <div class="field-grid-3">
                    <div class="field-group">
                        <label>Office ID</label>
                        <input type="text" name="office_id" class="form-control"
                               value="{{ $data->office_id }}">
                    </div>
                    <div class="field-group">
                        <label>DA Forward</label>
                        <input type="text" name="da_forward" class="form-control"
                               value="{{ $data->da_forward }}">
                    </div>
                    <div class="field-group">
                        <label>Pull Back</label>
                        <input type="text" name="pull_back" class="form-control"
                               value="{{ $data->pull_back }}">
                    </div>
                    <div class="field-group">
                        <label>Application Receiver ID</label>
                        <input type="text" name="application_receiver_user_id" class="form-control"
                               value="{{ $data->application_receiver_user_id }}">
                    </div>
                    <div class="field-group">
                        <label>Application Sender ID</label>
                        <input type="text" name="application_sender_user_id" class="form-control"
                               value="{{ $data->application_sender_user_id }}">
                    </div>
                    <div class="field-group">
                        <label>Active Status</label>
                        <input type="text" name="active_status" class="form-control"
                               value="{{ $data->active_status }}">
                    </div>
                </div>
            </div>

            {{-- Payment & dates --}}
            <div class="edit-section">
                <div class="edit-section-label">Payment &amp; dates</div>
                <div class="field-grid-3">
                    <div class="field-group">
                        <label>Payment Status</label>
                        <input type="text" name="payment_status" class="form-control"
                               value="{{ $data->payment_status }}">
                    </div>
                    <div class="field-group">
                        <label>Subscription Validity Date</label>
                        <input type="text" name="subscription_validity_date" class="form-control"
                               value="{{ $data->subscription_validity_date }}" placeholder="DD-MM-YYYY">
                    </div>
                    <div class="field-group">
                        <label>Last Registration Date</label>
                        <input type="text" name="last_registration_date" class="form-control"
                               value="{{ $data->last_registration_date }}" placeholder="DD-MM-YYYY">
                    </div>
                    <div class="field-group">
                        <label>ID Card Expiry Date</label>
                        <input type="text" name="id_card_expiry_date" class="form-control"
                               value="{{ $data->id_card_expiry_date }}" placeholder="DD-MM-YYYY">
                    </div>
                    <div class="field-group">
                        <label>Renewal Date</label>
                        <input type="text" name="renewal_date" class="form-control"
                               value="{{ $data->renewal_date }}" placeholder="DD-MM-YYYY">
                    </div>
                    <div class="field-group">
                        <label>Date of Retirement</label>
                        <input type="text" name="date_of_retirement" class="form-control"
                               value="{{ $data->date_of_retirement }}" placeholder="DD-MM-YYYY">
                    </div>
                </div>
            </div>

            {{-- Audit info --}}
            <div class="edit-section">
                <div class="edit-section-label">Audit info</div>
                <div class="field-grid-2">
                    <div class="field-group">
                        <label>Created At <span class="ro-hint">(read-only)</span></label>
                        <input type="text" class="form-control"
                               value="{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i:s') }}" readonly>
                    </div>
                    <div class="field-group">
                        <label>Updated At <span class="ro-hint">(read-only)</span></label>
                        <input type="text" class="form-control"
                               value="{{ \Carbon\Carbon::parse($data->updated_at)->format('d-m-Y H:i:s') }}" readonly>
                    </div>
                </div>
            </div>

            <div class="form-footer">
            <span class="readonly-note">
                <i class="fa fa-info-circle" style="margin-right:3px"></i>
                Grey fields are read-only and cannot be edited
            </span>
                <div style="display:flex;gap:6px">
                    <a href="{{ route('admin.dataupdate.index') }}" class="btn-gov-secondary">Cancel</a>
                    <button type="submit" class="btn-gov-primary">
                        <i class="fa fa-check" style="margin-right:3px;font-size:10px"></i>Update Data
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection