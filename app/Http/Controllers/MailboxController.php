<?php

namespace App\Http\Controllers;

use App\DataTables\MailboxDataTable;

use Illuminate\Http\Request;

use App\Services\EmailService;

use App\Models\Mail;

use App\Models\Patient;

use App\Http\Requests\EmailRequest;

use Auth;

use Flash;

class MailboxController extends Controller
{

    private $emailService;

    public function __construct(EmailService $emailServ)
    {
        $this->emailService = $emailServ;
    }
    /**
     * Display a listing of emails.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(MailboxDataTable $mailboxDataTable)
    {   
        $user = Auth::user();

        $mailboxDataTable = $mailboxDataTable->with('user_id', $user->id);
        
        return $mailboxDataTable->render('mailbox.index');
        //return view('mailbox.mailbox');
    }

    public function create(Request $request){

        $email = null;
        
        if($request->has('email')){
            $email = $request->get('email');
        }
        
        return view('mailbox.create')->with('to', $email);
    }

    public function show($id){

        $email = Mail::find($id);

        //dd($email);

        if (empty($email)) {
            //Flash::error('Email no encontrado');

            return redirect(route('mailbox.index'));
        }
        
        return view('mailbox.read')->with('email', $email);
    }

    public function sendEmail(EmailRequest $request){
        //dd($request->all());
        $user = Auth::user();
        
        $this->emailService->sendEmailAndSave($request->all(), $user->id);

        return redirect()->route('mailbox.index');
    }
    /**
     * Remove the specified Mail from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $mail = Mail::find($id);

        if (empty($mail)) {
            return redirect(route('mailbox.index'));
        }

        $mail->delete();

        Flash::success('El email fue eliminado correctamente');

        return redirect(route('mailbox.index'));
    }
}
