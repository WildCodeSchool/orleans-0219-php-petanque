$(document).ready(() => {
    $('#commButton').addClass('btn_toggle_member_dark').removeClass('btn_toggle_member');
    sortMembers();
    checkButton();
})

let state  = 'commission';

function checkButton(){
    $('#commButton').on('click', () => {
        state = 'commission';
        $('#commButton').addClass('btn_toggle_member_dark').removeClass('btn_toggle_member');
        $('#salaButton').removeClass('btn_toggle_member_dark').addClass('btn_toggle_member');
        $('#comiteButton').removeClass('btn_toggle_member_dark').addClass('btn_toggle_member');
        sortMembers();
    })
    $('#salaButton').on('click', () => {
        state = 'salaried';
        $('#salaButton').addClass('btn_toggle_member_dark').removeClass('btn_toggle_member');
        $('#commButton').removeClass('btn_toggle_member_dark').addClass('btn_toggle_member');
        $('#comiteButton').removeClass('btn_toggle_member_dark').addClass('btn_toggle_member');
        sortMembers();
    })
    $('#comiteButton').on('click', () => {
        state = 'committee';
        $('#comiteButton').addClass('btn_toggle_member_dark').removeClass('btn_toggle_member');
        $('#salaButton').removeClass('btn_toggle_member_dark').addClass('btn_toggle_member');
        $('#commButton').removeClass('btn_toggle_member_dark').addClass('btn_toggle_member');
        sortMembers();
    })
}

function sortMembers(){
    $('.min_width_card_members').each((i, v) => {

        let attrCommission = Number(v.attributes[1].value);
        let attrSalaried = Number(v.attributes[2].value);
        let attrCommittee = Number(v.attributes[3].value);

        if(state === 'commission'){
            if(attrCommission === 1){
                $(v).show();
            }else{
                $(v).hide();
            }
        }
        if(state === 'salaried'){
            if(attrSalaried === 1){
                $(v).show();
            }else{
                $(v).hide();
            }
        }
        if(state === 'committee'){
            if(attrCommittee === 1){
                $(v).show();
            }else{
                $(v).hide();
            }
        }

    })
}