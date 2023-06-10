<div class="table-responsive">
    <table class="table" id="jobs-table">
        <thead>
        <tr>
            
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($jobs as $jobs)
            <tr>
                
                <td width="120">
                    {!! Form::open(['route' => ['jobs.destroy', $jobs->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('jobs.show', [$jobs->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('jobs.edit', [$jobs->id]) }}"
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
