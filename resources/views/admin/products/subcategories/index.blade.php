@extends('admin.layouts.dashboard', ['page_title' => "Product SubCategories for " . $category->name])

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Products</span>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('admin.products.categories.index') }}" class="kt-subheader__breadcrumbs-link">Categories</a>
    @foreach($parent_categories as $parent_category)
        <span class="kt-subheader__breadcrumbs-separator"></span>
        @if (!$loop->last)
            <a href="{{ route('admin.products.categories.subcategories.index', $parent_category->id) }}"
               class="kt-subheader__breadcrumbs-link">{{$parent_category->name}}</a>
        @else
            <span class="kt-subheader__breadcrumbs-link active">{{$parent_category->name}}</span>
        @endif
    @endforeach
@endsection

@section('breadcrumb-elements')
    <div class="kt-input-icon kt-input-icon--left">
        <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
        <span class="kt-input-icon__icon kt-input-icon__icon--left">
            <span><i class="la la-search"></i></span>
        </span>
    </div>
@endsection

@push('styles')

@endpush

@section('content')
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-line-chart"></i>
										</span>
                <h3 class="kt-portlet__head-title">
                    Sub Categories for {{$category->name}}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a class="btn btn-brand btn-elevate btn-icon-sm" href="#createModal" data-toggle="modal"
                           data-target="#createModal">
                            <i class="la la-plus"></i>
                            New SubCategory
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <!--begin: Datatable -->
            <div class="kt-datatable" id="json_data"></div>
            <!--end: Datatable -->
        </div>
    </div>
@stop

@push('modals')
    @include('admin.products.subcategories.modals.create', ['category' => $category])
    @include('admin.products.subcategories.modals.edit', ['category' => $category])
    @include('admin.products.subcategories.modals.delete', ['category' => $category])
@endpush

@push('scripts')
    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.modal-footer form').attr('action', "{{url('admin/products/categories/'.$category->id.'/subcategories')}}/" + id);
        });

        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('form').attr('action', "{{url('admin/products/categories/'.$category->id.'/subcategories')}}/" + id);
            modal.find('form input#name').val(button.data('name'));
        });

        var KTDatatableJsonRemote = function () {
            var jsonResource = function () {
                var datatable = $('.kt-datatable').KTDatatable({
                    // datasource definition
                    data: {
                        type: 'remote',
                        source: {
                            read: {
                                url: '{{route('admin.products.categories.subcategories.json', $category->id)}}',
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                                }
                            }
                        },
                        pageSize: 10,
                    },

                    // layout definition
                    layout: {
                        scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                        footer: false // display/hide footer
                    },

                    // column sorting
                    sortable: true,

                    pagination: true,

                    search: {
                        input: $('#generalSearch')
                    },

                    // columns definition
                    columns: [
                        {
                            field: 'id',
                            title: '#',
                            width: 20,
                            type: 'number',
                            textAlign: 'center',
                        }, {
                            field: 'featured_image',
                            title: 'Image',
                            sortable: false,
                            width: 100,
                            template: function (row) {
                                return '\
                                <img class="img-thumbnail" src="' + (row.featured_image ? row.featured_image.replace('public', '/storage') : '') + '">\
                                ';
                            }
                        }, {
                            field: 'name',
                            title: 'Name',
                        }, {
                            field: 'slug',
                            title: 'Slug',
                        }, {
                            field: 'Actions',
                            title: 'Actions',
                            sortable: false,
                            width: 200,
                            autoHide: false,
                            overflow: 'visible',
                            template: function (row) {
                                return '\
                        <a href="{{url('/admin/products/categories/')}}/' + row.id + '/subcategories" class="btn btn-sm btn-outline-primary' + (row.depth >= 2 ? ' d-none' : '') + '" title="SubCategories">\
                            SubCategories\
						</a>\
						<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details" data-toggle="modal" data-target="#editModal" data-id="' + row.id + '" data-name="' + row.name + '" data-description="' + row.description + '"data-category="' + row.category_id + '">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete" data-toggle="modal" data-target="#deleteModal" data-id="' + row.id + '">\
							<i class="la la-trash"></i>\
						</a>\
					';
                            },
                        }],

                });

                $('#kt_form_status').on('change', function () {
                    datatable.search($(this).val().toLowerCase(), 'Status');
                });

                $('#kt_form_type').on('change', function () {
                    datatable.search($(this).val().toLowerCase(), 'Type');
                });

                $('#kt_form_status,#kt_form_type').selectpicker();

            };

            return {
                // public functions
                init: function () {
                    jsonResource();
                }
            };
        }();

        jQuery(document).ready(function () {
            KTDatatableJsonRemote.init();
        });
    </script>
@endpush
