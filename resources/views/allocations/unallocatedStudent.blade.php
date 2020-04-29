<div class="col-12">
    <h4 class="text-center">Unallocated Students</h4>
    <hr>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <tr>
                <th>Student Name</th>
                <th>Any Topics Selected?</th>
                <th>Any Proposals?</th>
            </tr>
            @forelse($unallocStudents as $student)
            <tr>
                <td><a href="mailto:{{$student->email}}">{{$student->firstName.' '.$student->lastName}}</a></td>
                <td>
                    @forelse ($student->choices as $choice)
                        @if($loop->first)
                            <ol style="margin:0;padding-left:20px">
                        @endif
                            <li>{{$choice->topic->name.' ('.$choice['topic']->supervisor->firstName.' '.$choice['topic']->supervisor->lastName.')'}}</li>
                        @if($loop->last)
                            </ol>
                        @endif
                    @empty
                        No Choices Selected
                    @endforelse
                </td>
                <td>
                    @forelse($student->proposalSent as $proposal)
                        @if($loop->first)
                            <ol style="margin:0;padding-left:20px">
                        @endif
                            <li>{{$proposal->name.' for '.$proposal->supervisor->firstName.' '.$proposal->supervisor->lastName}}</li>
                        @if($loop->last)
                            </ol>
                        @endif
                    @empty
                        No Proposals created.
                    @endforelse
                </td>
            </tr>
            @empty
                <tr><td colspan="4"><h3 class="text-center">There are currently no official topic allocations.</h3></td></th>
            @endforelse
        </table>
    </div>
</div>