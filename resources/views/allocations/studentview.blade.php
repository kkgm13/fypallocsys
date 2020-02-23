<div class="container">
    <div class="jumbotron px-3">
        <h5 class="text-center">Congratulations, you are allocated with the following:</h5>
        <h2 class="text-center">
            @if(!is_null($allocation->topic))
                {{$allocation->topic->name}}
            @elseif(!is_null($allocation->proposal))
                {{$allocation->proposal->name}}
            @endif
        </h2>

        <div class="text-center py-2">
            @if(!is_null($allocation->proposal))
                <a href="{{route('proposals.show', $allocation->proposal)}}" class="btn btn-secondary">Proposal Details</a>
            @else
                <a href="{{route('topics.show', $allocation->topic)}}" class="btn btn-secondary">Topic Details</a>
            @endif
        </div>
        
    </div>
</div>