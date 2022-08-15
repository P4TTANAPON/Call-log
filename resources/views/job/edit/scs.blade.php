<div class="panel panel-default">
    <div class="panel-heading">Vender</div>
    <div class="panel-body">

        <div class="form-group">
            <label class="col-md-3 control-label">การดำเนินการแก้ไข</label>
            <div class="col-md-9">
                <textarea required class="form-control" id="scs_action" name="scs_action" placeholder="Require">{{ $job->scsjob ? $job->scsjob->action : '' }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">เวลาที่เริ่มแก้ไข</label>
            <div class="col-md-9">
                <input required class="form-control" id="scs_start_dtm" name="scs_start_dtm" type="datetime-local" value="{{ $job->scsjob ? ($job->scsjob->start_dtm ? date('Y-m-d\TH:i', strtotime($job->scsjob->start_dtm)) : '') : '' }}" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">เวลาที่แก้ไขเสร็จ</label>
            <div class="col-md-9">
                <input required class="form-control" id="scs_action_dtm" name="scs_action_dtm" type="datetime-local" value="{{ $job->scsjob ? ($job->scsjob->action_dtm ? date('Y-m-d\TH:i', strtotime($job->scsjob->action_dtm)) : '') : '' }}" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">ผู้ดำเนินการ</label>
            <div class="col-md-9">
                <input class="form-control" id="operator_name" name="operator_name" type="text" value="{{ $job->scsjob ? $job->scsjob->operator_name : '' }}" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">สาเหตุ</label>
            <div class="col-md-9">
                <textarea class="form-control" id="scs_cause" name="scs_cause">{{ $job->scsjob ? $job->scsjob->cause : '' }}</textarea>
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-3 control-label">หมายเหตุ</label>
            <div class="col-md-9">
                <textarea class="form-control" id="scs_remark" name="scs_remark">{{ $job->scsjob ? $job->scsjob->remark : '' }}</textarea>
            </div>
        </div>

    </div>
</div>