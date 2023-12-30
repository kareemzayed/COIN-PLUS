<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['pageTitle'] = "الدعم الفني";
        $data['tickets'] = Ticket::whereUserId(Auth::user()->id)->with('ticketReplies')->paginate();
        $data['tickets_pending'] = Ticket::whereUserId(Auth::user()->id)->whereStatus('2')->count();
        $data['tickets_answered'] = Ticket::whereUserId(Auth::user()->id)->whereStatus('3')->count();
        $data['tickets_closed'] = Ticket::whereUserId(Auth::user()->id)->whereStatus('1')->count();
        $data['tickets_all'] = Ticket::whereUserId(Auth::user()->id)->count();

        return view(template() . 'user.ticket.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageTitle'] = "إنشاء تذكرة";

        return view(template() . 'user.ticket.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'message' => 'required',
        ], [
            'subject.required' => 'حقل الموضوع مطلوب.',
            'message.required' => 'حقل الرسالة مطلوب.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $ticket = new Ticket();
        $ticket->support_id = '#' . rand(1000, 9999);
        $ticket->user_id =  Auth::user()->id;
        $ticket->subject = $request->subject;
        $ticket->status = 2;
        $ticket->save();

        $reply = new TicketReply();
        $reply->ticket_id = $ticket->id;
        $reply->message = $request->message;

        if ($request->has('file')) {
            $image = uploadImage($request->file, filePath('Ticket', true));
            $reply->file = $image;
        }

        $reply->save();

        return redirect()->route('user.ticket.index')->with('success', 'تم إنشاء التذكرة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['pageTitle'] = "مناقشة تذكرة الدعم";
        $data['ticket'] = Ticket::find($id);
        $data['tickets'] =  $data['tickets'] = Ticket::whereUserId(Auth::user()->id)->with('ticketReplies')->get();
        $data['ticket_reply'] = TicketReply::whereTicketId($data['ticket']->id)->latest()->get();

        return view(template() . 'user.ticket.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['pageTitle'] = "تعديل تذكرة الدعم";
        $data['ticket'] = Ticket::find($id);

        $data['ticket_reply'] = TicketReply::whereTicketId($data['ticket']->id)->first();

        return view(template() . 'user.ticket.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
        ], [
            'subject.required' => 'حقل الموضوع مطلوب.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $ticket = Ticket::find($id);
        $ticket->support_id = $ticket->support_id;
        $ticket->user_id =  Auth::user()->id;
        $ticket->subject = $request->subject;
        $ticket->status = 2;
        $ticket->save();

        return redirect()->route('user.ticket.index')->with('success', 'تم تحديث التذكرة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            $all_reply = TicketReply::whereTicketId($id)->get();
            if (count($all_reply) > 0) {
                foreach ($all_reply as $reply) {
                    $item = TicketReply::find($reply->id);
                    if ($item->file) {
                        removeFile(filePath('Ticket') . '/' . $reply->file);
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
        $ticket = Ticket::findOrFail($request->ticket_id);
        $ticket->status = 2;
        $ticket->save();

        $reply = new TicketReply();
        $reply->ticket_id = $ticket->id;
        $reply->message = $request->message;

        if ($request->has('file')) {
            $image = uploadImage($request->file, filePath('Ticket', true));
            $reply->file = $image;
        }

        $reply->save();

        return redirect()->back()->with('success', 'تم إنشاء الرد بنجاح');
    }

    public function statusChange($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket->status == 1) {
            return redirect()->route('user.ticket.index')->with('error', 'تم إغلاق هذه التذكرة بالفعل');
        }
        $ticket->status = 1;
        $ticket->save();

        return redirect()->route('user.ticket.index')->with('success', 'تم إغلاق المحادثة بنجاح');
    }

    public function ticketStatus(Request $request)
    {
        $ticketStatus = [
            'answered' => 3,
            'pending' => 2,
            'closed' => 1
        ];

        $data['pageTitle'] = $request->status == 'open' ? 'تذكرة دعم مفتوحة' : 'تذكرة دعم مغلقة';

        $data['tickets'] = Ticket::whereUserId(Auth::user()->id)->whereStatus($ticketStatus[$request->status])->with('ticketReplies')->paginate();

        $data['tickets_pending'] = Ticket::whereUserId(Auth::user()->id)->whereStatus('2')->count();
        $data['tickets_answered'] = Ticket::whereUserId(Auth::user()->id)->whereStatus('3')->count();
        $data['tickets_closed'] = Ticket::whereUserId(Auth::user()->id)->whereStatus('1')->count();
        $data['tickets_all'] = Ticket::whereUserId(Auth::user()->id)->count();
        return view(template() . 'user.ticket.list')->with($data);
    }

    public function ticketDownload($id)
    {
        $ticket = TicketReply::findOrFail($id);

        if ($ticket->file) {
            $file = 'asset/images/Ticket/' . $ticket->file;
            if (file_exists($file)) {
                return response()->download($file);
            }
        }
    }
}
