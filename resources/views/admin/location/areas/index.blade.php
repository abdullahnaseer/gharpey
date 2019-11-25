@extends('admin.layouts.app', ['page_title' => "Areas of " . $city->name . ", " . $state->name . ", " . $country->name, "back_url" => route('admin.location.countries.states.cities.index', [$country->id, $state->id])])

@section('breadcrumb')
    <a href="{{ route('admin.home') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">Admin</a>
    <a href="{{route('admin.location.countries.index')}}" class="breadcrumb-item">Countries</a>
    <a href="{{route('admin.location.countries.states.index', [$country->id])}}" class="breadcrumb-item">States</a>
    <a href="{{route('admin.location.countries.states.cities.index', [$country->id, $state->id])}}" class="breadcrumb-item">Cities</a>
    <span class="breadcrumb-item active">Areas</span>
@endsection

@section('breadcrumb-elements')
    <a href="#createModal" data-toggle="modal" data-target="#createModal" class="breadcrumb-elements-item">
        <i class="icon-add mr-1"></i>
        Create New
    </a>
@endsection

@section('content')
    <table class="table table-bordered dt-responsive nowrap">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($records as $record)
            <tr>
                <td>{{$record->id}}</td>
                <td>{{$record->name}}</td>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-id="{{$record->id}}" data-data="{{$record->toJson()}}">
                        Edit
                    </button>

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{$record->id}}">
                        Delete
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $records->links() }}
@stop

@push('modals')
    @include('admin.location.areas.modals.create', ['country' => $country, 'state' => $state, 'city' => $city])
    @include('admin.location.areas.modals.edit', ['country' => $country, 'state' => $state, 'city' => $city])
    @include('admin.location.areas.modals.delete', ['country' => $country, 'state' => $state, 'city' => $city])
@endpush

@push('styles')

@endpush

@push('scripts')
    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.modal-footer form').attr('action', "{{url('admin/location/countries/' . $country->id . '/states/' . $state->id . '/cities/' . $city->id . '/areas')}}/" + id );
        });

        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var data = button.data('data'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('form').attr('action', "{{url('admin/location/countries/' . $country->id . '/states/' . $state->id . '/cities/' . $city->id . '/areas')}}/" + id );
            modal.find('form input#name').val(data.name);
        });
    </script>
@endpush
