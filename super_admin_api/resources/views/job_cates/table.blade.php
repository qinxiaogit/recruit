<div class="table-responsive">
    <table class="table" id="jobCates-table">
        <thead>
        <tr>
            
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($jobCates as $jobCate)
            <tr>
                
                <td width="120">
                    {!! Form::open(['route' => ['jobCates.destroy', $jobCate->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('jobCates.show', [$jobCate->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('jobCates.edit', [$jobCate->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
