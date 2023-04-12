@extends('layouts.app')

@section('content-frontend')
<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <div class="card mt-3">
                <div class="card-header">
                    Discount
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12 d-flex flex-row-reverse">
                            <a href="{{ route('admin.discount.create') }}" class="btn btn-primary btn-sm"> Add Discount</a>
                        </div>
                    </div>
                    @include('components.alert')

                    {{-- table --}}
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Precentage</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($discounts as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td><span class="badge bg-primary">{{ $item->code }}</span></td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->precentage }} %</td>
                                    <td>
                                        <a href="{{ route('admin.discount.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                                        
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.discount.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
    