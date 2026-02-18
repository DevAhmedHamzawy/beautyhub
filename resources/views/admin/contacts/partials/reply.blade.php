<div class="modal fade" id="replyModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.contacts.reply') }}">
            @csrf

            <input type="hidden" name="contact_id" id="contact_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('contact.reply') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>{{ trans('contact.email') }}</label>
                        <input type="text" class="form-control" id="contact_email" readonly>
                    </div>

                    <div class="form-group">
                        <label>{{ trans('contact.message') }}</label>
                        <textarea name="reply" class="form-control" rows="5" required></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">{{ trans('contact.send') }}</button>
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('dashboard.close') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
