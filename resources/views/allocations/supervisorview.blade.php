<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
        <tr>
            <th>Student Name</th>
            <th>Topic Name</th>
            <th>Allocation Type</th>
        </tr>
        @forelse($allocations as $allocation)
            <tr>
                <td>{{$allocation->student->firstName.' '.$allocation->student->lastName}}</td>
                <td>{{is_null($allocation->proposal)? $allocation->topic->name : $allocation->proposal->name }}</td>
                <td>{{is_null($allocation->topic) ? "Proposal" : "Topic" }}</td>
            </tr>
        @empty
            <tr><td colspan="3"><h3 class="text-center">There are currently no official topic allocations.</h3></td></th>
        @endforelse
    </table>
</div>