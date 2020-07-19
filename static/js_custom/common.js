/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function toast(msg, header, type = 'primary') {
    let toastPlaceHolder = $('#toastPlaceHolder');
    let toast = $('<div/>');
    toast.addClass('toast');
//            toast.attr('data-autohide', 'false');
    toast.attr('data-delay', '5000');
    toast.html(`<div class="toast-header alert-primary p-1 text-right" style="min-width:300px;">
                    <strong class="mr-auto pl-2 text-${type}">${header}</strong>
                    <button type="button" class="close float-right" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body alert-${type} p-1 px-3">
                    <ul class="pl-2 mb-1"><li>${msg}</li></ul>
                </div>`);
    toastPlaceHolder.append(toast);
    toast.toast('show');
    toast.on('hidden.bs.toast', function () {
        $(this).detach();
    });
}