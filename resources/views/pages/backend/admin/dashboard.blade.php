@extends('layouts.app')

@section('content-frontend')
    <div class="container">
        <div class="row mt-5">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header">
                        My Camps
                    </div>
                    <div class="card-body">
                        @include('components.alert')
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Camp</th>
                                    <th>Price</th>
                                    <th>Registerd Date</th>
                                    <th>Paid Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($checkouts as $item)
                                    <tr>
                                        <td>{{ $item->User->name }}</td>
                                        <td>{{ $item->Camp->title }}</td>
                                        <td>{{ $item->Camp->price }}</td>
                                        <td>{{ $item->created_at->format('M d Y') }}</td>
                                        <td>
                                            @if ($item->status_paid)
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-warning">Waiting Payment</span>
                                            @endif    
                                        </td>
                                        <td>
                                            @if (!$item->status_paid)
                                                <form action="{{ route('admin.admin-checkout-update', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-primary btn-sm">Set Paid</button>
                                                </form>
                                            @else
                                            <img src="{{ asset('assets/frontend/images/ic_check.svg') }}" alt="">
                                            Payment Success   
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No Camps Registered</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection