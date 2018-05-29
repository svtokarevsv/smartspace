document.addEventListener('DOMContentLoaded', function (e) {
    getCityByCountryId(null);
    $('#country').change(function (e) {
        var countryId = $(this).val();
        getCityByCountryId(countryId);
    });

    function getCityByCountryId(countryId){
        var output = "<option value=''>- Please select your job city -</option>";
        $.getJSON(ROOT_URI + "geo/ajax_getCitiesByCountryId", { countryId }, function (data) {
            $.each(data['cities'], function(index, value) {
                output += "<option value='" + value.id + "'>" + value.city + "</option>";
            });
            $("#city").html(output);
        })
    }
});