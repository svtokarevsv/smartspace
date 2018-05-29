document.addEventListener('DOMContentLoaded', function (e) {
    
    // 1. just getting value from html
    $('#resume__add_tag').keyup(function (e) {
        var searchWord = $(this).val();        
        getTagsBySearchWord(searchWord);

    })

    // auto complete
    function getTagsBySearchWord(searchWord){
        $.getJSON(ROOT_URI + "tag/ajax_getTagsByUserInput", {searchWord}, function(data){
            var arr = [];
            for (let i = 0; i < data.tags.length; i++) {
                arr.push(data.tags[i].keyword);                
            }
            $('#resume__add_tag').autocomplete(                
                {source: arr} // must be {source:array of value}
            );
        })
    }

    var tags = [];
    // add tags
    $('#resume__submit_tag').click(function (e) {
        if($.inArray($('#resume__add_tag').val(), tags) == -1){
            tags.push($('#resume__add_tag').val());
            $('#resume__tags').append($('#resume__add_tag').val() + ',');
            $('#resume__tag_list').append("<li>"+$('#resume__add_tag').val());
            $('#resume__add_tag').val('');
        }   
        return false;
    })

    // Clear subtasks
    $('#resume__clear_tag').click(function (e) {
        tags = [];
        $('#resume__tags').empty();
        $('#resume__tag_list').empty();
        $('#resume__add_tag').val('');
        return false;
    })


})
