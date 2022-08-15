@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">แก้ไข</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/member/edit') }}">
                        {{ csrf_field() }}

                        @include('common.messages')
					    @include('common.errors')

                        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">ID</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="id"  value="{{ $items->id ? $items->id : '' }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" required value="{{ $items->name ? $items->name : '' }}">

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" required value="{{ $items->email ? $items->email : '' }}">

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Phone Number</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="phone_number" value="{{ $items->phone_number ? $items->phone_number : '' }}">

                                @if ($errors->has('phone_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="password" value="">

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('team') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Team</label>
                            <div class="col-md-6">
                                <select class="form-control" name="team" required >
                                    <option value="" {{ $items->team=='ALL' ? 'selected' : '' }}>All Team</option>
                                    <option value="CC" {{ $items->team=='CC' ? 'selected' : '' }}>CC</option>
                                    <option value="DOL" {{ $items->team=='DOL' ? 'selected' : '' }}>DOL</option>
                                    <option value="SP" {{ $items->team=='SP' ? 'selected' : '' }}>SP</option>
                                    <option value="SA" {{ $items->team=='SA' ? 'selected' : '' }}>SA</option>
                                    <option value="NW" {{ $items->team=='NW' ? 'selected' : '' }}>NW</option>
                                    <option value="ST" {{ $items->team=='ST' ? 'selected' : '' }}>ST</option>
                                    <option value="SCS" {{ $items->team=='SCS' ? 'selected' : '' }}>Vender</option>
                                    <option value="OBS" {{ $items->team=='OBS' ? 'selected' : '' }}>OBS</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('code_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Code Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="code_name" value="{{ $items->code_name ? $items->code_name : '' }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('code_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">สถานะ</label>

                            <div class="col-md-6">
                                <select class="form-control" name="status" required >
                                    <option value="1" {{ $items->deleted_at == '' ? 'selected' : '' }}>ปกติ</option>
                                    <option value="0" {{ $items->deleted_at != '' ? 'selected' : '' }}>ยกเลิก</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection