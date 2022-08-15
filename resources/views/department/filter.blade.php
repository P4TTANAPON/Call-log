<form class="form-inline" role="form" action="{{url('/department')}}" method="get">
    <label><strong>ตัวกรอง</strong></label> -
    <div class="form-group" id="date-from">
        {{-- <label for="from">ตั้งแต่</label> --}}
        <input class="form-control" type="text" id="from" name="fromDate" placeholder="From date" value="{{$start}}" onfocus="(this.type='date')" onblur="(this.type='text')" />
    </div>
    
    <div class="form-group" id="date-to">
        <label for="from">ถึง</label>
        <input class="form-control" type="text" id="to" name="toDate" placeholder="To date" value="{{$end}}" onfocus="(this.type='date')" onblur="(this.type='text')" />
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn btn-default">Filter</button>
        <a href="{{url('/department')}}" class="btn btn-default">Reset</a>
    </div>
</form>