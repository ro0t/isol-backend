import '../jquery-ui/jquery-ui.js';
import swal from 'sweetalert2';

export default class OrderMenuItems {

    constructor() {

        let self = this;

        $('.sortable').sortable({
            axis: 'y',
            update: function(event, ui) {

                let data = $(this).sortable('serialize')

                axios.post('/categories/order/menu/', data)
                    .then( res => {
                        /* 😍 It worked 😍 */
                        note.success('Success', res.data.message, { duration: 6 });
                    })
                    .catch( e => {
                        swal( 'D@mn 😲', 'Couldn\'t order menu items, please check console for debug logs.', 'error' );
                        console.error('Debug', e);
                    });
            }
        });

    }

}
