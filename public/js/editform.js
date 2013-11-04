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
        '<input type="hidden" name="approve-sentenceVI[]" id="approveSentenceVI-'+ nSentence + '" value="0">' +
        '<button type="button" class="btn  btn-default" onclick="approveSentence(' + nSentence + ', '+ "'VI'" + ')" id="btnSentenceVI' + nSentence + '">' +
        '<span class="glyphicon glyphicon-ok"></span></button>' +
        '<button type="button" onclick="deleteSentence(' + nSentence + ', 0)" class="btn  btn-default "><span class="glyphicon glyphicon-remove"></span></button>' +
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
        '<input type="hidden" name="approve-sentenceEN[]" id="approveSentenceEN-'+ nSentence + '" value="0">' +
        '<button type="button" class="btn btn-default" onclick="approveSentence(' + nSentence + ', ' + "'EN'" + ')" id="btnSentenceEN' + nSentence + '">' +
        '<span class="glyphicon glyphicon-ok"></span></button>' +
        '<button type="button" onclick="deleteSentence(' + nSentence + ', 0)" class="btn  btn-default "><span class="glyphicon glyphicon-remove"></span></button>' +
        '</div>' +
        '</div>';

    $('#sentencesEN').append($html);

    nTotalEN++; nTotalVI++;
    $('#tabEN').html('English (' + nApprovedEN + '/' + nTotalEN + ')');
    $('#tabVI').html('Vietnamese (' + nApprovedVI + '/' + nTotalVI + ')');
}

function updateSentenceLabel(id) {
    $('#'+id).find('.form-group').each(function(index) {
        $(this).find('label').first().html('Sentence #' + (index+1));
    });
}

function deleteSentence(nSentence, sentenceId) {
    if($('#approveSentenceEN-' + nSentence).val() == 1) nApprovedEN--;
    if($('#approveSentenceVI-' + nSentence).val() == 1) nApprovedVI--;

    $('#sentenceVI-' + nSentence).remove();
    $('#sentenceEN-' + nSentence).remove();

    nTotalEN--; nTotalVI--;
    $('#tabEN').html('English (' + nApprovedEN + '/' + nTotalEN + ')');
    $('#tabVI').html('Vietnamese (' + nApprovedVI + '/' + nTotalVI + ')');

    nSentenceReal = nSentenceReal - 1;
    updateSentenceLabel('sentencesEN');
    updateSentenceLabel('sentencesVI');

    if(sentenceId > 0) {
        var str = $('#delete-sentence').val() + sentenceId + ',';
        $('#delete-sentence').val(str);
    }
}

function approveMeaning(meaningId, language) {
    var objTextBox = $('#meaning' + language);
    if (objTextBox.val() == '') {
        alert('You can not approve because meaning is empty.')
        return;
    }

    var obj = $('#btnMeaning'+meaningId);
    var id = '#approve-meaning' + language;

    if($(id).val() == 0) $(id).val(1);
    else $(id).val(0)

    updateButton(obj, objTextBox, language, $(id).val());
}

function approveSentence(nSentence, language) {
    var objTextBox = $('input#sentence'+ language + '-' + nSentence);

    if (objTextBox.val() == '') {
        alert('You can not approve because sentence is empty.')
        return;
    }

    var obj = $('#btnSentence' + language + nSentence);
    var id = '#approveSentence' + language + '-' + nSentence;

    if($(id).val() == 0) $(id).val(1);
    else $(id).val(0)

    updateButton(obj, objTextBox, language, $(id).val());
}

function updateButton(obj, objTextBox, language, isApproved) {
    if(isApproved == 1) {
        if (language == 'EN') nApprovedEN++;
        if (language == 'VI') nApprovedVI++;
        $(obj).attr('class', 'btn btn-success');
        $(objTextBox).attr('readonly','readonly');
    } else {
        if (language == 'EN') nApprovedEN--;
        if (language == 'VI') nApprovedVI--;
        $(obj).attr('class', 'btn btn-default');
        $(objTextBox).removeAttr('readonly','readonly');
    }

    $('#tabEN').html('English (' + nApprovedEN + '/' + nTotalEN + ')');
    $('#tabVI').html('Vietnamese (' + nApprovedVI + '/' + nTotalVI + ')');
}

$('#btnAddVoice').click(function() {
    $('#displayAddVoice').append($('#controlAddVoice').html());
});

$('.btnRemoveVoiceExists').click(function() {
    $(this).parent().parent().remove();
    var strId = $('#arrIdVoiceDelete').val() + $(this).attr('id') + ',';
    $('#arrIdVoiceDelete').val(strId);
});

$('.btnApproveVoiceExists').click(function() {
    var elem = $(this).parent().parent().children().first();
    if($(elem).val() == 0) {
        $(elem).val(1)
        $(this).removeClass('btn btn-default')
        $(this).addClass('btn btn-success');
    }
    else {
        $(elem).val(0)
        $(this).removeClass('btn btn-success')
        $(this).addClass('btn btn-default');
    }
});
