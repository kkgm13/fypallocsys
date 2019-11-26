<?php

namespace App\Http\Controllers;

use App\TopicDocument;
use Illuminate\Http\Request;

class TopicDocumentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role != "Student"){
            
        } else {
            return abort('403', "You are unauthorized");
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TopicDocument  $topicDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TopicDocument $topicDocument)
    {
        if(Auth::user()->role != "Student"){

        } else {
            return abort('403', "You are unauthorized");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TopicDocument  $topicDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(TopicDocument $topicDocument)
    {
        if(Auth::user()->role != "Student"){

        } else {
            return abort('403', "You are unauthorized");
        }
    }
}
