function getMinMaxCalendarTime(){
    return $.ajax({
        url: '/api/config/calendar/minMaxTime',
        type: "GET",
        data: {
            api_token : localStorage.getItem('api_token')
        }
    });
}