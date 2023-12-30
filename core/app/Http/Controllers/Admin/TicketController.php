<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('module:9')->only(['index', 'show', 'pendingList']);
        $this->middleware('module:10')->only('destroy');
        $this->middleware('module:40')->only('reply');
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = "قائمة التذاكر";
        $data['navTicketActiveClass'] = "active";
        $data['ticketList'] = "active";

        $search['support_id'] = $request->support_id;
        $search['status'] = $request->status;
        $search['date'] = $request->date;

        $data['tickets'] = Ticket::with('ticketReplies')
            ->when($search['support_id'], function ($item) use ($search) {
                $item->where('support_id', 'LIKE', '%' . $search['support_id'] . '%');
            })
            ->when($search['status'], function ($item) use ($search) {
                $item->where('status', $search['status']);
            })
            ->when($search['date'], function ($item) use ($search) {
                $item->whereDate('created_at', $search['date']);
            })
            ->latest()->paginate();

        return view('backend.ticket.list', compact('search'))->with($data);
    }

    public function pendingList(Request $request)
    {
        $data['pageTitle'] = "Pending Ticket";
        $data['navTicketActiveClass'] = "active";
        $data['pendingTicket'] = "active";
        $data['tickets'] = Ticket::whereStatus(2)->when($request->search, function ($item) use ($request) {
            $item->where('support_id', 'LIKE', '%' . $request->search . '%');
        })->latest()->paginate();

        return view('backend.ticket.pending_list')->with($data);
    }

    public function show($id)
    {
        $data['pageTitle'] = "مناقشة تذكرة الدعم الفني";
        $data['navTicketActiveClass'] = "active";
        $data['ticket'] = Ticket::find($id);
        $data['ticket_reply'] = TicketReply::whereTicketId($data['ticket']->id)->latest()->get();

        return view('backend.ticket.show')->with($data);
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            $all_reply = TicketReply::whereTicketId($id)->get();
            if (count($all_reply) > 0) {
                foreach ($all_reply as $reply) {
                    $item = TicketReply::find($reply->id);
                    if ($item->file) {
                        removeFile(filePath('Ticket', true) . $reply->file);
                    }
                    $item->delete();
                }
            }
            $ticket->delete();
        }

        return redirect()->back()->with('success', 'تم حذف التذكرة بنجاح');
    }

    public function reply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $reply = new TicketReply();
        $reply->ticket_id = $request->ticket_id;
        $reply->admin_id = Auth::guard('admin')->user()->id;
        $reply->message = $request->message;

        if ($request->has('image')) {
            $image = uploadImage($request->image, filePath('Ticket', true));
            $reply->file = $image;
        }

        $reply->save();
        Ticket::findOrFail($request->ticket_id)->update(['status' => 3]);
        return redirect()->back()->with('success', 'تم الرد بنجاح');
    }
}