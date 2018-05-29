document.addEventListener('DOMContentLoaded', function (e) {

    $('#form__country').change(function (e) {
        var countryId = $(this).val();
        getCityByCountryId(countryId);
    });

    function getCityByCountryId(countryId) {
        var output = "";
        $.getJSON(ROOT_URI + "geo/ajax_getCitiesByCountryId", {countryId}, function (data) {
            $.each(data["cities"], function (index, value) {
                output += "<option value='" + value.id + "'>" + value.city + "</option>";
            });
            $("#form__city").html(output);
        })
    }
});