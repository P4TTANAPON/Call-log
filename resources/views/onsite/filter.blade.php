<form class="form-inline" role="form" action="{{url('/onsite')}}" method="get">
    <label><strong>ตัวกรอง</strong></label> -
    
    <div class="form-group">
        <select class="form-control" id="project" name="project" style="width: 150px;" onchange="loadSystem(this); loadDepartment(this)">
            <option value="">All Project</option>
            <option value="1" {{ Request::get('project') == '1' ? 'selected' : '' }}>DOL 1</option>
            <option value="2" {{ Request::get('project') == '2' ? 'selected' : '' }}>DOL 2</option>
            {{--<option value="3">DOL 3</option>--}}
            <option value="4" {{ Request::get('project') == '4' ? 'selected' : '' }}>DOL 4 </option>
        </select>
    </div>

    <div class="form-group">
        <select class="form-control" id="department" name="department" style="width: 300px;">
            <option value="">All Department</option>
            @foreach ($departments as $department)
            <option value="{{ $department->id }}" {{ Request::get('department') == $department->id ? 'selected' : '' }}>[DOL{{ $department->phase }}] {{ $department->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <select class="form-control" id="close" name="close" style="width: 150px;" onchange="loadSystem(this); loadDepartment(this)">
            <option value="">All Status</option>
            <option value="active" {{ Request::get('close') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="closed" {{ Request::get('close') == 'closed' ? 'selected' : '' }}>Closed</option>
        </select>
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn btn-default">Filter</button>
        <a href="{{url('/onsite')}}" class="btn btn-default">Reset</a>
    </div>
</form>

<script>

$(function() {
    $('#department').selectize();
});
function loadSystem(e)
{
    $.ajax({
        method: 'GET',
        url: '{{ url("/system/getdropdown") }}',
        data: { 'phase': $(e).val(), 'system': '{{ Request::get("system") }}' },
        cache: false
    }).done(function( html ) {
        $('#system').html( html )
    });
}
function loadDepartment(e)
{
    $.ajax({
        method: 'GET',
        url: '{{ url("/department/getdropdown") }}',
        data: { 'phase': $(e).val(), 'department': '{{ Request::get("department") }}' },
        cache: false
    }).done(function( html ) {
        $('#department').selectize()[0].selectize.destroy();
        $('#department').html( html );
        $('#department').selectize();
    });
}
</script>