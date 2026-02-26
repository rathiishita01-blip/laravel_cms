@extends('layout.console')

@section('content')

<section class="w3-padding">

    <h2>Contacts Submission</h2>

    <table class="w3-table w3-striped w3-margin-top">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->full_name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->message }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</section>

@endsection