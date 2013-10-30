/**
 * Created by TinVo on 10/29/13.
 */
var nSentences = 0;

function checkExistWord(){
    var word = $("#word").val();
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
                str += "<button type='button' class='btn  btn-default btn-sm'>";
                str += "<span class='glyphicon glyphicon-pencil'></span>";
                str += "</button></li>";
            });
            $("#existWordList").html(str);
        },
        dataType: "json"
    });
}

function parseSentenceHTML(lang, id){
    var htmlID = lang + "-sentence-" + id;
    var htmlName = "sentence[" + id +"][" + lang + "]";

    var sentenceHTML = "";
    sentenceHTML += "<div class=\"form-group\">";
    sentenceHTML += "  <label for=\"" + htmlID + "\" class=\"col-lg-3 control-label\">Sentence #" + id + "</label>";
    sentenceHTML += "  <div class=\"col-lg-7\">";
    sentenceHTML += "    <input type=\"text\" class=\"form-control\" id=\"" + htmlID + "\" name=\"" + htmlName + "\">";
    sentenceHTML += "  </div>";
    sentenceHTML += "  <div class=\"col-lg-2\">";
    sentenceHTML += "    <button type=\"button\" class=\"btn btn-default del-sentence\" senId=\"" + id + "\">";
    sentenceHTML += "      <span class=\"glyphicon glyphicon-remove\"></span>";
    sentenceHTML += "    </button>";
    sentenceHTML += "  </div>";
    sentenceHTML += "</div>";

    return sentenceHTML;
}

function addSentence(id){
    var enHTML = parseSentenceHTML('en', id);
    var viHTML = parseSentenceHTML('vi', id);
    $("#en-sentence-container").append(enHTML);
    $("#vi-sentence-container").append(viHTML);
}

window.onload = function() {
    addSentence(++nSentences);
    $(".add-sentence").click(function(e){
        addSentence(++nSentences)
    });

    $(".btn-addWord").click(function(e){
        var word = $('#word').val();
        var enMeaning = $('#en-meaning').val();
        var viM  eaning = $('#vi-meaning').val();

    });

    $(document).on('click', ".del-sentence", function(){
        var senId = $(this).attr('senId');
        $("button[senId='" + senId + "']").parent().parent().remove();
    });
}