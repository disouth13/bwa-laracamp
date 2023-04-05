@extends('layouts.app')

@section('content-frontend')
    
<section class="dashboard my-5">
    <div class="container">
        <div class="row text-left">
            <div class=" col-lg-12 col-12 header-wrap mt-4">
                <p class="story">
                    DASHBOARD
                </p>
                <h2 class="primary-header ">
                    My Bootcamps
                </h2>
            </div>
        </div>
        <div class="row my-5">
            @include('components.alert')
            <table class="table">
                <tbody>
                    @forelse ($checkouts as $item)
                    <tr class="align-middle">
                        <td width="18%">
                            <img src="{{ asset('assets/frontend/images/item_bootcamp.png') }}" height="120" alt="">
                        </td>
                        <td>
                            <p class="mb-2">
                                <strong>{{ $item->Camp->title }}</strong>
                            </p>
                            <p>
                                {{ $item->created_at->format('d M, y') }}
                            </p>
                        </td>
                        <td>
                            <p class="mt-2"></p>
                            <strong>{{ $item->Camp->price }}k</strong>
                        </td>
                        <td>
                            @if ($item->status_paid)
                                <p class="mt-2"></p>
                                <strong class="text-success">Payment Success</strong>
                            @else
                                <p class="mt-2"></p>
                                <strong>Waiting Payment</strong>
                            @endif
                            
                        </td>
                        <td>
                            <a href="https://wa.me/08xxxxxxx?text=Hi, saya ingin bertanya tentang kelas {{ $item->Camp->title }}" class="btn btn-primary">
                                Contact Support
                            </a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <h3>No Data</h3>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection