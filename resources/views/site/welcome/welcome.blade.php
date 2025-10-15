@extends('site.layouts.app')

@section('title', 'beauty hub')

@section('content')
    @include('site.welcome.partials.slider')

    @include('site.welcome.partials.ads_top')

    @include('site.welcome.partials.categories')

    @include('site.welcome.partials.brands')

    @include('site.welcome.partials.new_arrivals')

    @if ($flash_sale->count() > 0)
        @include('site.welcome.partials.flash_sale')
    @endif
@endsection


@section('footer')
    <script>
        function CountDown(lastDate) {
            const selectDay = document.getElementById("day");
            const selectHour = document.getElementById("hour");
            const selectMinute = document.getElementById("minute");
            const selectSecound = document.getElementById("second");
            if (selectDay && selectHour && selectMinute && selectSecound) {
                let showDate = "";
                let showHour = "";
                let showMinute = "";
                let showSecound = "";
                const provideDate = new Date(lastDate);
                const year = provideDate.getFullYear();
                const month = provideDate.getMonth();
                const date = provideDate.getDate();
                const hours = provideDate.getHours();
                const minutes = provideDate.getMinutes();
                const seconds = provideDate.getSeconds();
                const _seconds = 1000;
                const _minutes = _seconds * 60;
                const _hours = _minutes * 60;
                const _date = _hours * 24;
                const timer = setInterval(() => {
                    const now = new Date();
                    const distance =
                        new Date(year, month, date, hours, minutes, seconds).getTime() -
                        now.getTime();
                    if (distance < 0) {
                        clearInterval(timer);
                        return;
                    }
                    showDate = Math.floor(distance / _date);
                    showMinute = Math.floor((distance % _hours) / _minutes);
                    showHour = Math.floor((distance % _date) / _hours);
                    showSecound = Math.floor((distance % _minutes) / _seconds);
                    selectDay.innerText = showDate < 10 ? `0${showDate}` : showDate;
                    selectHour.innerText = showHour < 10 ? `0${showHour}` : showHour;
                    selectMinute.innerText =
                        showMinute < 10 ? `0${showMinute}` : showMinute;
                    selectSecound.innerText =
                        showSecound < 10 ? `0${showSecound}` : showSecound;
                }, 1000);
            }
        }
        CountDown("{{ $flash_sale->end_time ?? '' }}");
    </script>
@endsection
