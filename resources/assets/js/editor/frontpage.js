import '../jquery-ui/jquery-ui.js';

export default class Frontpage {

    constructor() {

        $('.frontpage-sortable').sortable();

        this.layout = {
            first:  { size: 'small', type: 'manufacturer', data: 'M:FACOM' },
            second: { size: 'large', type: 'manufacturer', data: 'M:FESTOOL' },
            third:  { size: 'large', type: 'manufacturer', data: 'M:SPIT' },
            fourth: { size: 'small', type: 'news', data: 'IGW:NEWS' },
        }

        $('.frontpage-sortable').find('.tile').click(this.changeTileType.bind(this));

        $('.frontpage-type-editor .underlay').click( () => {
            $('.frontpage-type-editor').hide();
        })

        $('.frontpage-type-editor .save').click( () => {
            $('.frontpage-type-editor').hide();
        })

        $('.frontpage-type-editor .cancel').click( () => {
            $('.frontpage-type-editor').hide();
        })

    }

    changeTileType() {

        $('.frontpage-type-editor').show();

    }

}
