<div class="col">
    <hr>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Supervisor Name</th>
                    <th>Topic Name</th>
                    <th>Allocation Type</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allocation as $alloc)
                    <tr>
                        <td>{{$alloc->student->firstName.' '.$alloc->student->lastName}}</td>
                        <td>{{$alloc->supervisor->firstName.' '.$alloc->supervisor->lastName}}</td>
                        <td>{{is_null($alloc->proposal)? $alloc->topic->name : $alloc->proposal->name }}</td>
                        <td>{{is_null($alloc->topic) ? "Proposal" : "Topic" }}</td>
                    </tr>
                @empty
                <tr><td colspan="4"><h3 class="text-center">There are currently no official topic allocations.</h3></td></th>
                @endforelse
            </tbody>
        </table>
    </div>
</div>