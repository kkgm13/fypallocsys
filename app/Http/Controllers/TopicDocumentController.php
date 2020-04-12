<?php

namespace App\Http\Controllers;

use Image;
use App\Topic;
use App\TopicDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TopicDocumentController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get RelatedTopic
        $topic = Topic::where('name', $request->name)->first();
        foreach ($request->file('topicDocuments') as $document) {
            $location = 'public/documents/'; //Create Location Document
            // If Directory doesnt exists, create directory
            if(! file_exists(storage_path('app/'.$location))){
                Storage::makeDirectory($location);
            }     
            // Create new Topic Document
            $tdoc = new TopicDocument();
            $tdoc->topicID = $topic->id;
            $tdoc->fileName = $document->getClientOriginalName();
            // Check File based on either file or image
            if(in_array($document->getClientOriginalExtension(), TopicDocument::approvedImageTypes())){
                // Update location path
                $location = storage_path('app/'.$location);
                
                // Get Image
                $image = Image::make($document);
                // Resize Image
                $image->resize(800,null,function($constraint){
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                // Save Image to location
                $image->save($location.$tdoc->fileName);
                echo PHP_EOL."Image File has been added to $location";
            } else {
                // Document-based Saving 
                $tdoc->fileName = $document->getClientOriginalName();
                // Place on system files
                Storage::disk('local')->put($location.$tdoc->fileName, "Context");
                echo PHP_EOL."Document File has been added to $location";
            }
            // Save
            $tdoc->save();
        }
        echo PHP_EOL."ALL File has been added to $location". PHP_EOL;
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
            Storage::delete($topicDocument->fileName);
        } else {
            return abort('403', "You are unauthorized");
        }
    }
}
