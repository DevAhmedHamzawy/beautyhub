@extends('admin.layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
@endsection

@section('title')
    {{ __('order.orders') }}
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">{{ __('dashboard.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('order.orders') }}</li>
                </ol>
            </nav>

            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="example" class="table key-buttons text-md-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('order.order_number') }}</th>
                                    <th>{{ __('order.email') }}</th>
                                    <th>{{ __('order.subtotal') }}</th>
                                    <th>{{ __('order.shipping_cost') }}</th>
                                    <th>{{ __('order.discount') }}</th>
                                    <th>{{ __('order.discount_type') }}</th>
                                    <th>{{ __('order.total') }}</th>
                                    <th>{{ __('order.status') }}</th>
                                    <th>{{ __('dashboard.actions') }}</th>
                                    <th>{{ __('dashboard.created') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->email }}</td>
                                        <td>{{ number_format($order->sub_total, 2) }}</td>
                                        <td>{{ number_format($order->shipping_cost, 2) }}</td>
                                        <td>{{ number_format($order->discount, 2) }}</td>
                                        <td>{{ $order->discount_type }}</td>
                                        <td>{{ number_format($order->total, 2) }}</td>

                                        <!-- Status Column -->
                                        <td>
                                            <span
                                                class="badge badge-{{ $order->status->color ?? 'secondary' }} order-status-badge">
                                                {{ $order->status->name ?? '-' }}
                                            </span>
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <a target="_blank" href="{{ route('admin.orders.show', $order->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a target="_blank" href="{{ route('admin.orders.invoice', $order->id) }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-file"></i>
                                            </a>

                                            <button class="btn btn-primary btn-sm edit-status-btn"
                                                data-id="{{ $order->id }}" data-status="{{ $order->status_id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>

                                        <td>{{ $order->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.orders.partials.edit')
@endsection


@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            $('#example').DataTable();

            // فتح المودال
            $(document).on('click', '.edit-status-btn', function() {

                let id = $(this).data('id');
                let status = $(this).data('status');

                $('#order_id').val(id);
                $('#order_status').val(status);

                $('#editStatusModal').modal('show');
            });

            // حفظ الحالة
            $('#saveStatusBtn').on('click', function() {

                let id = $('#order_id').val();
                let status_id = $('#order_status').val();

                $.ajax({
                    url: "{{ route('admin.orders.updateStatus') }}",
                    type: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        status_id: status_id
                    },
                    success: function(response) {

                        if (response.status) {

                            let row = $('button[data-id="' + id + '"]').closest('tr');
                            let badge = row.find('.order-status-badge');

                            badge
                                .text(response.status_name)
                                .removeClass()
                                .addClass('badge badge-' + response.status_class +
                                    ' order-status-badge');

                            $('#editStatusModal').modal('hide');

                            swal({
                                type: 'success',
                                title: "{{ __('order.updated_success') }}",
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 403) {
                            $('#editStatusModal').modal('hide');
                            swal({
                                type: 'error',
                                title: xhr.responseJSON.message ||
                                    'Cannot change this order',
                                showConfirmButton: true
                            });
                        }
                        console.log(xhr.responseText);
                    }
                });
            });

        });
    </script>
@endsection
