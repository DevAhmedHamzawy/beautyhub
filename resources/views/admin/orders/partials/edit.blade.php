<!-- Edit Status Modal -->
<div class="modal fade" id="editStatusModal" tabindex="-1" role="dialog" aria-labelledby="editStatusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">{{ __('order.edit_status') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="order_id">

                <div class="form-group">
                    <label>{{ __('order.status') }}</label>

                    <select id="order_status" class="form-control">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    {{ __('dashboard.close') }}
                </button>

                <button type="button" class="btn btn-success" id="saveStatusBtn">
                    {{ __('dashboard.edit') }}
                </button>
            </div>

        </div>
    </div>
</div>
