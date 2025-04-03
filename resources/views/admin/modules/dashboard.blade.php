@extends('admin.layouts.main')
@section('page')
<div class="col-md-10 content">
    <div class="row">
        <div class="col-md-4">
            <div class="stats-card shadow">
                <div>
                    <h6>Total Orders</h6>
                    <h2>80</h2>
                </div>
                <div class="icon">
                    <img alt="Logo" class="img-fluid" src="images/listing-icon.png" />
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card shadow">
                <div>
                    <h6>Sold Today</h6>
                    <h2>17</h2>
                </div>
                <div class="icon">
                    <img alt="Logo" class="img-fluid" src="images/meeting-request-icon.png" />
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card shadow">
                <div>
                    <h6>User Count</h6>
                    <h2>8</h2>
                </div>
                <div class="icon">
                    <img alt="Logo" class="img-fluid" src="images/firm-listing-icon.png" />
                </div>
            </div>
        </div>
    </div>
    <!-- DASHBOARD STATS CARD END HERE -->
@endsection
