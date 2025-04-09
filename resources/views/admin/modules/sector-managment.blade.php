@extends('admin.layouts.main')
@section('page')
<div class="col-md-10 content">
    <div class="row">
        <div class="col-md-4">
            <a href="{{route('get-addnewsectorpage')}}">
                <div class="stats-card panes shadow">
                    <div class="row">
                        <div class="col-10 col-lg-10 col-md-10">
                            <h6>Add New Sector</h6>
                        </div>
                        <div class="col-2 col-lg-2 col-md-2 d-flex justify-content-center align-items-center">
                            <img alt="Logo" width="30" src="{{asset('icons/add.png')}}" />
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-12 content">
        <div class="row pt-5">
            <div class="container holder p-5 py-5 shadow" style="background-color: #fff;">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h1 class="heading-black-small text-center pb-3">Delivery Sectors</h1>
                @foreach ($sectors as $sector)
                    <div class="row pt-4 pb-4 border-bottom align-items-center">
                        {{-- Sector Name --}}
                        <div class="col-12 col-md-6 text-center text-md-start mb-3 mb-md-0">
                            <h1 class="heading-black-smaller pt-3">{{ $sector->sector_name }}</h1>
                        </div>

                        {{-- Delivery Charges + Actions --}}
                        <div class="col-12 col-md-6 text-md-start mb-3 mb-md-0">
                            <div class="d-md-flex align-items-end gap-3">
                                {{-- Update Form --}}
                                <form action="{{ route('update-sector', $sector->id) }}" method="POST" class="mb-3 mb-md-0 d-flex flex-column">
                                    @csrf
                                    @method('PUT')
                                    <label for="delivery_charges_{{ $sector->id }}" class="form-label fw-bold">Delivery Charges</label>
                                    <div class="d-flex gap-2">
                                        <input type="number" name="delivery_charges" id="delivery_charges_{{ $sector->id }}" value="{{ $sector->delivery_charges }}" class="form-control" placeholder="Delivery Charges" required>
                                        <button type="submit" class="btn btn-main">Update</button>
                                    </div>
                                </form>

                                {{-- Delete Form --}}
                                <form action="{{route('delete-sector',$sector->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this sector?');" class="d-flex flex-column justify-end">
                                    @csrf
                                    @method('DELETE')
                                    <label class="form-label fw-bold invisible">Delete</label>
                                    <button type="submit" class="btn btn-main mt-auto">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
