let classie = require('desandro-classie');
let swal = require('sweetalert2');

class Links {

    activate() {

        this.links = document.querySelectorAll('a');

        this.links.forEach((link) => {

            // Delete link?
            if( classie.has(link, 'delete') ) {
                this.attachDeleteConfirmationEvent(link);
            }

        })

    }

    attachDeleteConfirmationEvent( link ) {

        link.addEventListener('contextmenu', (e) => { e.preventDefault(); e.target.click(); });

        link.addEventListener('click', (e) => {

            e.preventDefault();
            let currentLink = e.target;

            swal({
              title: 'Are you sure',
              text: "You want to delete this record?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#38465A',
              cancelButtonColor: '#AC5252',
              confirmButtonText: 'Delete!'
            }).then((result) => {

                if (!result.value) {
                    e.preventDefault();
                    return;
                }

                window.location.href = currentLink.getAttribute('href');

            });

        });

    }

}

module.exports = new Links();
