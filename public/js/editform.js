/**
 * Created with JetBrains PhpStorm.
 * User: van.dao
 * Date: 10/30/13
 * Time: 8:17 PM
 * To change this template use File | Settings | File Templates.
 */

$('#myTab a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
});

$('#tabEN').html('English (' + nApprovedEN + '/' + nTotalEN + ')');
$('#tabVI').html('Vietnamese (' + nApprovedVI + '/' + nTotalVI + ')');

$('#txtTags').tagsinput();

$('#txtTags').tagsinput('input').typeahead({
    prefetch: '/tag/get-tags'
}).bind('typeahead:selected', $.proxy(function (obj, datum) {
        this.tagsinput('add', datum.value);
        this.tagsinput('input').typeahead('setQuery', '');
    }, $('#txtTags')));

function addSentences() {
    nSentence = nSentence + 1;
    nSentenceReal = nSentenceReal + 1;
    $html = '<div class="form-group" id="sentenceVI-' + nSentence +'">' +
        '<input type="hidden" name="id-sentencesVI[]" value="">' +
        '<label for="sentenceVI-' + nSentence + '" class="col-lg-3 control-label">Sentence #' + nSentenceReal + '</label>' +
        '<div class="col-lg-7">' +
        '<input type="text" name="content-sentencesVI[]" class="form-control" id="sentenceVI-' + nSentence + '" value="">' +
        '</div>' +
        '<div class="col-lg-2">' +
        '<button type="button" class="btn  btn-default" disabled="disabled"><span class="glyphicon glyphicon-ok"></span></button>' +
        '<button type="button" onclick="deleteSentence(' + nSentence + ')" class="btn  btn-default "><span class="glyphicon glyphicon-remove"></span></button>' +
        '</div>' +
        '</div>';

    $('#sentencesVI').append($html);

    $html = '<div class="form-group" id="sentenceEN-' + nSentence +'">' +
        '<input type="hidden" name="id-sentencesEN[]" value="">' +
        '<label for="sentenceEN-' + nSentence + '" class="col-lg-3 control-label">Sentence #' + nSentenceReal + '</label>' +
        '<div class="col-lg-7">' +
        '<input type="text" name="content-sentencesEN[]" class="form-control" id="sentenceEN-' + nSentence + '" value="">' +
        '</div>' +
        '<div class="col-lg-2">' +
        '<button type="button" class="btn btn-default" disabled="disabled"><span class="glyphicon glyphicon-ok"></span></button>' +
        '<button type="button" onclick="deleteSentence(' + nSentence + ')" class="btn  btn-default "><span class="glyphicon glyphicon-remove"></span></button>' +
        '</div>' +
        '</div>';

    $('#sentencesEN').append($html);
}

function updateSentenceLabel(id) {
    $('#'+id).find('.form-group').each(function(index) {
        $(this).find('label').first().html('Sentence #' + (index+1));
    });
}

function deleteSentence(nSentence) {
    $('#sentenceVI-' + nSentence).remove();
    $('#sentenceEN-' + nSentence).remove();

    nSentenceReal = nSentenceReal - 1;
    updateSentenceLabel('sentencesEN');
    updateSentenceLabel('sentencesVI');
}

function ajaxDeleteSentence(nSentence, sentenceId) {
    if (confirm("Are you sure delete?")) {
        var objEN = $('#sentenceEN-' + nSentence);
        var btnEN = $(objEN).find('[id^="btnSentence"]')[0];
        if($(btnEN).attr('class').indexOf('btn-default') >= 0) {
            nTotalEN--;
        } else {
            nApprovedEN--; nTotalEN--;
        }
        $('#tabEN').html('English (' + nApprovedEN + '/' + nTotalEN + ')');
        $(objEN).remove();

        var objVI = $('#sentenceVI-' + nSentence);
        var btnVI = $(objVI).find('[id^="btnSentence"]')[0];
        if($(btnVI).attr('class').indexOf('btn-default') >= 0) {
            nTotalVI--;
        } else {
            nApprovedVI--; nTotalVI--;
        }
        $('#tabVI').html('Vietnamese (' + nApprovedVI + '/' + nTotalVI + ')');
        $(objVI).remove();

        nSentenceReal = nSentenceReal - 1;
        updateSentenceLabel('sentencesEN');
        updateSentenceLabel('sentencesVI');

        $.ajax({url:"/sentence/delete/"+ sentenceId,success:function(result){

        }});
    }
}

function approveMeaning(meaningId, language) {
    var obj = $('#btnMeaning'+meaningId);
    var isApproved = updateButton(obj, language);

    $.ajax({url:"/meaning/approve/"+ meaningId + "/" + isApproved,success:function(result){

    }});
}

function approveSentence(sentenceId, language) {
    var obj = $('#btnSentence'+sentenceId);
    var isApproved = updateButton(obj, language);

    $.ajax({url:"/sentence/approve/"+ sentenceId + "/" + isApproved,success:function(result){

    }});
}

function updateButton(obj, language) {
    var strClass = $(obj).attr('class');
    var isApproved = 0;
    if(strClass.indexOf('btn-default') >= 0) {
        if (language == 'EN') nApprovedEN++;
        if (language == 'VI') nApprovedVI++;
        $(obj).attr('class', 'btn btn-success');
        isApproved = 1;
    } else {
        if (language == 'EN') nApprovedEN--;
        if (language == 'VI') nApprovedVI--;
        $(obj).attr('class', 'btn btn-default');
        isApproved = 0;
    }

    $('#tabEN').html('English (' + nApprovedEN + '/' + nTotalEN + ')');
    $('#tabVI').html('Vietnamese (' + nApprovedVI + '/' + nTotalVI + ')');
    return isApproved;
}
