<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:reply_contact'])->only(['reply']);
    }

     public function index(Request $request)
    {
        if ($request->ajax()) {
            $contacts = Contact::all();

            return response()->json([
                'data' => $contacts->map(function ($contact) {

                    $actions = '';

                    if(auth()->user()->can('reply_contact')) {
                        $actions .= '<button class="btn btn-sm btn-info reply-btn"
                                data-id="'.$contact->id.'"
                                data-email="'.$contact->email.'"
                                data-name="'.$contact->name.'"
                                data-toggle="modal"
                                data-target="#replyModal">
                                    '.trans("contact.reply").'
                                </button>';
                    }

                    return [
                        'id' => $contact->id,
                        'name' => $contact->name,
                        'email' => $contact->email,
                        'subject' => $contact->subject,
                        'message' => $contact->message,
                        'created_at' => $contact->created_at->diffForHumans(),
                        'actions' => $actions,
                    ];
                }),
                'recordsTotal' => $contacts->count(),
                'recordsFiltered' => $contacts->count(),
            ]);
        }

        return view('admin.contacts.index');
    }

    public function reply(Request $request)
    {
        $contact = Contact::findOrFail($request->contact_id);

        Mail::raw($request->reply, function ($message) use ($contact) {
            $message->to($contact->email)
                ->subject(trans('contact.reply_to_your_question'));
        });

        return back()->with('success', trans('contact.reply_success'));
    }
}
