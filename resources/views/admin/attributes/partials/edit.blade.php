<!-- Modal: تعديل ضريبة -->
<div class="modal fade" id="editAttributeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editAttributeForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('attribute.update_attribute') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ trans('attribute.name') }}</label>
                        <input type="text" name="name" class="form-control" />
                        <span class="text-danger error-name-edit"></span>
                    </div>
                    <!-- لا تعرض active في التعديل -->
                </div>
                <div class="modal-footer px-3 py-2">
                    <button type="submit" class="btn btn-primary w-50 me-2 rounded-0">
                        {{ trans('dashboard.edit') }}
                    </button>
                    <button type="button" class="btn btn-secondary w-50 rounded-0" data-dismiss="modal">
                        {{ trans('dashboard.close') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
