$(document).ready(function () {
    var $mailingForm = $('#mailingForm');

    $('#createMailing').on('click', function () {
        //set users id to active form
        var usersId = $('#usersGrid').yiiGridView('getSelectedRows');
        $mailingForm.find('#usersId').val(JSON.stringify(usersId));
        //set date to active form
        $mailingForm.find('#dateSend').val($('#widgetDateSend').val());
        $mailingForm.submit();
    });

    //set template id to active form
    $('#templatesGrid').on('grid.radiochecked', function(ev, key, val) {
        $mailingForm.find('#templateId').val(val);
    });

});