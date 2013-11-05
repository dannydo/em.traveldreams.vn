/**
 * Created by TinVo on 10/29/13.
 */
var nSentences = 0;
var nSentenceReal = 0;

function checkExistWord(){
    var word = $("#word").val();
    $("#vi-meaning").val("");
    $.ajax({
        type: "POST",
        url: "/add-word/check-word",
        data: {word : word},
        success: function(data){
            var str="";
            $.each(data, function(index, value){
                str += "<li>";
                str += "<b>" + value.word + ": </b>";
                str += "<i>" +  value.meaning + " </i>";
                str += "<button type='button' class='btn btn-default btn-sm btn-edit' wordId='" + value.wordId + "'>";
                str += "<span class='glyphicon glyphicon-pencil'></span>";
                str += "</button></li>";
            });
            $("#existWordList").html(str);

            if(str == ""){
                $.ajax({
                    type: "POST",
                    url: "dictionary/index/get-word",
                    data: {word : word},
                    success: function(data){
                        $("#vi-meaning").val(data.Definition)
                    },
                    dataType: "json"
                });
            }
        },
        dataType: "json"
    });
}

function parseSentenceHTML(lang, nSentences, nSentenceReal){
    var htmlID = lang + "-sentence-" + nSentences;
    var htmlName = "sentence[" + nSentences +"][" + lang + "]";

    var sentenceHTML = "";
    sentenceHTML += "<div class=\"form-group\">";
    sentenceHTML += "  <label for=\"" + htmlID + "\" class=\"col-lg-3 control-label\">Sentence #" + nSentenceReal + "</label>";
    sentenceHTML += "  <div class=\"col-lg-7\">";
    sentenceHTML += "    <input type=\"text\" class=\"form-control\" id=\"" + htmlID + "\" name=\"" + htmlName + "\">";
    sentenceHTML += "  </div>";
    sentenceHTML += "  <div class=\"col-lg-2\">";
    sentenceHTML += "    <button type=\"button\" class=\"btn btn-default del-sentence\" senId=\"" + nSentences + "\">";
    sentenceHTML += "      <span class=\"glyphicon glyphicon-remove\"></span>";
    sentenceHTML += "    </button>";
    sentenceHTML += "  </div>";
    sentenceHTML += "</div>";

    return sentenceHTML;
}

function addSentence(nSentences, nSentenceReal){
    var enHTML = parseSentenceHTML('en', nSentences, nSentenceReal);
    var viHTML = parseSentenceHTML('vi', nSentences, nSentenceReal);
    $("#en-sentence-container").append(enHTML);
    $("#vi-sentence-container").append(viHTML);


}

function updateSentenceLabel(id) {
    $('#'+id).find('.form-group').each(function(index) {
        $(this).find('label').first().html('Sentence #' + (index+1));
    });
}

//tags
$('#txtTags').tagsinput();

$('#txtTags').tagsinput('input').typeahead({
    prefetch: '/tag/get-tags'
}).bind('typeahead:selected', $.proxy(function (obj, datum) {
        this.tagsinput('add', datum.value);
        this.tagsinput('input').typeahead('setQuery', '');
    }, $('#txtTags')));
//end tags

window.onload = function() {
    addSentence(++nSentences, ++nSentenceReal);
    $(".add-sentence").click(function(e){
        addSentence(++nSentences, ++nSentenceReal)
    });


    $('#word').typeahead({
        name: 'dictionary',
        remote: '/dictionary/index/dictionary?word=%QUERY',
        limit: 10,
        minLength: 3
    });

    $('#word').on('change', checkExistWord);

    $('#word').bind('typeahead:selected', function(obj, datum, name) {
        checkExistWord();
    })

    $('#word').keyup(function(e){
        if(e.keyCode == 13)
        {
            $(".tt-query").focus();
        }
    });

    $('.tt-query').css('background-color','#fff');

    $(".btn-addWord").click(function(e){
        var word = $('#word').val();
        var enMeaning = $('#en-meaning').val();

        if((word == null) || (word == '')) {
            $(".error-message").html('<div class="alert alert-danger">Please add a word!</div>');
            $("#word").parent().parent(".form-group").addClass('has-error');
            return false;
        }else{
            if((enMeaning==null || enMeaning == '')){
                $(".error-message").html('<div class="alert alert-danger">Please add English meaning!</div>');
                $("#en-meaning").parent().parent(".form-group").addClass('has-error');
                return false;
            }
        }

        $("#add-word-form").submit();
        return true;
    });

    $(document).on('click', ".btn-edit", function(){
        var wordId = $(this).attr('wordId');
        location.href = "library/show-list/wordId/" + wordId;
    });

    $(document).on('click', ".del-sentence", function(){
        var senId = $(this).attr('senId');
        $("button[senId='" + senId + "']").parent().parent().remove();
        updateSentenceLabel("en-sentence-container");
        updateSentenceLabel("vi-sentence-container");

        nSentenceReal = nSentenceReal - 1;
    });
}
