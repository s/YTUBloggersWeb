@extends('layouts.master')

@section('content')

    <div class="starter-template">
        <h3>YTU Blogger Network Api Documentation</h3>        
    </div>
    
    <div class="form-horizontal col-md-8 col-md-offset-2 well">
        <p class="italic">
            Example query:
        </p>
        http://{{$api_host}}/get?client_id={YOUR_CLIENT_ID}&client_token={YOUR_CLIENT_TOKEN}&limit=1&offset=5
        <p class="italic">
            Example response:
        </p>
        <pre>
{
    "data":[
        {
            "id":"754",
            "user_id":"9",
            "post_url":"http:\/\/feedproxy.google.com\/~r\/saidozcan\/~3\/eu4tTk2Myu8\/working-life-vs-studentship",
            "post_content":"Everyone has been a student in their life. Probably most of us got into the working life after the collage. But some people started working earlier. I’m one of them. \n\nAbout three and a half years ago, I started to college, which is Yildiz Technical University in Istanbul. And at the same time, I started to go a company which is located in same campus with the college. My purpose was to learn something about how things are going in working life. <\/p>\n\nAt the beginning, I was assuming that it might be hard to accomplish. Because I was inexperienced, there were a lot of things",
            "post_created_at":"2014-01-14 19:27:43",
            "blog_title":"Said \u00d6zcan",
            "post_title":"Working Life versus Studentship"
        }
    ],
    "status":1
}
        </pre>
        <p class="italic">
            Parameters:
        </p>
        <table>
            <tr>
                <td>client_id:</td><td> Your client id when you specify registering. (required)</td>
            </tr>
            <tr>
                <td>client_token:</td><td> Your client token given by system when you registered. (required)</td>
            </tr>
            <tr>
                <td>limit:</td><td> Limits the size of the returning data. Max 50 data will be returned at once. (required)</td>
            </tr>
            <tr>
                <td>offset:</td><td> You can set offset with this parameter. (optional)</td>
            </tr>
        </table>
    </div>
    
@stop