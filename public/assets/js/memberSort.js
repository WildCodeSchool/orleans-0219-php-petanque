$(document).ready(() => {
    sortMembers();
    checkButton();
})

let state  = 'commission';

function checkButton(){
    $('#commButton').on('click', () => {
        state = 'commission';
        sortMembers();
    })
    $('#salaButton').on('click', () => {
        state = 'salaried';
        sortMembers();
    })
    $('#comiteButton').on('click', () => {
        state = 'committee';
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