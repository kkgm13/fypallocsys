<div class="col-12">
    <hr>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <tr>
                <th>Topic Name</th>
                <th>Supervisor</th>
                <th>Select Student</th>
            </tr>
            @forelse($unallocTopics as $topic)
                <tr>
                    <td>{{$topic->name}}</td>
                    <td>{{$topic->supervisor->firstName.' '.$topic->supervisor->lastName}}</td>
                    <td><a class="btn btn-info btn-block mb-2" data-toggle="modal" data-target="#studentList">List of Students</a></td>
                </tr>
            @empty
            <tr><td colspan="4"><h3 class="text-center">There are currently no official topic allocations.</h3></td></th>
            @endforelse
        </table>
    </div>
</div>
<div class="modal fade" id="studentList" tabindex="-1" role="dialog" aria-labelledby="studentList" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalScrollableTitle">Unallocated Students</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('topics.allocate', $topic)}}" method="post" onsubmit="return confirm('By officially allocating this student, you, the module leader, are happy with having this student assigned to this topic and also the topic supervisor be their assigned personal tutor during the student\'s final year.')">
                    @csrf
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                    <table class="table table-borderless">
                        @forelse($unallocStudents as $student)
                        <tr scope="row">
                            <td>
                                <span class="font-weight-bold">{{$student->firstName.' '.$student->lastName}}</span><br><span class="pl-3">SUN ID: {{$student->sun}}</span>
                            </td>
                            <td>
                                <input type="hidden" name="user" id="user" value="{{$student}}">
                                <input class="mb-3 btn btn-success float-right" type="submit" value="Allocate">
                            </td>
                        </tr>
                        @empty
                            <td>
                                <h6>All students have been allocated</h6>
                            </td>
                        @endforelse
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>