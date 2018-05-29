document.addEventListener('DOMContentLoaded', function (e) {
    
    // GET CITIES by SELECTED COUNTRY
    // 1. just getting value from html
    $('#form__country').change(function (e) {
       var countryId = $(this).val(); // get value from dd list
        getCityByCountryId(countryId); // pass the value to the function below
    })

    function getCityByCountryId(countryId){
        var output = "<option value=''>-- Select City of Residence --</option>"; // this will goes to html

        // 2. make ajax request
        $.getJSON(ROOT_URI + "geo/ajax_getCitiesByCountryId", {countryId}, function (data) {
            // go this url: www.smartspace/geo/ajax_getCitiesByCountryId?countryId=2; 
            // go this url and pass countryId=2 to $_GET['countryId']
            // function(data) is called when responce is received

            // 5. use the cities from database, change the dd list
            $.each(data["cities"], function(index, value){          
                output += "<option value='" + value.id + "'>" + value.city + "</option>";
            })
            $("#form__city").html(output);
        })
    }


    // GET Schools by Country
    $('#form__schoolLoc').change(function (e) {
        var countryId = $(this).val(); 
         getSchoolsByCountryId(countryId);
     })
 
     function getSchoolsByCountryId(countryId){
         var output = "<option value=''>-- Select your School --</option>"; 
 
         $.getJSON(ROOT_URI + "Education/ajax_getSchoolsByCountryId", {countryId}, function (data) {
             $.each(data["schools"], function(index, value){   
                        
                 output += "<option value='" + value.id + "'>" + value.school_name + "</option>";
             })
             $("#form__school").html(output);
         })
     }
 

    // GET PROGRAMS by SELECTED SCHOOL
    $('#form__school').change(function (e) {
        var schoolId = $(this).val();
        getProgramsBySchoolId(schoolId);
    })

    function getProgramsBySchoolId(schoolId){
        var output = "<option value=''>-- Select your Program --</option>";

        $.getJSON(ROOT_URI + "education/ajax_getProgramsBySchoolId", {schoolId}, function (data) {

            $.each(data["programs"], function(index, value){          
                output += "<option value='" + value.id + "'>" + value.program_name + "</option>";
            })
            $("#form__program").html(output);

        })
    }

})
