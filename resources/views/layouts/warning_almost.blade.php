
@if ($cAlmostIn > 0 || $cAlmostEnd > 0)
    <div class="alert alert-warning alert-dismissible show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        @if($cAlmostIn > 0) มี Calllog (OnSite) ที่ใกล้จะครบกำหนดเข้าทำการภายใน 24 ชั่วโมง จำนวน {{$cAlmostIn}} งาน<br /> @endif
        @if($cAlmostEnd > 0) มี Calllog (OnSite) ที่ใกล้จะครบกำหนดการแก้ไขปัญหาภายใน 48 ชั่วโมง จำนวน {{$cAlmostEnd}} งาน<br /> @endif
        <p class="text-right"><a href="{{url('/onsite_al')}}">ดูรายละอียดเพิ่มเติม >>></a></p>
    </div>
@endif