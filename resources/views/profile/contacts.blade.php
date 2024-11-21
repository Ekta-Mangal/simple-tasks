@extends('include.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
     <div class="card card-solid">
    <div class="card-body pb-0">
        <div class="row">
            @foreach($data as $user)
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                <div class="card bg-light d-flex flex-fill">
                    <div class="card-header text-muted border-bottom-0">
                        Digital Strategist
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-7">
                                <h2 class="lead"><b>{{ $user->name }}</b></h2>
                                <p class="text-muted text-sm"><b>About: </b> {{ $user->occupation ?? 'No occupation available' }} </p>
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    @if($user->contacts)
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: {{ $user->contacts->address ?? 'No address available' }}</li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: {{ $user->contacts->phone_number ?? 'No phone available' }}</li>
                                    @else
                                    <li class="small">No contact information available</li>
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
    <div class="card-footer">
        <nav aria-label="Contacts Page Navigation">
            <ul class="pagination justify-content-center m-0">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
            </ul>
        </nav>
    </div>
</div>

            </div>
        </div>
    </div>
@endsection
