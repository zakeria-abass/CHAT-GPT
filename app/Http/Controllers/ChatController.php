<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $messages =collect((session('messages',[])))->reject(fn ($message) => $message['role'] === 'system');
        return view('chat',compact('messages'));
    }


    public  function store(Request $request){

        $messages=$request->session()->get('messages',[
            ['role'=>'system','content' => 'You are LaravelGpt - C ChartGPT Clone. Answer as concisely as possible.']
        ]);
        $messages[]=['role'=>'user','content'=> $request->input('message')];

        $response =OpenAI::chat()->create([
            'model'=>'gpt-3.5-turbo',
            'messages'=>$messages
        ]);
        $messages[]=['role'=>'assistant','content'=> $response->choices[0]->message->content];
        $request->session()->put('messages',$messages);

        return back();
    }


    public  function rest(Request $request){

        $request->session()->forget('messages');
        return back();

    }
}
