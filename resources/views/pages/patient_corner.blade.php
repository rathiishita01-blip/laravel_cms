@extends('layout.frontend')

@section('content')

<section class="page-header">
    <div class="container">
        <h1>Patient Data Form</h1>
    </div>
</section>

<section class="contactsection">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('patients.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        {{-- Basic Details --}}
                        <div class="col-md-4 mb-3">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" 
                                value="{{ old('date', date('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>UHID No.</label>
                            <input type="text" name="uhid_no" class="form-control" value="{{ old('uhid_no') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Adhaar No.</label>
                            <input type="text" name="adhaar_no" class="form-control" value="{{ old('adhaar_no') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Age</label>
                            <input type="number" name="age" class="form-control" value="{{ old('age') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Sex</label>
                            <select name="sex" class="form-control">
                                <option value="">Select</option>
                                <option value="Male" {{ old('sex')=='Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('sex')=='Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('sex')=='Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Visit / Follow up</label>
                            <input type="text" name="visit_follow_up" class="form-control" value="{{ old('visit_follow_up') }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                        </div>

                        {{-- Additional Fields --}}
                        @php
                            $fields = [
                                'diagnosis', 'investigation', 'medicines', 'h_o_tb_other_investigations', 'tb_gold',
                                'montoux_test', 'cbc_esr', 'xray_cect_hrct', 'gene_xpert', 'usg_wa_ct_scan',
                                'cd4_cd8', 'ige', 'vit_d', 'lft', 'rft', 'il2', 'contact_details',
                                'ltbi_qs_10', 'ltbi_qs_09', 'refer'
                            ];
                        @endphp

                        @foreach($fields as $field)
                        <div class="col-md-6 mb-3">
                            <label>{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                            <input type="text" name="{{ $field }}" class="form-control" value="{{ old($field) }}">
                        </div>
                        @endforeach

                        <div class="col-md-12 mb-3">
                            <button type="submit" class="primary-btn">Submit Patient Data</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

@endsection