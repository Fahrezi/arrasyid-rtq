@extends('layout.app')

@section('content')
  <div class="text-center">
    <h1>Welcome to Arrasyid Donation Platform</h1>
    <p>Your support can make a difference. Join us in our mission to help those in need.</p>
    <a href="{{ route('donations.index') }}" class="btn btn-primary btn-lg">View Donations</a>
  </div>
@endsection