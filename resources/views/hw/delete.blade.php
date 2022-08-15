@extends('layouts.app')

@section('hw_active')
active
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong>Hardware<small> - delete</small></strong></div>

                <div class="panel-body">
                    <a class="btn btn-default" href="{{ url('/hw/edit?id='.$items->id) }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>

                    <p>&nbsp;</p>

                    <p class="text-danger">Confirm delete?
                    <p>
                    <form action="{{ url('/hw/'.$items->id.'?id='.$items->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div>
                            <label class="control-label">สำนักงานที่ดิน : </label>{{ $items->departments }}
                        </div>
                        <div>
                            <label class="control-label">Product : </label>{{ $items->product }}
                        </div>
                        <div>
                            <label class="control-label">Model / Part Number : </label>{{ $items->model_part_number }}
                        </div>
                        <div>
                            <label class="control-label">Serial Number : </label>{{ $items->serial_number }}
                        </div>
                        <div>
                            <label class="control-label">เลขครุภัณฑ์ : </label>{{ $items->inventory_no }}
                        </div>

                        <button type="submit" id="delete-job-{{ $items->id }}" class="btn btn-danger">Delete</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection