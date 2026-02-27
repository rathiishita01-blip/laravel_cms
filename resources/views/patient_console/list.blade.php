@extends('layout.console')

@section('content')

<section class="w3-padding">
    <h2>Patient Submissions</h2>

    <div style="overflow-x:auto;">
    <table class="w3-table w3-striped w3-margin-top">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Date</th>
                <th>UHID</th>
                <th>Adhaar</th>
                <th>Name</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Visit/Follow up</th>
                <th>Address</th>
                <th>Diagnosis</th>
                <th>Investigation</th>
                <th>Medicines</th>
                <th>H/O TB & Other Investigations</th>
                <th>TB Gold</th>
                <th>Montoux Test</th>
                <th>CBC + ESR</th>
                <th>X-ray / CECT / HRCT</th>
                <th>Gene Xpert / DNA-PCR / Sputum / CBNAAT / TRUNAAT</th>
                <th>USG / W/A / CT Scan</th>
                <th>CD4 & CD8</th>
                <th>IgE</th>
                <th>Vit-D</th>
                <th>LFT</th>
                <th>RFT</th>
                <th>IL-2</th>
                <th>Contact Details</th>
                <th>LTBI QS 10</th>
                <th>LTBI QS 09</th>
                <th>Refer</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $index => $patient)
            <tr>
                <td>{{ $patient->id }}</td>
                <td>{{ $patient->date }}</td>
                <td>{{ $patient->uhid_no }}</td>
                <td>{{ $patient->adhaar_no }}</td>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->age }}</td>
                <td>{{ $patient->sex }}</td>
                <td>{{ $patient->visit_follow_up }}</td>
                <td>{{ $patient->address }}</td>
                <td>{{ $patient->diagnosis }}</td>
                <td>{{ $patient->investigation }}</td>
                <td>{{ $patient->medicines }}</td>
                <td>{{ $patient->h_o_tb_other_investigations }}</td>
                <td>{{ $patient->tb_gold }}</td>
                <td>{{ $patient->montoux_test }}</td>
                <td>{{ $patient->cbc_esr }}</td>
                <td>{{ $patient->xray_cect_hrct }}</td>
                <td>{{ $patient->gene_xpert }}</td>
                <td>{{ $patient->usg_wa_ct_scan }}</td>
                <td>{{ $patient->cd4_cd8 }}</td>
                <td>{{ $patient->ige }}</td>
                <td>{{ $patient->vit_d }}</td>
                <td>{{ $patient->lft }}</td>
                <td>{{ $patient->rft }}</td>
                <td>{{ $patient->il2 }}</td>
                <td>{{ $patient->contact_details }}</td>
                <td>{{ $patient->ltbi_qs_10 }}</td>
                <td>{{ $patient->ltbi_qs_09 }}</td>
                <td>{{ $patient->refer }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    <div style="display: flex; justify-content: center; gap: 5px; margin-top: 20px;">
    {{ $patients->links() }}
</div>
</section>

@endsection