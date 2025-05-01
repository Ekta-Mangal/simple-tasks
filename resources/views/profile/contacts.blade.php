@extends('include.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="card card-solid">
                    <div class="card-body pb-0">
                        <div class="row">
                            @foreach ($data as $user)
                                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                    <div class="card bg-light d-flex flex-fill">
                                        <div class="card-header text-muted border-bottom-0">
                                            <strong>{{ $user->role }}</strong>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h2 class="lead"><b>{{ $user->name }}</b></h2>
                                                    <p class="text-muted">
                                                        <i class="fas fa-envelope"></i>
                                                        {{ $user->email ?? 'No Email ID available' }}
                                                    </p>
                                                    <ul class="fa-ul text-muted">
                                                        @if ($user->contact)
                                                            <li class="small">
                                                                <span class="fa-li"><i class="fas fa-building"></i></span>
                                                                Address: {{ $user->contact->address1 ?? 'N/A' }},
                                                                {{ $user->contact->address2 ?? 'N/A' }}
                                                            </li>
                                                            <li class="small">
                                                                <span class="fa-li"><i class="fas fa-phone"></i></span>
                                                                Phone: {{ $user->contact->phone ?? 'N/A' }}
                                                            </li>
                                                            <li class="small">
                                                                <span class="fa-li"><i class="fas fa-flag"></i></span>
                                                                Country: {{ $user->contact->country->name ?? 'N/A' }}
                                                            </li>
                                                            <li class="small">
                                                                <span class="fa-li"><i
                                                                        class="fas fa-map-marker-alt"></i></span>
                                                                Postcode: {{ $user->contact->postcode ?? 'N/A' }}
                                                            </li>
                                                        @else
                                                            <li class="small text-danger">No contact information available
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
