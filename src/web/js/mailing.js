$(document).ready(function () {
    $.fn.serializeJSON = function serializeJSON() {
        var json = {};
        jQuery.map($(this).serializeArray(), function (n, i) {
            json[n['name']] = n['value'];
        });
        return json;
    };
    $('.placeholders input').serializeJSON()
    var $mailingForm = $('#mailingForm');

    $('#createMailing').on('click', function () {
        //set users id to active form
        var usersId = $('#usersGrid').yiiGridView('getSelectedRows');
        $mailingForm.find('#usersId').val(JSON.stringify(usersId));
        //set date to active form
        $mailingForm.find('#dateSend').val($('#widgetDateSend').val());
        $mailingForm.find('#placeholders').val(JSON.stringify($('.placeholders input').serializeJSON()));

        //submit form
        $mailingForm.submit();
    });

    //set template id to active form
    $('#templatesGrid').on('grid.radiochecked', function (ev, key, val) {
        $mailingForm.find('#templateId').val(val);
    });

});
